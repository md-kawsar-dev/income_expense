<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes,Filterable;
    protected $table = 'expenses';
    protected $fillable = ['scope_id','category_id', 'amount', 'date', 'description'];

    public function scope()
    {
        return $this->belongsTo(User::class, 'scope_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
