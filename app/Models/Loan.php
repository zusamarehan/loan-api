<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    const LOAN_DECLINE = 'DECLINED';

    const LOAN_PENDING = 'PENDING';

    const LOAN_APPROVED = 'APPROVED';

    const LOAN_PAID = 'PAID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'terms',
        'status',
    ];

    /**
     * Get the repayments list of the loan.
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    /**
     * Get the User of the loan.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the Handler of the loan.
     */
    public function handled_by()
    {
        return $this->belongsTo(User::class);
    }
}
