<?php

namespace App\Models;

use App\Models\SupplierDetails;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $fillable = [
        'supplier_id',
        'product_name',
        'quantity',
    ];

    public function suppliers()
    {
        return $this->belongsTo(SupplierDetails::class);
    }
}
