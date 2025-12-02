<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeRequest;
use App\Http\Resources\IncomeResource;
use App\Services\IncomeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{
    protected $incomeService;
    public function __construct(IncomeService $incomeService)
    {
        $this->incomeService = $incomeService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $incomes = $this->incomeService->list($request->all());
            return IncomeResource::collection($incomes);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->incomeService->create($data);
            });
            return success(new IncomeResource($result),"Income Added Successfully!");
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
            $income = $this->incomeService->getById($id);
            return new IncomeResource($income);
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
                return $this->incomeService->update($data, $id);
            });
            return success(new IncomeResource($result),"Income Updated Successfully!");
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
                return $this->incomeService->destroy($id);
            });
            return success(null,"Income Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
