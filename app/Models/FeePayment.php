<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    protected $table = 'fee_payments';
    public $timestamps = false;

    protected $fillable = [
        'student_id', 'fee_id', 'amount_paid', 'payment_method', 'transaction_ref',
        'paid_on', 'received_by', 'receipt_number', 'notes'
    ];

    protected $casts = [
        'amount_paid' => 'float',
        'paid_on' => 'date',
    ];

    public function student()
    {
        return $this->belongsTo(StudentDetail::class, 'student_id', 'user_id');
    }

    public function fee()
    {
        return $this->belongsTo(Fee::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}