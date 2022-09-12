<?php

namespace App\Http\Resources\Repayment;

use App\Http\Resources\Loan\LoanResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'loan_id' => $this->loan_id,
            'loan' => new LoanResource($this->whenLoaded('loan')),
            'amount' => $this->amount,
            'amount_paid' => $this->amount_paid,
            'due_on' => $this->due_on,
            'paid_on' => $this->paid_on,
            'status' => $this->status,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
