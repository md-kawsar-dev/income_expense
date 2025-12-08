<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ExpenseResource extends JsonResource
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
            'expense_item_id' => $this->expense_item_id,
            'scope_id' => $this->scope_id,
            'scope' => new UserResource($this->whenLoaded('scope')),
            'expense_item' => new ExpenseItemResource($this->whenLoaded('expenseItem')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
