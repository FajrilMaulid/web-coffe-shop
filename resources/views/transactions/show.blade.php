@extends('layouts.master')

@section('title', 'Detail Transaksi')
@section('page-title', 'Detail Transaksi')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/pos.css') }}">
@endpush

@section('content')
<div class="d-flex justify-content-center w-100">
    <div class="receipt" style="width: 100%; max-width: 400px; margin: 0 auto;">
        <div class="receipt-header">
            <div class="receipt-title">☕ Coffee Shop</div>
            <div class="receipt-code">{{ $transaction->transaction_code }}</div>
            <div class="receipt-date">{{ $transaction->created_at->format('d F Y, H:i') }}</div>
            <div class="receipt-date">Kasir: {{ $transaction->user->name }}</div>
            @if($transaction->customer_name)
                <div class="receipt-date">Pelanggan: {{ $transaction->customer_name }}</div>
            @endif
        </div>

        <div class="receipt-items">
            @foreach($transaction->details as $detail)
                <div class="receipt-item">
                    <div class="receipt-item-info">
                        <div class="receipt-item-name">{{ $detail->product->name }}</div>
                        <div class="receipt-item-qty">{{ $detail->quantity }} x Rp {{ number_format($detail->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="receipt-item-price">
                        Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="receipt-total">
            <div class="receipt-total-label">Total:</div>
            <div class="receipt-total-amount">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</div>
        </div>

        <div class="receipt-footer">
            <p>Pembayaran: {{ ucfirst($transaction->payment_method) }}</p>
            <p style="margin-top: 12px;">Terima kasih atas kunjungan Anda!</p>
            <p>☕ Selamat menikmati ☕</p>
        </div>

        <div class="no-print" style="margin-top: 24px; display: flex; gap: 12px; justify-content: center;">
            <button onclick="window.print()" class="btn btn-primary">🖨️ Cetak</button>
            <a href="{{ route('transactions.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    .receipt, .receipt * {
        visibility: visible;
    }
    .receipt {
        position: absolute;
        left: 0;
        top: 0;
        width: 80mm;
    }
    .btn, .no-print {
        display: none !important;
    }
}
</style>
@endsection
