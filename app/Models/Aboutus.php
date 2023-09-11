<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Aboutus extends Model
{
    use SoftDeletes;

    protected $table = 'aboutus';
}
