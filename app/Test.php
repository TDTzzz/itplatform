<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    //
    protected $table='test';
    protected $fillable=['title','grade','choose_content','choose_type','test_type'];

}
