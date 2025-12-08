<?php
namespace App\Services;

use App\Models\Expense;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class ExpenseService
{
    public function list(array $filters = [])
    {
        $query = Expense::query()->where('scope_id', scope_id());
        if(isset($filters['year'])) {
            $query->whereYear('date', $filters['year']);
            unset($filters['year']);
        }
        if(isset($filters['month'])) {
            $query->whereMonth('date', $filters['month']);
            unset($filters['month']);
        }
        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['expense_item_id', 'date', 'amount'])) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }
    public function getById(int $id)
    {
        $expense = Expense::find($id);
        if (!$expense) {
            throw new Exception('Expense not found', Response::HTTP_NOT_FOUND);
        }
        return $expense;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        $data['date'] = $data['date'] ?? now()->toDateString(); 
        return Expense::create($data);
    }

    public function update(array $data,int $id)
    {
        $expense = Expense::find($id);
        if(!$expense){
            throw new Exception('Expense not found', Response::HTTP_NOT_FOUND);
        }
        $data['date'] = $data['date'] ?? $expense->date;
        $expense->update($data);
        return $expense;
    }

    public function destroy(int $id)
    {
        $expense = Expense::find($id);
        if(!$expense){
            throw new Exception('Expense not found', Response::HTTP_NOT_FOUND);
        }
        $expense->delete();
    }

}