@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body p-4">
                <h4 class="mb-4"><i class="fas fa-plus-circle text-primary"></i> Tambah Data Sepatu</h4>
                
                <form action="{{ route('shoes.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label fw-bold">Nama Sepatu</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="category_id" class="form-label fw-bold">Kategori</label>
                            <select class="form-select @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                                <option value="" disabled selected>Pilih Kategori...</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="promo_id" class="form-label fw-bold">Promo / Diskon (Opsional)</label>
                            <select class="form-select @error('promo_id') is-invalid @enderror" id="promo_id" name="promo_id">
                                <option value="">Tidak ada promo</option>
                                @foreach($promos as $promo)
                                    <option value="{{ $promo->id }}" {{ old('promo_id') == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->name }} (Diskon {{ $promo->discount_percentage }}%)
                                    </option>
                                @endforeach
                            </select>
                            @error('promo_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="brand" class="form-label fw-bold">Merk / Brand</label>
                            <input type="text" class="form-control @error('brand') is-invalid @enderror" id="brand" name="brand" value="{{ old('brand') }}" required>
                            @error('brand')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="size" class="form-label fw-bold">Ukuran</label>
                            <input type="number" class="form-control @error('size') is-invalid @enderror" id="size" name="size" value="{{ old('size') }}" required>
                            @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="price" class="form-label fw-bold">Harga (Rp)</label>
                            <input type="number" class="form-control @error('price') is-invalid @enderror" id="price" name="price" value="{{ old('price') }}" required>
                            @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="stock" class="form-label fw-bold">Stok</label>
                            <input type="number" class="form-control @error('stock') is-invalid @enderror" id="stock" name="stock" value="{{ old('stock') }}" required>
                            @error('stock')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="description" class="form-label fw-bold">Deskripsi Tambahan</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('shoes.index') }}" class="btn btn-outline-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan Sepatu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
