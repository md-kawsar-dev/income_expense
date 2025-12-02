<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Http\Resources\ExpenseResource;
use App\Services\ExpenseService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
   protected $expenseService;
    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $expenses = $this->expenseService->list($request->all());
            return ExpenseResource::collection($expenses);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ExpenseRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->expenseService->create($data);
            });
            return success(new ExpenseResource($result),"Expense Added Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        try {
            $expense = $this->expenseService->getById($id);
            return new ExpenseResource($expense);
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
         $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $id){
                return $this->expenseService->update($data, $id);
            });
            return success(new ExpenseResource($result),"Expense Updated Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       try {
            DB::transaction(function () use ($id) {
                return $this->expenseService->destroy($id);
            });
            return success(null,"Expense Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
