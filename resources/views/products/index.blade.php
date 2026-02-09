@extends('layouts.master')

@section('title', 'Produk')
@section('page-title', 'Manajemen Produk')

@section('content')
<div class="table-header">
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari produk..." onkeyup="searchTable('searchInput', 'productTable')">
    </div>
    @if(auth()->user()->role === 'owner')
    <a href="{{ route('products.create') }}" class="btn btn-primary">+ Tambah Produk</a>
    @endif
</div>

<div class="card">
    <table class="table" id="productTable">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 60px; height: 60px; object-fit: cover; border-radius: 8px;">
                        @else
                            <div style="width: 60px; height: 60px; background: var(--secondary); border-radius: 8px; display: flex; align-items: center; justify-content: center; font-size: 24px;">☕</div>
                        @endif
                    </td>
                    <td><strong>{{ $product->name }}</strong></td>
                    <td>{{ $product->category->name }}</td>
                    <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                    <td>
                        <span class="badge badge-{{ $product->stock < 20 ? 'danger' : 'success' }}">
                            {{ $product->stock }}
                        </span>
                    </td>
                    <td>
                        @if($product->is_active)
                            <span class="badge badge-success">Aktif</span>
                        @else
                            <span class="badge badge-danger">Tidak Aktif</span>
                        @endif
                    </td>
                    @if(auth()->user()->role === 'owner')
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('products.destroy', $product) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                        </form>
                    </td>
                    @else
                    <td>
                        <a href="{{ route('products.edit', $product) }}" class="btn btn-warning btn-sm">Edit</a>
                    </td>
                    @endif
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                        Belum ada produk
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
