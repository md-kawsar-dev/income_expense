<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseItemRequest;
use App\Http\Resources\ExpenseItemResource;
use App\Models\ExpenseItem;
use App\Services\ExpenseItemService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseItemController extends Controller
{
    protected $expenseItemService;
    
    public function __construct(ExpenseItemService $expenseItemService)
    {
        $this->expenseItemService = $expenseItemService;
    }
    public function index(Request $request)
    {
        try {
            $categories = $this->expenseItemService->list($request->all());
            return ExpenseItemResource::collection($categories);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }
    
    public function store(ExpenseItemRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->expenseItemService->create($data);
            });
            return success(new ExpenseItemResource($result),"ExpenseItem Added Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function show(int $id)
    {
        $expenseItem = $this->expenseItemService->getById($id);
        try {
            return new ExpenseItemResource($expenseItem);
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function update(ExpenseItemRequest $request,ExpenseItem $expenseItem)
    {
        
         $expenseItem = $this->expenseItemService->getById($expenseItem->id);
        $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $expenseItem){
                return $this->expenseItemService->update($data, $expenseItem->id);
            });
            return success(new ExpenseItemResource($result),"ExpenseItem Updated Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function destroy(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                return $this->expenseItemService->destroy($id);
            });
            return success(null,"ExpenseItem Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
