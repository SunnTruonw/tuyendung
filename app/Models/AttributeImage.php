<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttributeImage extends Model
{
    //
    protected $table = "attribute_images";
    protected $guarded = [];
    public function attribute()
    {
        return $this->belongsTo(Attribute::class, 'product_id', 'id');
    }
}
