@extends('layouts.master')

@section('title', 'Tambah Produk')
@section('page-title', 'Tambah Produk Baru')

@section('content')
<div style="display: flex; justify-content: center;">
    <div style="width: 100%; max-width: 800px;">
        <div class="card">
            <div class="card-header">Form Produk</div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="form-group">
                    <label for="category_id" class="form-label">Kategori *</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="name" class="form-label">Nama Produk *</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea name="description" id="description" class="form-control" rows="3">{{ old('description') }}</textarea>
                    @error('description')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="row" style="margin: 0;">
                    <div class="col" style="flex: 1; padding: 0 6px 0 0;">
                        <div class="form-group">
                            <label for="price" class="form-label">Harga *</label>
                            <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}" min="0" step="100" required>
                            @error('price')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col" style="flex: 1; padding: 0 0 0 6px;">
                        <div class="form-group">
                            <label for="stock" class="form-label">Stok *</label>
                            <input type="number" name="stock" id="stock" class="form-control" value="{{ old('stock', 0) }}" min="0" required>
                            @error('stock')
                                <small style="color: var(--danger);">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="image" class="form-label">Gambar Produk</label>
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                    @error('image')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <span>Produk Aktif</span>
                    </label>
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
