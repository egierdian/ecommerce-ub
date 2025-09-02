<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transactions';
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'city',
        'address',
        'postal_code',
        'total',
        'payment_method',
        'status',
        'payment_status',
        'code'
    ];
    public $timestamps = true;

    
    public function transactionItems() {
        return $this->hasMany(TransactionItem::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
