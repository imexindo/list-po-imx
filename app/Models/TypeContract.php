<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TypeContract extends Model
{
    use HasFactory;

    protected $table = 'm_type_contract';

    protected $fillable = [
        'type', 'price', 'm_contract_id'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'm_contract_id');
    }
}
