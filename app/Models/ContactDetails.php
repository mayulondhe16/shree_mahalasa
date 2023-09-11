<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class ContactDetails extends Model
{
    //
    use SoftDeletes;

    protected $table = 'contactdetails';
}
