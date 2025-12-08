<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BudgetResource extends JsonResource
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
            'year' => $this->year,
            'month' => $this->month,
            'amount' => $this->amount,
            'expense_item_id' => $this->expense_item_id,
            'expense_item' => new ExpenseItemResource($this->whenLoaded('expenseItem')),
            'user' => new UserResource($this->whenLoaded('scope')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            
        ];
    }
}
