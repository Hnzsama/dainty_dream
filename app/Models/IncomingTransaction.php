<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IncomingTransaction extends Model
{
    protected $table = 't_incoming_transactions';
    protected $fillable = ['product_id', 'supplier_id', 'quantity', 'price', 'transaction_date', 'monthly_report_id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
    }

    public function monthlyReport()
    {
        return $this->belongsTo(MonthlyReport::class, 'monthly_report_id');
    }
}
