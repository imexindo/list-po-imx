<?php

namespace App\Exports;

use App\Models\Contracts;
use App\Models\Reports;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractsExportSum implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $from;
    protected $to;
    private $rowNumber = 1;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;

        $this->totalBiaya = \App\Models\Contracts::whereBetween('tgl_bap', [$this->from, $this->to])
                            ->sum('total_pk');
    }

    public function collection()
    {
        // return Reports::with('region', 'contract')
        //     ->when($this->from && $this->to, function($query) {
        //         $query->whereBetween('tgl_bap', [$this->from, $this->to]);
        //     })
        //     ->where('tagihan', 1)
        //     ->get();

        // return Reports::with('contract', 'region')
        //     ->select('contacts_id', 'region_id')
        //     ->when($this->from && $this->to, function($query) {
        //         $query->whereBetween('tgl_bap', [$this->from, $this->to]);
        //     })
        //     ->selectRaw('SUM(total_spk) as total_spk')
        //     ->selectRaw('SUM(db_60) as db_60')
        //     ->selectRaw('SUM(db_80) as db_80')
        //     ->selectRaw('SUM(db_100) as db_100')
        //     ->selectRaw('SUM(db_150) as db_150')
        //     ->selectRaw('SUM(db_200) as db_200')
        //     ->selectRaw('SUM(sd_70) as sd_70')
        //     ->selectRaw('SUM(sd_90) as sd_90')
        //     ->selectRaw('SUM(sd_120) as sd_120')
        //     ->selectRaw('SUM(kf_00) as kf_00')
        //     ->selectRaw('SUM(kf_15) as kf_15')
        //     ->selectRaw('SUM(kf_20) as kf_20')
        //     ->selectRaw('SUM(kf_23) as kf_23')
        //     ->selectRaw('SUM(kf_26) as kf_26')
        //     ->selectRaw('SUM(kf_34) as kf_34')
        //     ->selectRaw('SUM(kf_50) as kf_50')
        //     ->selectRaw('SUM(kf_70) as kf_70')
        //     ->selectRaw('SUM(kf_100) as kf_100')
        //     ->selectRaw('SUM(kf_120) as kf_120')
        //     ->selectRaw('SUM(total_biaya) as total_biaya')
        //     ->selectRaw('MAX(created_at) as latest_creation_date')
        //     ->groupBy('contacts_id', 'region_id')
        //     ->orderBy('latest_creation_date', 'desc')
        //     ->where('tagihan', 1)
        //     ->get();

        return Contracts::with('contract', 'region')
            ->select('contract_id', 'region_id', 'group_name')
            ->when($this->from && $this->to, function($query) {
                // $query->whereBetween('tgl_bap', [$this->from, $this->to]);
                $query->whereBetween('tgl_bap', [
                    $this->from . ' 00:00:00',
                    $this->to . ' 23:59:59'
                ]);
            })
            ->selectRaw('SUM(total_spk) as total_spk')
            ->selectRaw('SUM(db_60) as db_60')
            ->selectRaw('SUM(db_80) as db_80')
            ->selectRaw('SUM(db_100) as db_100')
            ->selectRaw('SUM(db_150) as db_150')
            ->selectRaw('SUM(db_200) as db_200')
            ->selectRaw('SUM(sd_70) as sd_70')
            ->selectRaw('SUM(sd_90) as sd_90')
            ->selectRaw('SUM(sd_120) as sd_120')
            ->selectRaw('SUM(kf_00) as kf_00')
            ->selectRaw('SUM(kf_15) as kf_15')
            ->selectRaw('SUM(kf_20) as kf_20')
            ->selectRaw('SUM(kf_23) as kf_23')
            ->selectRaw('SUM(kf_26) as kf_26')
            ->selectRaw('SUM(kf_34) as kf_34')
            ->selectRaw('SUM(kf_50) as kf_50')
            ->selectRaw('SUM(kf_70) as kf_70')
            ->selectRaw('SUM(kf_100) as kf_100')
            ->selectRaw('SUM(kf_120) as kf_120')
            ->selectRaw('SUM(total_pk) as total_biaya')
            ->selectRaw('MAX(created_at) as latest_creation_date')
            ->where('tagihan', 1)
            ->groupBy('contract_id', 'region_id', 'group_name')
            // ->orderBy('latest_creation_date', 'desc')
            ->orderBy('region_id')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Group',
            'Kode',
            'Kontrak',
            'Wilayah',
            'Jumlah SPK',
            'KF-00',
            'KF-15',
            'KF-20',
            'KF-23',
            'KF-26',
            'KF-34',
            'KF-50',
            'KF-70',
            'KF-100',
            'KF-120',
            'SD-70',
            'SD-90',
            'SD-120',
            'DB-60',
            'DB-80',
            'DB-100',
            'DB-150',
            'DB-200',
            'Total Biaya',
            // 'Grand Total'
        ];
    }

    public function map($contract): array
    {
        return [
            $this->rowNumber++,
            $contract->group_name,
            $contract->contract->code,
            $contract->contract->title . ' - ' . $contract->contract->year,
            $contract->region->code . ' - ' . $contract->region->dc_name,
            $contract->total_spk,
            $contract->kf_00,
            $contract->kf_15,
            $contract->kf_20,
            $contract->kf_23,
            $contract->kf_26,
            $contract->kf_34,
            $contract->kf_50,
            $contract->kf_70,
            $contract->kf_100,
            $contract->kf_120,
            $contract->sd_70,
            $contract->sd_90,
            $contract->sd_120,
            $contract->db_60,
            $contract->db_80,
            $contract->db_100,
            $contract->db_150,
            $contract->db_200,
            $contract->total_biaya,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);

        return [
            'A:E' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'F:W' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            1 => [
                'font' => ['bold' => true],
            ],
            'A:E' => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function columnFormats(): array
    {
        return [
            'X' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setCellValue('Z1', $this->totalBiaya);
            },
        ];
    }
}
