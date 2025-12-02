<?php

namespace App\Models;

use App\Trait\Filterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes,Filterable;
    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',
    ];
}
