<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseItem extends Model
{
    use SoftDeletes,Filterable;

    protected $table = 'expense_items';
    protected $fillable = [
        'scope_id',
        'expense_type',
        'expense_item',
        'amount',
    ];

    public function scope()
    {
        return $this->belongsTo(User::class,'id','scope_id');
    }
}
