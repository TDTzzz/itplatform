<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class testRecord extends Model
{
    protected $table='test_record';
    protected $fillable=['user_id','test_type','choose_record','grade'];

}
