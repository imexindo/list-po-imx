<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contracts extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $table = 't_contracts';

    protected $fillable = [
        'so',
        'spk',
        'tgl_bap',
        'tgl_cabut',
        'tgl_habis_sewa',
        'kode',
        'nama',
        'dc',
        'lok',
        'npwp',
        'total',
        'nnpwp',
        'tipe',
        'ref',
        'anpwp',
        'alamat',
        'ket',
        'tagihan',
        'keterangan',
        'kf_00',
        'kf_15',
        'kf_20',
        'kf_23',
        'kf_26',
        'kf_34',
        'kf_50',
        'kf_70',
        'kf_100',
        'kf_120', 'sd_70', 'sd_90', 'sd_90', 'db_60', 'db_80', 'db_100', 'db_150', 'db_200',
        'kode_idm',
        'contract_id',
        'group_contract_id',
        'region_id',
        'group_name',
        'total_pk',
        'total_sap',
        'user_id',
        'category_cabut_id'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_cabut_id', 'id');
    }

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function type_contracts()
    {
        return $this->hasMany(TypeContract::class, 'm_contract_id', 'contract_id');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_id', 'id');
    }

    public function contract_group()
    {
        return $this->belongsTo(Contract::class, 'group_contract_id', 'id');
    }


}
