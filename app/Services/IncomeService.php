<?php
namespace App\Services;

use App\Models\Income;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class IncomeService
{
    public function list(array $filters = [])
    {
        $query = Income::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['income_by_id', 'date', 'amount'])) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }
    public function getById(int $id)
    {
        $income = Income::find($id);
        if (!$income) {
            throw new Exception('Income not found', Response::HTTP_NOT_FOUND);
        }
        return $income;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        $data['date'] = $data['date'] ?? now()->toDateString(); 
        return Income::create($data);
    }

    public function update(array $data,int $id)
    {
        $income = Income::find($id);
        if(!$income){
            throw new Exception('Income not found', Response::HTTP_NOT_FOUND);
        }
        $data['date'] = $data['date'] ?? $income->date;
        $income->update($data);
        return $income;
    }

    public function destroy(int $id)
    {
        $income = Income::find($id);
        if(!$income){
            throw new Exception('Income not found', Response::HTTP_NOT_FOUND);
        }
        $income->delete();
    }

}