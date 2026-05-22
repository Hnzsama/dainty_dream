<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'm_customers';
    protected $fillable = ['name', 'address', 'phone'];
    public $timestamps = false;
}
