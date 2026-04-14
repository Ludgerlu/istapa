<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePaymentHistory extends Model
{
    use HasFactory;

    protected $table = 'fee_payment_history';
    protected $primaryKey = 'payment_history_id';
    public $timestamps = false;

    protected $fillable = [
        'fees_pay_id',
        'amount',
        'payment_method',
        'paid_by_date',
        'created_by',
        'trasaction_id',
        'payment_note'
    ];

    public function feesPayment()
    {
        return $this->belongsTo(FeesPayment::class, 'fees_pay_id', 'fees_pay_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by', 'ID');
    }
}