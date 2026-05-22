<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'm_suppliers';
    protected $fillable = ['name', 'address', 'phone'];
    public $timestamps = false;
}
