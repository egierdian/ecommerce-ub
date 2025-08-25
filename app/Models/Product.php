<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name','price','type','base_price_per_hour','holiday_price_per_hour','description','status','qty','slug'];
    public $timestamps = true;

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(ProductImage::class, 'product_id')
                    ->oldest(); 
    }
}
