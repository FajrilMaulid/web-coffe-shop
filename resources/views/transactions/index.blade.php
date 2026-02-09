@extends('layouts.master')

@section('title', 'Daftar Transaksi')
@section('page-title', 'Daftar Transaksi')

@section('content')
<div class="table-header">
    <div class="search-box">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari transaksi..." onkeyup="searchTable('searchInput', 'transactionTable')">
    </div>

    <div style="display: flex; gap: 10px; align-items: center;">
        <select id="exportFilter" class="form-control" style="width: 150px; cursor: pointer;">
            <option value="weekly">Minggu Ini</option>
            <option value="monthly">Bulan Ini</option>
        </select>
        <button onclick="exportTransactions()" class="btn btn-success" style="display: flex; align-items: center; gap: 8px;">
            <i class="fas fa-file-excel"></i> <span>Ekspor</span>
        </button>
        <a href="{{ route('transactions.create') }}" class="btn btn-primary" style="display: flex; align-items: center; gap: 8px;">
            <span>+ Transaksi Baru</span>
        </a>
    </div>
</div>

<div class="card">
    <table class="table" id="transactionTable">
        <thead>
            <tr>
                <th>Kode</th>
                <th>Tanggal</th>
                @if(auth()->user()->role === 'owner')
                <th>Kasir</th>
                @endif
                <th>Pelanggan</th>
                <th>Total</th>
                <th>Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td><strong>{{ $transaction->transaction_code }}</strong></td>
                    <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                    @if(auth()->user()->role === 'owner')
                    <td>{{ $transaction->user->name }}</td>
                    @endif
                    <td>{{ $transaction->customer_name ?? '-' }}</td>
                    <td><strong>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</strong></td>
                    <td><span class="badge badge-primary">{{ ucfirst($transaction->payment_method) }}</span></td>
                    <td>
                        <a href="{{ route('transactions.show', $transaction) }}" class="btn btn-primary btn-sm">Detail</a>
                        @if(auth()->user()->role === 'owner')
                            <form action="{{ route('transactions.destroy', $transaction) }}" method="POST" style="display: inline;" onsubmit="return confirmDelete()">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ auth()->user()->role === 'owner' ? '7' : '6' }}" style="text-align: center; padding: 40px; color: #999;">
                        Belum ada transaksi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@push('scripts')
<script>
function exportTransactions() {
    const filter = document.getElementById('exportFilter').value;
    window.location.href = "{{ route('transactions.export') }}?filter=" + filter;
}
</script>
@endpush
@endsection
