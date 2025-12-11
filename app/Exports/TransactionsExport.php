<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TransactionsExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithEvents
{
    protected $transactions;
    protected $store;
    protected $type;
    protected $startDate;
    protected $endDate;

    public function __construct($transactions, $store, $type, $startDate, $endDate)
    {
        $this->transactions = $transactions;
        $this->store = $store;
        $this->type = $type;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection(): Collection
    {
        return $this->transactions;
    }

    public function headings(): array
    {
        return [
            'Tanggal',
            'Tipe',
            'Kategori',
            'Deskripsi',
            'Jumlah',
            'Dicatat Oleh',
        ];
    }

    public function map($transaction): array
    {
        // Show amount with +/- sign based on type
        $amount = $transaction->type === 'income' 
            ? $transaction->amount 
            : -$transaction->amount;
            
        return [
            $transaction->transaction_date->format('d/m/Y'),
            $transaction->type === 'income' ? 'Pemasukan' : 'Pengeluaran',
            $transaction->account->name,
            $transaction->description ?? '-',
            $amount,
            $transaction->user->name,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $rowCount = $this->transactions->count() + 1; // +1 for header
                
                // Calculate totals
                $totalIncome = $this->transactions->where('type', 'income')->sum('amount');
                $totalExpense = $this->transactions->where('type', 'expense')->sum('amount');
                $saldo = $totalIncome - $totalExpense;
                
                // Add empty row
                $rowCount++;
                
                // Add Total Pemasukan row
                $rowCount++;
                $sheet->setCellValue('D' . $rowCount, 'Total Pemasukan:');
                $sheet->setCellValue('E' . $rowCount, $totalIncome);
                $sheet->getStyle('D' . $rowCount . ':E' . $rowCount)->getFont()->setBold(true);
                $sheet->getStyle('E' . $rowCount)->getFont()->getColor()->setRGB('16a34a');
                
                // Add Total Pengeluaran row
                $rowCount++;
                $sheet->setCellValue('D' . $rowCount, 'Total Pengeluaran:');
                $sheet->setCellValue('E' . $rowCount, -$totalExpense);
                $sheet->getStyle('D' . $rowCount . ':E' . $rowCount)->getFont()->setBold(true);
                $sheet->getStyle('E' . $rowCount)->getFont()->getColor()->setRGB('dc2626');
                
                // Add Saldo row
                $rowCount++;
                $sheet->setCellValue('D' . $rowCount, 'SALDO:');
                $sheet->setCellValue('E' . $rowCount, $saldo);
                $sheet->getStyle('D' . $rowCount . ':E' . $rowCount)->getFont()->setBold(true);
                $sheet->getStyle('D' . $rowCount . ':E' . $rowCount)->getFill()
                    ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
                    ->getStartColor()->setRGB('f0f0f0');
            },
        ];
    }
}

