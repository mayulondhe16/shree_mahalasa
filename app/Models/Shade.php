<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Shade extends Model
{
    //
    use SoftDeletes;

    protected $table = 'shade';
}
