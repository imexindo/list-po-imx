<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $table = 'm_contract';

    protected $fillable = [
        'title', 'code', 'year', 'group_id'
    ];

    public function typeContracts()
    {
        return $this->hasMany(TypeContract::class, 'm_contract_id');
    }
}
