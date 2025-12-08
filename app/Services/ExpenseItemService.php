<?php
namespace App\Services;

use App\Models\ExpenseItem;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ExpenseItemService
{
    public function list(array $filters = [])
    {
        $query = ExpenseItem::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['expense_type', 'expense_item'])) {
                $query->where($key, $value);
            }
        }
        // sort by expense_type first Need second Want and  Savings
        $query->orderByRaw("FIELD(expense_type, 'Need', 'Want', 'Savings')");
        return $query->get();
    }
    public function getById(int $id)
    {
        $expenseItem = ExpenseItem::find($id);
        if (!$expenseItem) {
            throw new Exception('ExpenseItem not found', Response::HTTP_NOT_FOUND);
        }
        return $expenseItem;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        return ExpenseItem::create($data);
    }

    public function update(array $data,int $id)
    {
        $expenseItem = ExpenseItem::find($id);
        if(!$expenseItem){
            throw new Exception('ExpenseItem not found', Response::HTTP_NOT_FOUND);
        }
        $expenseItem->update($data);
        return $expenseItem;
    }

    public function destroy(int $id)
    {
        $expenseItem = ExpenseItem::find($id);
        if(!$expenseItem){
            throw new Exception('ExpenseItem not found', Response::HTTP_NOT_FOUND);
        }
        $expenseItem->delete();
    }

}