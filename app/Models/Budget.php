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
        'expense_item_id',
        'amount',
    ];
    public function scope()
    {
        return $this->belongsTo(User::class,'id','scope_id');
    }
    public function expenseItem()
    {
        return $this->belongsTo(ExpenseItem::class,'expense_item_id','id');
    }
}
