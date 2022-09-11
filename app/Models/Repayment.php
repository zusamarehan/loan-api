<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Repayment extends Model
{
    use HasFactory;

    const REPAYMENT_PENDING = 'PENDING';

    const REPAYMENT_PAID = 'REPAID';

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
        'amount_paid'
    ];

    /**
     * Get the loan of the repayment.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
