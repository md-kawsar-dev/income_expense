<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IncomeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'description' => $this->description,
            'income_by_id' => $this->income_by_id,
            'scope_id' => $this->scope_id,
            'scope' => new UserResource($this->whenLoaded('scope')),
            'income_by' => new IncomeByResource($this->whenLoaded('incomeBy')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
