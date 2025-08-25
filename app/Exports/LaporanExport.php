<?php

namespace App\Exports;

use App\Models\PO;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LaporanExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $category;
    private $rowNumber = 1;

    public function __construct($category = null)
    {
        $this->category = $category;
    }

    public function collection()
    {
        $query = PO::with('category_by_menu');

        if (!empty($this->category)) {
            $query->where('category_id', $this->category);
        }

        return $query->orderBy('category_id')->get();
    }

    public function headings(): array
    {
        return [
            'No.',
            'Category',
            'Nama',
            'IDM',
            'DC',
            'Subkon',
            'Tgl SPK',
            'SPK',
            'Tgl PO',
            'No Seri',
            'Bulan PO',
            'SPK Subkon',
            'Kode',
            'SO',
            'Lok',
            'KF-15',
            'KF-20',
            'KF-23',
            'KF-26',
            'KF-34',
            'KF-50',
            'KF-70',
            'KF-100',
            'KF-120',
            'Harga Sewa',
            'Tgl Mulai',
            'Tgl Batas Pasang',
            'Status Pasang',
            'Tgl Kirim Unit',
            'No Srt Jalan',
            'Tgl Dok SJ',
            'Tgl Pasang',
            'Tgl Bap',
            'SPK',
            'BAP',
            'Tgl Dok Diterima',
            'Keterangan',
            'No Good Issued',
            'No Kapitalisasi',
            'Created',
            'Ket SAP',
            
        ];
    }

    public function map($po): array
    {
        return [
            $this->rowNumber++,
            $po->category_by_menu ? $po->category_by_menu->name : '-',
            $po->nama,
            $po->idm,
            $po->dc,
            $po->subkon,
            $po->tgl_spk,
            $po->spk,
            $po->tgl_po,
            $po->no_seri,
            $po->bulan_po??'-',
            $po->spk_subkon??'-',
            $po->kode,
            $po->so,
            $po->lok,
            $po->kf_15,
            $po->kf_20,
            $po->kf_23,
            $po->kf_26,
            $po->kf_34,
            $po->kf_50,
            $po->kf_70,
            $po->kf_100,
            $po->kf_120,
            $po->harga_sewa,
            $po->start,
            $po->due,
            $po->tipe,
            $po->tgl_kirim_unit,
            $po->sj,
            $po->tgl_dok_sj,
            $po->tgl_bap,
            $po->tgl_pasang,
            $po->l_spk == 0 ? '🔲 Blank' : ($po->l_spk == 1 ? '✅ Accepted' : '❌ Canceled'),
            $po->l_bap == 0 ? '🔲 Blank' : ($po->l_bap == 1 ? '✅ Accepted' : '❌ Canceled'),
            $po->tgl_dok_terima,
            $po->keterangan,
            $po->no_goods_issued,
            $po->no_kapitalisasi,
            $po->created_at,
            $po->ket,
            
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}