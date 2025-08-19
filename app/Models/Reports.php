<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reports extends Model
{
    use HasFactory;

    protected $table = 't_reports';
    
    protected $fillable = [
        'spk',
        'tgl_bap',
        'total_spk',
        'db_60',
        'db_80',
        'db_100',
        'db_150',
        'db_200',
        'sd_70',
        'sd_90',
        'sd_120',
        'kf_00',
        'kf_15',
        'kf_20',
        'kf_23',
        'kf_26',
        'kf_34',
        'kf_50',
        'kf_70',
        'kf_100',
        'kf_120',
        'total_biaya',
        'region_id',
        'contacts_id',
        'group_name',
        'group_contract_id',
        'tagihan',
        'category_cabut_id'
    ];

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contacts_id', 'id');
    }

    public function contract_group()
    {
        return $this->belongsTo(Contract::class, 'group_contract_id', 'id');
    }

    public function regionBy()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }
}
