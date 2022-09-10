<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    const APPROVAL_REJECTED = 'REJECTED';

    const APPROVAL_PENDING = 'PENDING';

    const APPROVAL_APPROVED = 'APPROVED';

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
}
