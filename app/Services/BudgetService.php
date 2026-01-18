<?php

namespace App\Services;

use App\Models\Budget;
use App\Models\Expense;
use Exception;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class BudgetService
{
    public function list(array $filters = [])
    {
        $year  = $filters['year'] ?? now()->year;
        $month = $filters['month'] ?? now()->month;

        // Subquery: expenses sum only (fastest)
        $expenseSub = Expense::query()
            ->selectRaw('expense_item_id, SUM(amount) AS total_expense')
            ->where('scope_id', scope_id())
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->groupBy('expense_item_id');

        $budgets = Budget::query()
            ->where('budgets.scope_id', scope_id())
            // apply filters
            ->when(isset($filters['year']), fn($q) => $q->where('year', $filters['year']))
            ->when(isset($filters['expense_item_id']), fn($q) => $q->where('expense_item_id', $filters['expense_item_id']))
            ->when(isset($filters['month']), fn($q) => $q->where('month', $filters['month']))

            // join subquery instead of raw expenses table
            ->leftJoinSub($expenseSub, 'ex', 'ex.expense_item_id', '=', 'budgets.expense_item_id')

            // join expense_items for sorting
            // ->leftJoin('expense_items', 'expense_items.id', '=', 'budgets.expense_item_id')

            ->select(
                'budgets.*',
                DB::raw('IFNULL(ex.total_expense, 0) AS total_expense'),
                DB::raw('(budgets.amount - IFNULL(ex.total_expense, 0)) AS remaining_amount')
            )

            // custom sorting: Need → Want → Savings
            // ->orderByRaw("FIELD(expense_items.expense_type, 'Need', 'Want', 'Savings')")

            ->get();

        return $budgets;
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
            ->pluck('expense_item_id')
            ->toArray();

        $insertData = [];

        foreach ($previousBudgets as $prev) {
            if (!in_array($prev->expense_item_id, $existingBudgets)) {
                $insertData[] = [
                    'scope_id' => scope_id(),
                    'expense_item_id' => $prev->expense_item_id,
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
