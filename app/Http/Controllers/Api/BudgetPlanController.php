<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Services\BudgetPlanService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetPlanController extends Controller
{
    protected $budgetPlanService;
    public function __construct(BudgetPlanService $budgetPlanService)
    {
        $this->budgetPlanService = $budgetPlanService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $budgets = $this->budgetPlanService->list($request->all());
            return BudgetResource::collection($budgets->load(['expenseItem']));
        } catch (Exception $th) {
            return error($th->getMessage(),500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BudgetRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->budgetPlanService->create($data);
            });
            return success(new BudgetResource($result),"Budget Added Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(),$e->getCode());
        }
    }

    public function previousMonthBudgetAdd(Request $request)
    {
       
        try {
            $result = DB::transaction(function() {
               return $this->budgetPlanService->previousMonthBudgetAdd();
            });
            return success($result,"Previous Month Budgets Added Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(),500);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $budget = $this->budgetPlanService->getById($id);
            $budget->load(['expenseItem']);
            return new BudgetResource($budget);
        } catch (Exception $e) {
            return error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BudgetRequest $request, string $id)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $id){
                return $this->budgetPlanService->update($data, $id);
            });
            return success(new BudgetResource($result),"Budget Updated Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(),$e->getCode());
        }   
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            DB::transaction(function () use ($id) {
                return $this->budgetPlanService->destroy($id);
            });
            return success(null,"Budget Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
