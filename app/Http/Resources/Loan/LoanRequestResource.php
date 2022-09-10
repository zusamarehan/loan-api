<?php

namespace App\Http\Resources\Loan;

use Illuminate\Http\Resources\Json\JsonResource;

class LoanRequestResource extends JsonResource
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
            'amount' => $this->amount,
            'term' => $this->term,
            'status' => $this->status,
            'notes' => $this->notes,
            'handled_by_id' => $this->handled_by_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,
        ];
    }
}
