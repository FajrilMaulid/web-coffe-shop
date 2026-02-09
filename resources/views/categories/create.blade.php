@extends('layouts.master')
@section('title', 'Tambah Kategori')
@section('page-title', 'Tambah Kategori')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama Kategori *</label>
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

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
