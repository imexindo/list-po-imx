<?php

namespace App\Exports;

use App\Models\Contracts;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ContractsExportKontrakAll implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    protected $contacts_id;
    protected $from;
    protected $to;
    private $rowNumber = 1;

    public function __construct($contacts_id, $from = null, $to = null)
    {
        $this->contacts_id = $contacts_id;
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        $query = Contracts::with(['contract', 'type_contracts', 'region', 'category'])
            ->where('group_contract_id',  $this->contacts_id)
            ->where('tagihan', 1);

        if ($this->from && $this->to) {
            $query->whereBetween('tgl_bap', [$this->from, $this->to]);
        }

        return $query->orderBy('created_at', 'asc')->get();
    }


    public function headings(): array
    {
        return [
            'No.',
            'Tanggal BAP',
            'Kode Toko',
            'Nama',
            'SPK',
            'SO',
            'Tipe SO',
            'KONTRAK',
            'DC',
            'KODE KONTRAK',
            'Tanggal Habis Sewa',
            'Keterangan Cabut',
            'Tanggal Cabut',
            'STOP TAGIH',
            'Lok',
            'Ref',
            'Alamat',
            // 'KF-00',
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
            'Total PK',
            'Keterangan',
            'Nama NPWP',
            'No NNPWP',
            'ANPWP',
            // 'Total',
            'Dibuat',
            'Dirubah',
            'Keterangan SAP',
        ];
    }

    public function map($contract): array
    {
        $responseDc = Http::get(env('SAP_API') . '/api/dc');
        $dc = $responseDc->successful() ? collect($responseDc->json()) : collect();

        static $previousContractId = null;
        static $hasDisplayed = false;

        if ($contract->contract && $contract->contract->id !== $previousContractId) {
            $contractTitle = ($contract->contract->title ?? 'N/A');
            $contractYear = ($contract->contract->year ?? 'N/A');
            $typeContracts = $contract->type_contracts->map(function ($typeContract) {
                return $typeContract->type . ' ' . $typeContract->price;
            })->implode(', ');
            $previousContractId = $contract->contract->id;
            $hasDisplayed = false;
        }

        if (!$hasDisplayed) {
            $hasDisplayed = true;
            return [
                $this->rowNumber++,
                $contract->tgl_bap ? Carbon::parse($contract->tgl_bap)->format('d-m-Y') : '',
                $contract->kode,
                $contract->nama,
                $contract->spk,
                $contract->so,
                $contract->tipe,
                $contract->contract->title,
                $dc->firstWhere('cardcode', $contract->region_id)['CardName'] ?? 'Tidak Diketahui',
                $contract->contract->code,
                $contract->tgl_habis_sewa ? Carbon::parse($contract->tgl_habis_sewa)->format('d-m-Y') : '',
                $contract->category ? $contract->category->category : '',
                $contract->tgl_cabut ? Carbon::parse($contract->tgl_cabut)->format('d-m-Y') : '',
                $contract->tagihan ? '' : 'X',
                $contract->lok,
                $contract->ref,
                $contract->alamat,
                // $contract->kf_00,
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
                $contract->total_pk,
                $contract->keterangan,
                $contract->npwp,
                $contract->nnpwp,
                $contract->anpwp,
                // $contract->total,
                $contract->created_at ? Carbon::parse($contract->created_at)->format('d-m-Y') : '',
                $contract->updated_at ? Carbon::parse($contract->updated_at)->format('d-m-Y') : '',
                $contract->ket,
            ];
        }
        return [
            $this->rowNumber++,
            $contract->tgl_bap ? Carbon::parse($contract->tgl_bap)->format('d-m-Y') : '',
            $contract->kode,
            $contract->nama,
            $contract->spk,
            $contract->so,
            $contract->tipe,
            $contract->contract->title,
            $dc->firstWhere('cardcode', $contract->region_id)['CardName'] ?? 'Tidak Diketahui',
            $contract->contract->code,
            $contract->tgl_habis_sewa ? Carbon::parse($contract->tgl_habis_sewa)->format('d-m-Y') : '-',
            $contract->category ? $contract->category->category : '-',
            $contract->tgl_cabut ? Carbon::parse($contract->tgl_cabut)->format('d-m-Y') : '-',
            $contract->tagihan ? '' : 'X',
            $contract->lok,
            $contract->ref,
            $contract->alamat,
            // $contract->kf_00,
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
            $contract->total_pk,
            $contract->keterangan,
            $contract->npwp,
            $contract->nnpwp,
            $contract->anpwp,
            // $contract->total,
            $contract->created_at ? Carbon::parse($contract->created_at)->format('d-m-Y') : '',
            $contract->updated_at ? Carbon::parse($contract->updated_at)->format('d-m-Y') : '',
            $contract->ket,
        ];
    }


    public function styles(Worksheet $sheet)
    {
        $columns = array_merge(
            range('A', 'Z'),
            $this->getMultiLetterColumns('AA', 'AQ')

        );
        foreach ($columns as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        return [
            'A:C' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'D' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'E:O' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'I' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'P:Q' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'R:AI' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'AK:AL' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'AM' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            'AN:AP' => [
                'alignment' => ['horizontal' => 'center'],
            ],
            'AQ' => [
                'alignment' => ['horizontal' => 'left'],
            ],
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    private function getMultiLetterColumns($start, $end)
    {
        $columns = [];
        $current = $start;

        while ($current !== $end) {
            $columns[] = $current;
            $current = $this->nextColumn($current);
        }
        $columns[] = $end;

        return $columns;
    }

    private function nextColumn($column)
    {
        $length = strlen($column);
        $lastChar = $column[$length - 1];

        if ($lastChar === 'Z') {
            $prefix = substr($column, 0, -1);
            $nextPrefix = $this->nextColumn($prefix);
            return $nextPrefix . 'A';
        }

        return substr($column, 0, -1) . chr(ord($lastChar) + 1);
    }
}
