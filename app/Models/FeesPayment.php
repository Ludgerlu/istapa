<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeesPayment extends Model
{
    use HasFactory;

    protected $table = 'fee_payments';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'class_id',
        'student_id',
        'fees_id',
        'amount_paid',
        'payment_method',
        'description',
        'note',
        'received_by',
        'start_year',
        'end_year',
        'paid_on',
        'created_at',
        'tax',
        'tax_amount',
        'fees_amount',
        'section_id'
    ];

    const STATUS_PART_PAID = 1;
    const STATUS_FULL_PAID = 2;

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id', 'ID');
    }

    public function class()
    {
        return $this->belongsTo(ClassModel::class, 'class_id', 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(ClassSection::class, 'section_id', 'id');
    }

    public function fee()
    {
        return $this->belongsTo(Fees::class, 'fees_id', 'fees_id');
    }

    public function paymentHistory()
    {
        return $this->hasMany(FeePaymentHistory::class, 'fees_pay_id', 'fees_pay_id');
    }

    public function getStatusTextAttribute()
    {
        switch($this->payment_status) {
            case self::STATUS_PART_PAID:
                return 'Paiement Partiel';
            case self::STATUS_FULL_PAID:
                return 'Payé';
            default:
                return 'En attente';
        }
    }
}