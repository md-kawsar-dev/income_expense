<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Budget extends Model
{
    use SoftDeletes,Filterable;
    protected $table = 'budgets';
    protected $fillable = [
        'scope_id',
        'year',
        'month',
        'category_id',
        'amount',
    ];
    public function scope()
    {
        return $this->belongsTo(User::class,'id','scope_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class,'category_id','id');
    }
}
