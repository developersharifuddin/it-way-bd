<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SupplierDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'supplier_name',
        'number',
        'date',
    ];
}
