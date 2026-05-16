@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card text-white bg-primary shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-wallet"></i> Total Pendapatan</h5>
                <h3 class="fw-bold">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-success shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-box"></i> Sepatu Terjual</h5>
                <h3 class="fw-bold">{{ $totalShoesSold }} Pasang</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-warning shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-hand-holding-usd"></i> Piutang Cicilan</h5>
                <h3 class="fw-bold">Rp {{ number_format($pendingInstallments, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-white bg-danger shadow">
            <div class="card-body">
                <h5 class="card-title"><i class="fas fa-exclamation-triangle"></i> Stok Menipis</h5>
                <h3 class="fw-bold">{{ $lowStockShoes->count() }} Jenis</h3>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                <i class="fas fa-receipt"></i> Transaksi Terbaru
            </div>
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">Invoice</th>
                            <th>Tgl</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentTransactions as $trx)
                        <tr>
                            <td class="px-3 fw-bold">{{ $trx->invoice_number }}</td>
                            <td>{{ $trx->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                            <td>
                                @if($trx->payment_status == 'lunas')
                                    <span class="badge bg-success">Lunas</span>
                                @else
                                    <span class="badge bg-warning text-dark">Cicilan</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-3">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold text-danger">
                <i class="fas fa-bell"></i> Peringatan Stok
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush">
                    @forelse($lowStockShoes as $shoe)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $shoe->name }}
                            <span class="badge bg-danger rounded-pill">{{ $shoe->stock }} tersisa</span>
                        </li>
                    @empty
                        <li class="list-group-item text-success text-center"><i class="fas fa-check-circle"></i> Stok aman!</li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
