<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Shoe;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::sum('total_amount');
        $totalShoesSold = \App\Models\TransactionDetail::sum('quantity');
        
        $pendingInstallments = \App\Models\Transaction::where('payment_status', 'cicilan')->sum('total_amount') 
            - \App\Models\Installment::sum('amount_paid');

        $lowStockShoes = Shoe::where('stock', '<', 5)->get();

        $recentTransactions = Transaction::latest()->take(5)->get();

        return view('dashboard.index', compact('totalRevenue', 'totalShoesSold', 'pendingInstallments', 'lowStockShoes', 'recentTransactions'));
    }
}
