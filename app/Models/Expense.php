<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes,Filterable;
    protected $table = 'expenses';
    protected $fillable = ['scope_id','expense_item_id', 'amount', 'date', 'description'];

    public function scope()
    {
        return $this->belongsTo(User::class, 'scope_id');
    }
    public function expenseItem()
    {
        return $this->belongsTo(ExpenseItem::class, 'expense_item_id');
    }
    // get date attribute in Y oct d
    public function getDateAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->format('d M, Y');
    }
}
