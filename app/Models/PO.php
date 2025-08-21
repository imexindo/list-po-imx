<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PO extends Model
{
    use HasFactory;

    protected $table = 't_po';

    protected $fillable = [
        'no_seri',
        'spk',
        'category_id',
        'po',
        'so',
        'tgl_po',
        'tipe',
        'kode',
        'nama',
        'dc',
        'idm',
        'subkon',
        'bap',
        'kf_15',
        'kf_20',
        'kf_23',
        'kf_26',
        'kf_34',
        'kf_50',
        'kf_70',
        'kf_100',
        'kf_120',
        'start',
        'due',
        'sj',
        'cabut',
        'lok',
        'harga_sewa',
        'ket',
        'l_spk',
        'l_bap',
        'bulan_po',
        'tgl_spk',
        'tgl_kirim_unit',
        'tgl_dok_sj',
        'tgl_pasang',
        'tgl_bap',
        'tgl_dok_terima',
        'no_info_cancel',
        'no_goods_issued',
        'no_kapitalisasi',
        'bulan_po',
        'keterangan'
    ];

    public function category_by_menu()
    {
        return $this->belongsTo(Menu::class, 'category_id', 'id');
    }
}
