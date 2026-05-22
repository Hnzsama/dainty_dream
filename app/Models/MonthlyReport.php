<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MonthlyReport extends Model
{
    protected $table = 't_monthly_reports';
    protected $fillable = [
        'month',
        'year',
        'incoming_total',
        'outgoing_total',
        'net_movement',
        'incoming_count',
        'outgoing_count',
    ];
    public $timestamps = false;

    // Relationship with IncomingTransaction
    public function incomingTransactions()
    {
        return $this->hasMany(IncomingTransaction::class, 'monthly_report_id');
    }

    // Relationship with OutgoingTransaction
    public function outgoingTransactions()
    {
        return $this->hasMany(OutgoingTransaction::class, 'monthly_report_id');
    }

    // Get all transactions for this month
    public function allTransactions()
    {
        return $this->incomingTransactions()->union($this->outgoingTransactions()->getQuery());
    }
}
