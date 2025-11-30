<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function create(CategoryRequest $request)
    {
        $data = $request->validated();
        try{
            DB::transaction(function()use($data){
                $this->categoryService->create($data);
                return success(null,"Category Added Successfully!");
            });
        } catch (\Exception $e) {
            return error($e->getMessage(),$e->getCode());
        }
    }
    public function update(CategoryRequest $request,int $id)
    {
        $data = $request->validated();
        try{
            DB::transaction(function()use($data, $id){
                $this->categoryService->update($data, $id);
                return success(null,"Category Updated Successfully!");
            });
        } catch (\Exception $e) {
            return error($e->getMessage(),$e->getCode());
        }
    }
    public function destroy(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                $this->categoryService->destroy($id);
                return success(null,"Category Deleted Successfully!");
            });
        } catch (\Throwable $th) {
            return error($th->getMessage(), $th->getCode());
        }
    }
}
