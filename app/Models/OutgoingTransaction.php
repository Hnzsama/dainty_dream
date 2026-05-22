<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutgoingTransaction extends Model
{
    protected $table = 't_outgoing_transactions';
    protected $fillable = ['product_id', 'customer_id', 'quantity', 'price', 'transaction_date', 'monthly_report_id'];
    public $timestamps = false;

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function monthlyReport()
    {
        return $this->belongsTo(MonthlyReport::class, 'monthly_report_id');
    }
}
