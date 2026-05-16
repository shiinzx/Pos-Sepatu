@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-secondary"><i class="fas fa-shoe-prints"></i> Data Sepatu</h4>
            <a href="{{ route('shoes.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus"></i> Tambah Sepatu
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">Nama Sepatu</th>
                                <th class="px-4 py-3">Kategori</th>
                                <th class="px-4 py-3">Merk</th>
                                <th class="px-4 py-3 text-center">Ukuran</th>
                                <th class="px-4 py-3 text-end">Harga</th>
                                <th class="px-4 py-3 text-center">Stok</th>
                                <th class="px-4 py-3 text-center" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($shoes as $shoe)
                            <tr>
                                <td class="px-4 py-3 fw-bold">
                                    {{ $shoe->name }}
                                    @if($shoe->promo && now()->between($shoe->promo->start_date, $shoe->promo->end_date))
                                        <span class="badge bg-danger ms-1"><i class="fas fa-tag"></i> Diskon {{ $shoe->promo->discount_percentage }}%</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3"><span class="badge bg-secondary">{{ $shoe->category->name }}</span></td>
                                <td class="px-4 py-3">{{ $shoe->brand }}</td>
                                <td class="px-4 py-3 text-center">{{ $shoe->size }}</td>
                                <td class="px-4 py-3 text-end">
                                    @if($shoe->promo && now()->between($shoe->promo->start_date, $shoe->promo->end_date))
                                        <span class="text-decoration-line-through text-muted small d-block">Rp {{ number_format($shoe->price, 0, ',', '.') }}</span>
                                        <span class="fw-bold text-danger">Rp {{ number_format($shoe->discounted_price, 0, ',', '.') }}</span>
                                    @else
                                        Rp {{ number_format($shoe->price, 0, ',', '.') }}
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <span class="badge {{ $shoe->stock > 5 ? 'bg-success' : 'bg-danger' }}">{{ $shoe->stock }}</span>
                                </td>
                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('shoes.destroy', $shoe->id) }}" method="POST">
                                        <a href="{{ route('shoes.edit', $shoe->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Hapus data sepatu ini?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data sepatu.</td>
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
