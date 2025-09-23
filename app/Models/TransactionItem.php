<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory;
    protected $table = 'transaction_items';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'product_variant_id',
        'price',
        'qty',
        'subtotal',
        'start_date',
        'end_date'
    ];
    public $timestamps = true;

    public function transaction() {
        return $this->belongsTo(Transaction::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }
}
