<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    const REPAYMENT_PENDING = 'PENDING';
    const REPAYMENT_PAID = 'PAID';
    const REPAYMENT_DEFAULTED = 'DEFAULTED';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'due_on',
        'paid_on',
    ];

}
