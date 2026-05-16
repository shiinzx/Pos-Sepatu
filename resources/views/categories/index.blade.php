@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0 text-secondary"><i class="fas fa-tags"></i> Kategori Sepatu</h4>
            <a href="{{ route('categories.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                <i class="fas fa-plus"></i> Tambah Kategori
            </a>
        </div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="px-4 py-3">ID</th>
                                <th class="px-4 py-3">Nama Kategori</th>
                                <th class="px-4 py-3 text-center" width="200">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($categories as $category)
                            <tr>
                                <td class="px-4 py-3 align-middle">{{ $category->id }}</td>
                                <td class="px-4 py-3 align-middle fw-bold">{{ $category->name }}</td>
                                <td class="px-4 py-3 align-middle text-center">
                                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST">
                                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted">Belum ada data kategori.</td>
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
