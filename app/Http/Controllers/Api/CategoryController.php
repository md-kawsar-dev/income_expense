<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        try {
            $categories = $this->categoryService->list($request->all());
            return CategoryResource::collection($categories);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }
    
    public function store(CategoryRequest $request)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function() use($data){
               return $this->categoryService->create($data);
            });
            return success(new CategoryResource($result),"Category Added Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function show(int $id)
    {
        try {
            $category = $this->categoryService->getById($id);
            return new CategoryResource($category);
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function update(CategoryRequest $request,int $id)
    {
        $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $id){
                return $this->categoryService->update($data, $id);
            });
            return success(new CategoryResource($result),"Category Updated Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function destroy(int $id)
    {
        try {
            DB::transaction(function () use ($id) {
                return $this->categoryService->destroy($id);
            });
            return success(null,"Category Deleted Successfully!");
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
}
