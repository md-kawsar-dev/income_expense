<?php

namespace App\Models;

use App\Policies\CategoryPolicy;
use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UsePolicy(CategoryPolicy::class)]
class Category extends Model
{
    use SoftDeletes,Filterable;

    protected $table = 'categories';

    protected $fillable = [
        'scope_id',
        'category_type',
        'category_name',
        'amount',
    ];

    public function scope()
    {
        return $this->belongsTo(User::class,'id','scope_id');
    }
}
