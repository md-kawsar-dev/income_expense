<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IncomeByRequest;
use App\Http\Resources\IncomeByResource;
use App\Services\IncomeByService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeByController extends Controller
{
    protected $incomeByService;
    public function __construct(IncomeByService $incomeByService)
    {
        $this->incomeByService = $incomeByService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $incomeBys = $this->incomeByService->list($request->all());
            return IncomeByResource::collection($incomeBys);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(IncomeByRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->incomeByService->create($data);
            });
            return success(new IncomeByResource($result),"IncomeBy Added Successfully!");
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
            $incomeBy = $this->incomeByService->getById($id);
            return new IncomeByResource($incomeBy);
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IncomeByRequest $request, string $id)
    {
         $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $id){
                return $this->incomeByService->update($data, $id);
            });
            return success(new IncomeByResource($result),"IncomeBy Updated Successfully!");
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
                return $this->incomeByService->destroy($id);
            });
            return success(null,"IncomeBy Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
