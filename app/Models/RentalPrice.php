<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class RentalPrice extends Model
{
    use HasFactory;
    protected $table = 'rental_prices';
    protected $fillable = ['product_id','date','spesial_price','status'];
    public $timestamps = true;
}
