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
        'ket'
    ];
}
