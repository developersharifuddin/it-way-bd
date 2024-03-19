<?php

namespace App\Models;

use App\Models\Product;
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

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
