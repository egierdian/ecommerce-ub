<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $fillable = ['id','value'];
    public $timestamps = false;
}
