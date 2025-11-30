<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes,Filterable;

    protected $table = 'categories';

    protected $fillable = [
        'scope_id',
        'en',
        'bn',
        'amount',
    ];

    public function scope()
    {
        return $this->belongsTo(User::class,'id','scope_id');
    }
}
