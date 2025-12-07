<?php
namespace App\Services;

use App\Models\Category;
use Exception;
use Symfony\Component\HttpFoundation\Response;

class CategoryService
{
    public function list(array $filters = [])
    {
        $query = Category::query()->where('scope_id', scope_id());

        // Apply filters if any
        foreach ($filters as $key => $value) {
            if (in_array($key, ['category_type', 'category_name'])) {
                $query->where($key, $value);
            }
        }
        // sort by category_type first Need second Want and  Savings
        $query->orderByRaw("FIELD(category_type, 'Need', 'Want', 'Savings')");
        return $query->get();
    }
    public function getById(int $id)
    {
        $category = Category::find($id);
        if (!$category) {
            throw new Exception('Category not found', Response::HTTP_NOT_FOUND);
        }
        return $category;
    }
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        return Category::create($data);
    }

    public function update(array $data,int $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new Exception('Category not found', Response::HTTP_NOT_FOUND);
        }
        $category->update($data);
        return $category;
    }

    public function destroy(int $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new Exception('Category not found', Response::HTTP_NOT_FOUND);
        }
        $category->delete();
    }

}