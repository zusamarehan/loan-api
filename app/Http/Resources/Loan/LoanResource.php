<?php

namespace App\Http\Resources\Loan;

use App\Http\Resources\Repayment\RepaymentResource;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->whenLoaded('user')),
            'amount' => $this->amount,
            'term' => $this->term,
            'status' => $this->status,
            'notes' => $this->notes,
            'handler' => new UserResource($this->whenLoaded('handled_by')),
            'repayments' => RepaymentResource::collection($this->whenLoaded('repayments')),
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
