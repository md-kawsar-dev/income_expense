<?php
namespace App\Services;

use App\Models\Category;
use Exception;

class CategoryService
{
    public function create(array $data)
    {
        $data['scope_id'] = scope_id();
        return Category::create($data);
    }

    public function update(array $data,int $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new Exception('Category not found');
        }
        $category->update($data);
        return $category;
    }

    public function destroy(int $id)
    {
        $category = Category::find($id);
        if(!$category){
            throw new Exception('Category not found');
        }
        $category->delete();
    }

}