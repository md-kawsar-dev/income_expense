<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomeBy extends Model
{
    use SoftDeletes,Filterable;
    protected $table = 'income_bies';
    protected $fillable = [
        'scope_id',
        'name',
    ];

    public function scope()
    {
        return $this->belongsTo(User::class, 'scope_id');
    }
}
