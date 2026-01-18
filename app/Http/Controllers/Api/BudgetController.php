<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BudgetResource;
use App\Services\BudgetService;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    protected $budgetService;
    public function __construct(BudgetService $budgetService)
    {
        $this->budgetService = $budgetService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $budgets = $this->budgetService->list($request->all());
            $budgets->load('expenseItem');
            return BudgetResource::collection($budgets);
        } catch (\Exception $th) {
            return error($th->getMessage(), 500);  
        }
    }
}
