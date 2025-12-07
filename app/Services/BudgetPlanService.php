<?php

namespace App\Services;

use App\Models\Budget;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BudgetPlanService
{
    public function list(array $filters = [])
    {
        if (isset($filters['year_month'])) {
            $filters['year'] = date('Y', strtotime($filters['year_month']));
            $filters['month'] = date('m', strtotime($filters['year_month']));
            unset($filters['year_month']);
        } elseif (!isset($filters['year']) && !isset($filters['month'])) {
            $filters['year'] = date('Y');
            $filters['month'] = date('m');
        }
        $query = Budget::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['year', 'category_id', 'month'])) {
                $query->where($key, $value);
            }
        }
        // sort by category_type first Need second Want and  Savings
        $query->orderByRaw("(SELECT FIELD(category_type, 'Need', 'Want', 'Savings')
                     FROM categories
                     WHERE categories.id = budgets.category_id)");
        $query->orderBy('id', 'asc');
        return $query->get();
    }
    public function previousMonthBudgetAdd()
    {
        $date = now();
        $previousMonth = now()->subMonth();
        // get previous month budgets
        $previousBudgets = $this->list([
            'year' => $previousMonth->year,
            'month' => $previousMonth->month
        ]);

        if ($previousBudgets->isEmpty()) {
            throw new Exception('No budgets found for the previous month to copy.', Response::HTTP_NOT_FOUND);
        }
        // load existing budgets for current month (1 query)
        $existingBudgets = Budget::where('scope_id', scope_id())
            ->where('year', $date->year)
            ->where('month', $date->month)
            ->pluck('category_id')
            ->toArray();

        $insertData = [];

        foreach ($previousBudgets as $prev) {
            if (!in_array($prev->category_id, $existingBudgets)) {
                $insertData[] = [
                    'scope_id' => scope_id(),
                    'category_id' => $prev->category_id,
                    'amount' => $prev->amount,
                    'year' => $date->year,
                    'month' => $date->month,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // bulk insert (1 query)
        if (!empty($insertData)) {
            Budget::insert($insertData);
        }
    }
    public function getById(int $id)
    {
        $result = Budget::find($id);
        if (!$result) {
            throw new Exception('Budget not found', Response::HTTP_NOT_FOUND);
        }
        return $result;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        $data['year'] = date('Y', strtotime($data['year_month']));
        $data['month'] = date('m', strtotime($data['year_month']));
        unset($data['year_month']);
        return Budget::create($data);
    }

    public function update(array $data, int $id)
    {
        $budget = Budget::find($id);
        if (!$budget) {
            throw new Exception('Budget not found', Response::HTTP_NOT_FOUND);
        }
        $data['year'] = date('Y', strtotime($data['year_month']));
        $data['month'] = date('m', strtotime($data['year_month']));
        unset($data['year_month']);
        $budget->update($data);
        return $budget;
    }

    public function destroy(int $id)
    {
        $budget = Budget::find($id);
        if (!$budget) {
            throw new Exception('Budget not found', Response::HTTP_NOT_FOUND);
        }
        $budget->delete();
    }
}
