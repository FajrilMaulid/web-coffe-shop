@extends('layouts.master')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<!-- MOBILE-FIRST EMBEDDED CSS - NO GRID SYSTEM -->
<style>
/* Container */
.dashboard-wrapper {
    width: 100%;
    max-width: 100%;
}

/* Stats Grid - Already Working */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
    margin-bottom: 24px;
}

/* Charts Section - Mobile First (Column) */
.charts-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 24px;
    width: 100%;
}

.chart-box,
.products-box {
    width: 100%;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 24px;
    box-sizing: border-box;
}

.chart-box {
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.chart-canvas-wrapper {
    flex: 1;
    position: relative;
    min-height: 320px;
    margin-top: 16px;
}

.products-box {
    min-height: 400px;
    display: flex;
    flex-direction: column;
}

.best-products-list {
    flex: 1;
    overflow-y: auto;
    margin-top: 16px;
}

/* Info Cards Section - Mobile First (Column) */
.info-cards-section {
    display: flex;
    flex-direction: column;
    gap: 20px;
    margin-bottom: 24px;
    width: 100%;
}

.info-card {
    width: 100%;
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 28px 24px;
    display: flex;
    align-items: center;
    gap: 24px;
    box-sizing: border-box;
}

.info-card-icon {
    flex-shrink: 0;
    font-size: 3.5rem;
}

.info-card-content {
    flex: 1;
}

.info-card-value {
    font-size: 3rem;
    margin-bottom: 4px;
    font-weight: 700;
    line-height: 1;
}

.info-card-label {
    color: #666;
    margin: 0;
    font-size: 13px;
    font-weight: 500;
    letter-spacing: 0.3px;
}

/* Desktop (769px+) - Make charts side by side */
@media (min-width: 769px) {
    .charts-section {
        flex-direction: row;
    }

    .chart-box {
        flex: 2;
    }

    .products-box {
        flex: 1;
    }

    .info-cards-section {
        flex-direction: row;
    }

    .info-card {
        flex: 1;
    }
}

/* Headings */
.section-title {
    font-size: 1.125rem;
    font-weight: 700;
    color: var(--dark);
    margin: 0;
    letter-spacing: -0.01em;
}

/* Product Item */
.product-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 0;
    border-bottom: 1px solid #e2e8f0;
}

.product-item:last-child {
    border-bottom: none;
}

.product-name {
    font-weight: 500;
    font-size: 14px;
}

/* Transaction Table Container */
.transactions-container {
    background: white;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    padding: 24px;
    margin-top: 24px;
    width: 100%;
    box-sizing: border-box;
    overflow-x: auto;
}

.transactions-container .card-header {
    font-size: 1.125rem;
    font-weight: 700;
    margin-bottom: 20px;
}
</style>

<!-- Dashboard Wrapper -->
<div class="dashboard-wrapper">

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon success"><i class="fas fa-money-bill-wave"></i></div>
            <div class="stat-details">
                <div class="stat-label">Penjualan Hari Ini</div>
                <div class="stat-value">Rp {{ number_format($todaySales, 0, ',', '.') }}</div>
            </div>
        </div>

        @if(auth()->user()->role === 'owner')
        <div class="stat-card">
            <div class="stat-icon primary"><i class="fas fa-calendar-week"></i></div>
            <div class="stat-details">
                <div class="stat-label">Penjualan Minggu Ini</div>
                <div class="stat-value">Rp {{ number_format($weekSales, 0, ',', '.') }}</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon purple"><i class="fas fa-calendar-alt"></i></div>
            <div class="stat-details">
                <div class="stat-label">Penjualan Bulan Ini</div>
                <div class="stat-value">Rp {{ number_format($monthSales, 0, ',', '.') }}</div>
            </div>
        </div>
        @endif

        <div class="stat-card">
            <div class="stat-icon warning"><i class="fas fa-file-invoice"></i></div>
            <div class="stat-details">
                <div class="stat-label">Total Transaksi</div>
                <div class="stat-value">{{ $totalTransactions }}</div>
            </div>
        </div>
    </div>

    @if(auth()->user()->role === 'owner')
    <!-- Charts Section (Mobile: Column, Desktop: Row) -->
    <div class="charts-section">
        <!-- Sales Chart -->
        <div class="chart-box">
            <h3 class="section-title">Grafik Penjualan (7 Hari Terakhir)</h3>
            <div class="chart-canvas-wrapper">
                <canvas id="salesChart" style="width: 100%; height: 100%;"></canvas>
            </div>
        </div>

        <!-- Best Products -->
        <div class="products-box">
            <h3 class="section-title">Produk Terlaris</h3>
            <div class="best-products-list">
                @forelse($bestProducts as $product)
                    <div class="product-item">
                        <span class="product-name">{{ $product->name }}</span>
                        <span class="badge badge-primary">{{ $product->total_sold }} terjual</span>
                    </div>
                @empty
                    <p style="text-align: center; color: #999; padding: 40px 20px;">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Info Cards (Mobile: Column, Desktop: Row) -->
    <div class="info-cards-section">
        <div class="info-card">
            <i class="fas fa-box info-card-icon" style="color: var(--primary);"></i>
            <div class="info-card-content">
                <h1 class="info-card-value" style="color: var(--primary);">{{ $totalProducts }}</h1>
                <p class="info-card-label">Total Produk Aktif</p>
            </div>
        </div>

        <div class="info-card">
            <i class="fas fa-exclamation-triangle info-card-icon" style="color: var(--danger);"></i>
            <div class="info-card-content">
                <h1 class="info-card-value" style="color: var(--danger);">{{ $lowStockProducts }}</h1>
                <p class="info-card-label">Produk Stock Menipis</p>
            </div>
        </div>

        <div class="info-card">
            <i class="fas fa-user-tie info-card-icon" style="color: var(--success);"></i>
            <div class="info-card-content">
                <h1 class="info-card-value" style="color: var(--success);">{{ $totalEmployees }}</h1>
                <p class="info-card-label">Total Pegawai</p>
            </div>
        </div>
    </div>
    @endif

    <!-- Recent Transactions -->
    <div class="transactions-container">
        <div class="card-header">Transaksi Terbaru</div>
        <table class="table">
            <thead>
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Tanggal</th>
                    @if(auth()->user()->role === 'owner')
                    <th>Pegawai</th>
                    @endif
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentTransactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->transaction_code }}</strong></td>
                        <td>{{ $transaction->created_at->format('d/m/Y H:i') }}</td>
                        @if(auth()->user()->role === 'owner')
                        <td>{{ $transaction->user->name }}</td>
                        @endif
                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td>
                            @if($transaction->status === 'completed')
                                <span class="badge badge-success">Selesai</span>
                            @elseif($transaction->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @else
                                <span class="badge badge-danger">Dibatalkan</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'owner' ? '5' : '4' }}" style="text-align: center; padding: 40px; color: #999;">
                            Belum ada transaksi
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div><!-- End Dashboard Wrapper -->

@endsection

@if(auth()->user()->role === 'owner')
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Sales Chart
    const ctx = document.getElementById('salesChart').getContext('2d');
    const salesData = @json($salesChart);

    const salesChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: salesData.map(d => d.date),
            datasets: [{
                label: 'Penjualan (Rp)',
                data: salesData.map(d => d.sales),
                borderColor: '#6F4E37',
                backgroundColor: 'rgba(111, 78, 55, 0.1)',
                tension: 0.4,
                fill: true,
                pointBackgroundColor: '#6F4E37',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            animation: {
                duration: 750,
                easing: 'easeInOutQuart'
            },
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString('id-ID');
                        }
                    }
                }
            }
        }
    });

    // ResizeObserver to handle chart resizing
    const chartCanvas = document.getElementById('salesChart');
    const chartContainer = chartCanvas.closest('.chart-box');

    const resizeObserver = new ResizeObserver(entries => {
        for (let entry of entries) {
            if (salesChart) {
                salesChart.resize();
                salesChart.update('none');
            }
        }
    });

    if (chartContainer) {
        resizeObserver.observe(chartContainer);
    }

    if (chartCanvas) {
        resizeObserver.observe(chartCanvas);
    }

    // Listen for sidebar toggle
    const sidebarToggleBtn = document.getElementById('sidebarToggle');
    if (sidebarToggleBtn) {
        sidebarToggleBtn.addEventListener('click', function() {
            setTimeout(() => {
                if (salesChart) {
                    salesChart.resize();
                    salesChart.update('resize');
                }
            }, 450);
        });
    }
</script>
@endpush
@endif
