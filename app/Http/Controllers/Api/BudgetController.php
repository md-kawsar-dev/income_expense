<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BudgetRequest;
use App\Http\Resources\BudgetResource;
use App\Services\BudgetService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            return BudgetResource::collection($budgets->load(['category']));
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
               return $this->budgetService->create($data);
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
               return $this->budgetService->previousMonthBudgetAdd();
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
            $budget = $this->budgetService->getById($id);
            $budget->load(['category']);
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
                return $this->budgetService->update($data, $id);
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
                return $this->budgetService->destroy($id);
            });
            return success(null,"Budget Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
