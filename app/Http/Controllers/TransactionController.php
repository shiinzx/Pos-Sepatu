<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\Installment;
use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $shoes = Shoe::where('stock', '>', 0)->get();
        return view('transactions.create', compact('shoes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:tunai,non-tunai',
            'payment_status' => 'required|in:lunas,cicilan',
            'shoes' => 'required|array',
            'shoes.*.id' => 'required|exists:shoes,id',
            'shoes.*.qty' => 'required|integer|min:1',
            'down_payment' => 'nullable|numeric|min:0'
        ]);

        DB::beginTransaction();
        try {
            $invoiceNumber = 'INV-' . strtoupper(Str::random(6));
            $totalAmount = 0;

            $transaction = Transaction::create([
                'invoice_number' => $invoiceNumber,
                'total_amount' => 0,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
            ]);

            foreach ($request->shoes as $item) {
                $shoe = Shoe::find($item['id']);
                
                if ($shoe->stock < $item['qty']) {
                    throw new \Exception("Stok sepatu {$shoe->name} tidak mencukupi.");
                }

                $discountedPrice = $shoe->discounted_price;
                $discountAmount = $shoe->price - $discountedPrice;
                $subtotal = $discountedPrice * $item['qty'];

                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'shoe_id' => $shoe->id,
                    'quantity' => $item['qty'],
                    'price' => $shoe->price,
                    'discount' => $discountAmount,
                    'subtotal' => $subtotal
                ]);

                $totalAmount += $subtotal;

                // Kurangi stok
                $shoe->decrement('stock', $item['qty']);
            }

            $transaction->update(['total_amount' => $totalAmount]);

            // Jika cicilan dan ada DP
            if ($request->payment_status == 'cicilan' && $request->filled('down_payment') && $request->down_payment > 0) {
                Installment::create([
                    'transaction_id' => $transaction->id,
                    'amount_paid' => $request->down_payment,
                    'payment_date' => now()
                ]);
            }

            LogHelper::record('Transaksi Baru', "Transaksi {$invoiceNumber} berhasil dibuat dengan total Rp " . number_format($totalAmount, 0, ',', '.'));
            DB::commit();

            return redirect()->route('transactions.show', $transaction->id)->with('success', 'Transaksi berhasil disimpan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Transaction $transaction)
    {
        $transaction->load('details.shoe', 'installments');
        
        $totalPaid = $transaction->installments->sum('amount_paid');
        $sisaTagihan = $transaction->total_amount - $totalPaid;
        
        if ($transaction->payment_status == 'lunas') {
            $sisaTagihan = 0;
        }

        return view('transactions.show', compact('transaction', 'totalPaid', 'sisaTagihan'));
    }

    public function payInstallment(Request $request, Transaction $transaction)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:1'
        ]);

        $totalPaid = $transaction->installments->sum('amount_paid');
        $sisaTagihan = $transaction->total_amount - $totalPaid;

        if ($request->amount_paid > $sisaTagihan) {
            return back()->with('error', 'Nominal pembayaran melebihi sisa tagihan.');
        }

        Installment::create([
            'transaction_id' => $transaction->id,
            'amount_paid' => $request->amount_paid,
            'payment_date' => now()
        ]);

        LogHelper::record('Pembayaran Cicilan', "Pembayaran cicilan untuk {$transaction->invoice_number} sebesar Rp " . number_format($request->amount_paid, 0, ',', '.'));

        // Cek jika sudah lunas
        if (($totalPaid + $request->amount_paid) >= $transaction->total_amount) {
            $transaction->update(['payment_status' => 'lunas']);
            LogHelper::record('Cicilan Lunas', "Transaksi {$transaction->invoice_number} telah lunas.");
        }

        return back()->with('success', 'Pembayaran cicilan berhasil dicatat.');
    }
}
