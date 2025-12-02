<?php

use App\Models\Category;

return [
    // category permissions
    'category.index'=>['viewAny', Category::class],
    'category.store'=>['create', Category::class],
    'category.show'=>['view', Category::class],
    'category.update'=>['update', Category::class],
    'category.destroy'=>['delete', Category::class],
    
];
