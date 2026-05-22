<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'm_products';
    public $timestamps = false;
    protected $fillable = ['sku', 'name', 'category_id', 'supplier_id', 'price', 'stock'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->sku)) {
                $model->sku = self::generateSku();
            }
        });
    }

    public static function generateSku()
    {
        $lastProduct = self::latest('id')->first();
        $lastNumber = 0;

        if ($lastProduct && preg_match('/\d+$/', $lastProduct->sku, $matches)) {
            $lastNumber = (int)$matches[0];
        }

        return 'SKU' . str_pad($lastNumber + 1, 6, '0', STR_PAD_LEFT);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
