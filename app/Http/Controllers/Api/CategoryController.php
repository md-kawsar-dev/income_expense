<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Services\CategoryService;
use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    use AuthorizesRequests;
    protected $categoryService;
    
    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }
    public function index(Request $request)
    {
        $this->authorize('viewAny', Category::class);
        try {
            $categories = $this->categoryService->list($request->all());
            return CategoryResource::collection($categories);
        } catch (Exception $th) {
            return error($th->getMessage(), 500);
        }
    }
    
    public function store(CategoryRequest $request)
    {
        $this->authorize('create', Category::class);
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
        $category = $this->categoryService->getById($id);
        $this->authorize('view', $category);
        try {
            return new CategoryResource($category);
        } catch (Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function update(CategoryRequest $request,Category $category)
    {
        
        $this->authorize('update', $category);
        $data = $request->validated();
        try{
            $result = DB::transaction(function()use($data, $category){
                return $this->categoryService->update($data, $category->id);
            });
            return success(new CategoryResource($result),"Category Updated Successfully!");
        } catch (\Exception $e) {
            return error($e->getMessage(), 500);
        }
    }
    public function destroy(int $id)
    {
        $this->authorize('delete', Category::class);
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
