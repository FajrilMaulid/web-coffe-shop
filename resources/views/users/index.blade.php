@extends('layouts.master')
@section('title', 'Pegawai')
@section('page-title', 'Manajemen Pegawai')

@section('content')
@section('content')
<div class="table-header">
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari pegawai..." onkeyup="searchTable('searchInput', 'userTable')">
    </div>
    <a href="{{ route('users.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
        <span>+ Tambah Pegawai</span>
    </a>
</div>

<div class="card">
    <table class="table" id="userTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($users as $user)
                <tr>
                    <td><strong>{{ $user->name }}</strong></td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td>{{ Str::limit($user->address ?? '-', 30) }}</td>
                    <td>
                        <a href="{{ route('users.edit', $user) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #999;">Belum ada pegawai</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
