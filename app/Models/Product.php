<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use App\Components\Recusive;

class Product extends Model
{
    //
    //use SoftDeletes;
    protected $table = "products";
    public $parentId = "parent_id";
    // public $fillable =['name'];
    protected $guarded = [];

    protected $appends = ['price_after_sale', 'slug_full', 'number_pay'];
    /**
     * type 1 admin đăng
     * type 2 user dăng
     */

    public function getPriceAfterSaleAttribute()
    {
        if ($this->attributes['sale']) {
            return   $this->attributes['price'] * (100 - $this->attributes['sale']) / 100;
        } else {
            return $this->attributes['price'];
        }
    }
    // tạo thêm thuộc tính slug_full
    public function getSlugFullAttribute()
    {
        return makeLink('product', $this->attributes['id'], $this->attributes['slug']);
    }
    // tạo thêm thuộc tính slug_full
    //   public function getPriceAttribute()
    //   {
    //     dd(transMoneyToView($this->attributes['price'],$this->attributes['donvi']));
    //       return transMoneyToView($this->attributes['price'],$this->attributes['donvi']);
    //   }
    // tạo thêm thuộc tính so sp ban dc
    public function getNumberPayAttribute()
    {
        //  dd($this);
        $total =  $this->stores()->whereIn('type', [2, 3])->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total;
        if ($total) {
            return $total;
        } else {
            return 0;
        }
    }

    // lấy thuộc tính sản phẩm
    public function attributes()
    {
        return $this
            ->belongsToMany(Attribute::class, ProductAttribute::class, 'product_id', 'attribute_id')
            ->withTimestamps();
    }

    public function attributeChilds()
    {
        return $this->hasMany(ProductAttributeChild::class, "product_id", "id");
    }

    // get images by relationship 1-nhieu  1 product có nhiều images sử dụng hasMany
    public function images()
    {
        return $this->hasMany(ProductImage::class, "product_id", "id");
    }
    // get tags by relationship nhieu-nhieu by table trung gian product_tags
    // 1 product có nhiều product_tags
    // 1 tag có nhiều product_tags
    // table trung gian product_tags chứa column product_id và tag_id
    public function tags()
    {
        return $this
            ->belongsToMany(Tag::class, ProductTag::class, 'product_id', 'tag_id')
            ->withTimestamps();
    }
    // get category by relationship 1 - nhieu
    // 1 category_products có nhiều product
    // 1 product có 1 category_products
    // use belongsTo để truy xuất ngược từ product lấy data trong table category
    public function category()
    {
        return $this->belongsTo(CategoryProduct::class, 'category_id', 'id');
    }

    public function stores()
    {
        return $this->hasMany(Store::class, "product_id", "id");
    }

    // public function comments()
    // {
    //     return $this
    //         ->belongsToMany(Comment::class, ProductComment::class, 'product_id', 'comment_id')
    //         ->withTimestamps();
    // }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function comments()
    {
        return $this->hasMany(ProductComment::class, "product_id", "id");
    }
    public function countComment()
    {
        return $this->hasMany(ProductComment::class, "product_id", "id")->select(ProductComment::raw('COUNT(id) as total'))->first()->total;
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    public function district()
    {
        return  $this->belongsTo(District::class, 'district_id', 'id');
    }
    public function commune()
    {
        return $this->belongsTo(Commune::class, 'commune_id', 'id');
    }

    public function points()
    {
        return $this->hasMany(Point::class, 'userorigin_id', 'id');
    }

    public function getTotalProductStore($id)
    {

        return $this->find($id)->stores()->select(\App\Models\Store::raw('SUM(quantity) as total'))->first()->total;
    }
    public function getTotalClickBuy($start = null, $end = null)
    {
        $result = $this->points();
        if ($start) {
            $result->where('points.created_at', '>=', $start);
        }
        if ($end) {
            $result->where('points.created_at', '<=', $end);
        }
        $result = $result->select(\App\Models\Point::raw('COUNT(id) as total'))->where('points.type', 3)->first()->total;
        return $result;
    }



    public static function getHtmlOption($parentId = "")
    {
        $data = self::all();
        $rec = new Recusive();
        // $prId=$this->parentId;
        return  $rec->categoryRecusive($data, 0, "parent_id", $parentId, "", "");
    }
    public function options()
    {
        return $this->hasMany(Option::class, "product_id", "id");
    }
}
