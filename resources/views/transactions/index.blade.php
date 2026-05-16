@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-secondary"><i class="fas fa-shopping-cart"></i> Data Transaksi</h4>
            <a href="{{ route('transactions.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus"></i> Transaksi Baru (Kasir)
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Invoice</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Metode</th>
                                <th class="px-4 py-3 text-end">Total Belanja</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center" width="150">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $trx)
                            <tr>
                                <td class="px-4 py-3 fw-bold">{{ $trx->invoice_number }}</td>
                                <td class="px-4 py-3">{{ $trx->created_at->format('d M Y H:i') }}</td>
                                <td class="px-4 py-3 text-capitalize">{{ $trx->payment_method }}</td>
                                <td class="px-4 py-3 text-end">Rp {{ number_format($trx->total_amount, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-center">
                                    @if($trx->payment_status == 'lunas')
                                        <span class="badge bg-success">Lunas</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Cicilan</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('transactions.show', $trx->id) }}" class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i> Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">Belum ada data transaksi.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
