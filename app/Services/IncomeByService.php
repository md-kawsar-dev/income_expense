<?php
namespace App\Services;

use App\Models\IncomeBy;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class IncomeByService
{
    public function list(array $filters = [])
    {
        $query = IncomeBy::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['name'])) {
                $query->where($key, $value);
            }
        }
        return $query->get();
    }
    public function getById(int $id)
    {
        $incomeBy = IncomeBy::find($id);
        if (!$incomeBy) {
            throw new Exception('IncomeBy not found', Response::HTTP_NOT_FOUND);
        }
        return $incomeBy;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        return IncomeBy::create($data);
    }

    public function update(array $data,int $id)
    {
        $incomeBy = IncomeBy::find($id);
        if(!$incomeBy){
            throw new Exception('IncomeBy not found', Response::HTTP_NOT_FOUND);
        }
        $incomeBy->update($data);
        return $incomeBy;
    }

    public function destroy(int $id)
    {
        $incomeBy = IncomeBy::find($id);
        if(!$incomeBy){
            throw new Exception('IncomeBy not found', Response::HTTP_NOT_FOUND);
        }
        $incomeBy->delete();
    }

}