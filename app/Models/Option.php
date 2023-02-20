<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    //
    protected $table="options";
    protected $guarded = [];
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'id');
    }
}
