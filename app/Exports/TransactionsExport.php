<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths, WithStyles
{
    protected $startDate;
    protected $endDate;
    protected $userId;

    public function __construct($startDate, $endDate, $userId = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->userId = $userId;
    }

    /**
     * Get transactions within date range
     */
    public function collection()
    {
        $query = Transaction::with('user')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->orderBy('created_at', 'desc');

        // Filter by user if not owner
        if ($this->userId) {
            $query->where('user_id', $this->userId);
        }

        return $query->get();
    }

    /**
     * Define Excel column headers
     */
    public function headings(): array
    {
        return [
            'No Transaksi',
            'Tanggal',
            'Total (Rp)',
            'Metode Pembayaran',
            'Nama Pelanggan',
            'Kasir',
            'Status'
        ];
    }

    /**
     * Map data to Excel rows
     */
    public function map($transaction): array
    {
        return [
            $transaction->transaction_code,
            $transaction->created_at->format('d/m/Y H:i'),
            number_format($transaction->total_amount, 0, ',', '.'),
            ucfirst($transaction->payment_method),
            $transaction->customer_name ?? '-',
            $transaction->user->name ?? '-',
            ucfirst($transaction->status)
        ];
    }

    /**
     * Set column widths
     */
    public function columnWidths(): array
    {
        return [
            'A' => 20, // No Transaksi
            'B' => 18, // Tanggal
            'C' => 15, // Total
            'D' => 20, // Metode Pembayaran
            'E' => 25, // Nama Pelanggan
            'F' => 20, // Kasir
            'G' => 12, // Status
        ];
    }

    /**
     * Style the header row
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E2E8F0']
                ]
            ],
        ];
    }
}
