<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoryContract extends Model
{
    use HasFactory;

    protected $table = 'm_category_contracts';

    protected $fillable = [
        'name',
        'description'
    ];
}
