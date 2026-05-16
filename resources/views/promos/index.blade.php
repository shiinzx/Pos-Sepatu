@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-secondary"><i class="fas fa-percent"></i> Data Promo</h4>
            <a href="{{ route('promos.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus"></i> Tambah Promo
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama Promo</th>
                                <th class="px-4 py-3 text-center">Diskon (%)</th>
                                <th class="px-4 py-3">Periode</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-center" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promos as $promo)
                            @php
                                $isActive = now()->between($promo->start_date, $promo->end_date);
                            @endphp
                            <tr>
                                <td class="px-4 py-3 fw-bold">{{ $promo->name }}</td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge bg-danger fs-6">{{ $promo->discount_percentage }}%</span>
                                </td>
                                <td class="px-4 py-3 text-muted">
                                    {{ \Carbon\Carbon::parse($promo->start_date)->format('d M') }} - {{ \Carbon\Carbon::parse($promo->end_date)->format('d M Y') }}
                                </td>
                                <td class="px-4 py-3 text-center">
                                    @if($isActive)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('promos.destroy', $promo->id) }}" method="POST">
                                        <a href="{{ route('promos.edit', $promo->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus promo ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">Belum ada data promo.</td>
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
