@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white fw-bold d-flex justify-content-between align-items-center">
                <span><i class="fas fa-file-invoice"></i> Detail Transaksi: {{ $transaction->invoice_number }}</span>
                <span class="badge {{ $transaction->payment_status == 'lunas' ? 'bg-success' : 'bg-warning text-dark' }} fs-6">
                    {{ strtoupper($transaction->payment_status) }}
                </span>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-sm-6">
                        <p class="mb-1"><strong>Tanggal:</strong> {{ $transaction->created_at->format('d F Y H:i') }}</p>
                        <p class="mb-1"><strong>Metode:</strong> <span class="text-capitalize">{{ $transaction->payment_method }}</span></p>
                    </div>
                    <div class="col-sm-6 text-end">
                        <h5 class="mb-0 text-muted">Total Belanja</h5>
                        <h3 class="fw-bold text-primary">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</h3>
                    </div>
                </div>

                <h6 class="fw-bold border-bottom pb-2">Rincian Item</h6>
                <div class="table-responsive">
                    <table class="table table-bordered align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Item</th>
                                <th class="text-center">Harga</th>
                                <th class="text-center">Diskon</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transaction->details as $detail)
                            <tr>
                                <td>{{ $detail->shoe->name }}</td>
                                <td class="text-center">Rp {{ number_format($detail->price, 0, ',', '.') }}</td>
                                <td class="text-center text-danger">{{ $detail->discount > 0 ? '-Rp ' . number_format($detail->discount, 0, ',', '.') : '-' }}</td>
                                <td class="text-center">{{ $detail->quantity }}</td>
                                <td class="text-end fw-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-money-check-alt"></i> Pembayaran Cicilan
            </div>
            <div class="card-body">
                <ul class="list-group mb-3">
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total Tagihan:</span>
                        <strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between text-success">
                        <span>Sudah Dibayar:</span>
                        <strong>Rp {{ number_format($totalPaid, 0, ',', '.') }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between text-danger">
                        <span>Sisa Tagihan:</span>
                        <strong>Rp {{ number_format($sisaTagihan, 0, ',', '.') }}</strong>
                    </li>
                </ul>

                @if($transaction->payment_status == 'cicilan' && $sisaTagihan > 0)
                    <form action="{{ route('transactions.pay', $transaction->id) }}" method="POST" class="mt-3">
                        @csrf
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" name="amount_paid" class="form-control" placeholder="Nominal Bayar" required max="{{ $sisaTagihan }}" min="1">
                            <button class="btn btn-primary" type="submit">Bayar</button>
                        </div>
                    </form>
                @elseif($transaction->payment_status == 'lunas')
                    <div class="alert alert-success text-center">
                        <i class="fas fa-check-circle"></i> Transaksi ini sudah Lunas.
                    </div>
                @endif
            </div>
            @if($transaction->installments->count() > 0)
            <div class="card-footer bg-white">
                <h6 class="fw-bold text-muted mb-2">Riwayat Pembayaran</h6>
                <ul class="list-group list-group-flush small">
                    @foreach($transaction->installments as $inst)
                    <li class="list-group-item px-0 d-flex justify-content-between">
                        <span>{{ \Carbon\Carbon::parse($inst->payment_date)->format('d/m/Y') }}</span>
                        <span class="text-success fw-bold">+Rp {{ number_format($inst->amount_paid, 0, ',', '.') }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
