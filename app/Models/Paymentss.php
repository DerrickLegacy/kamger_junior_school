<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paymentss extends Model
{
    use HasFactory;

    // Define the fillable fields to allow mass assignment
    protected $fillable = [
        'payment_type',
        'receipt_number',
        'payment_date',
        'student_id',
        'amount',
        'balance',
        'payment_method',
        'discription',
        'recorded_by',
    ];

    // Relationship: Each payment is recorded by one user
    public function recordedBy()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }
}
