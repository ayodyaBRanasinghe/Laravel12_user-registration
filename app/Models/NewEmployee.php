<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewEmployee extends Model
{
    protected $table = 'new_employees';

    protected $fillable = ['name','email','password','nic','mobile_number'];
    
}
