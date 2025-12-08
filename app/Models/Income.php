<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Income extends Model
{
   use SoftDeletes,Filterable;
    protected $table = 'incomes';
    protected $fillable = [
        'scope_id',
        'income_by_id',
        'amount',
        'date',
        'description',
    ];
    public function incomeBy()
    {
        return $this->belongsTo(User::class, 'income_by_id');
    }
    public function scope()
    {
        return $this->belongsTo(User::class, 'scope_id');
    }
}
