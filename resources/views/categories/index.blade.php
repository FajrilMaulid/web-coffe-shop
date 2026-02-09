@extends('layouts.master')
@section('title', 'Kategori')
@section('page-title', 'Manajemen Kategori')

@section('content')
@section('content')
<div class="table-header">
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari kategori..." onkeyup="searchTable('searchInput', 'categoryTable')">
    </div>
    <a href="{{ route('categories.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
        <span>+ Tambah Kategori</span>
    </a>
</div>

<div class="card">
    <table class="table" id="categoryTable">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Jumlah Produk</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categories as $category)
                <tr>
                    <td><strong>{{ $category->name }}</strong></td>
                    <td>{{ $category->description ?? '-' }}</td>
                    <td><span class="badge badge-primary">{{ $category->products_count }} produk</span></td>
                    <td>
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm {{ $category->products_count > 0 ? 'disabled' : '' }}" {{ $category->products_count > 0 ? 'disabled' : '' }}>Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center; padding: 40px; color: #999;">Belum ada kategori</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
