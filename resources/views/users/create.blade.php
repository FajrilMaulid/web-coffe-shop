@extends('layouts.master')
@section('title', 'Tambah Pegawai')
@section('page-title', 'Tambah Pegawai')

@section('content')
<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name" class="form-label">Nama *</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    @error('name')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Password *</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Konfirmasi Password *</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone" class="form-label">Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}">
                    @error('phone')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="address" class="form-label">Alamat</label>
                    <textarea name="address" id="address" class="form-control" rows="3">{{ old('address') }}</textarea>
                    @error('address')
                        <small style="color: var(--danger);">{{ $message }}</small>
                    @enderror
                </div>

                <div style="display: flex; gap: 12px; margin-top: 24px;">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
