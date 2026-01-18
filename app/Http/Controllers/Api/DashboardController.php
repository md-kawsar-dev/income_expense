<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use App\Models\Income;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
   

    public function summary(Request $request)
    {
        // total income, total expense, total budget, remaining budget for current month
        $year = date('Y');
        $month = date('m');
        $totalIncome = Income::where('scope_id', scope_id())
            ->whereYear('date', $year)
            // ->whereMonth('date', $month)
            ->sum('amount');
        $totalExpense = Expense::where('scope_id', scope_id())
            ->whereYear('date', $year)
            // ->whereMonth('date', $month)
            ->sum('amount');
        $totalBalance = $totalIncome - $totalExpense;
        $totalSavings =  Expense::where('scope_id', scope_id())
            ->whereHas('expenseItem', function ($query) {
                $query->where('expense_type', 'Savings');
            })
            ->whereYear('date', $year)
            // ->whereMonth('date', $month)
            ->sum('amount');
        return response()->json([
            'total_income' => $totalIncome,
            'total_expense' => $totalExpense,
            'total_balance' => $totalBalance,
            'total_savings' => $totalSavings,
        ]);
        

    }

    public function monthlyTrend(Request $request)
    {
        //
    }

    public function expenseBreakdown(Request $request)
    {
        //
    }
}
