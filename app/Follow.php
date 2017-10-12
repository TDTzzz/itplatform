<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follow extends Model
{
    protected $fillable=['user_id','question_id'];

    protected $table='user_question';
}
