<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable=['title','body','user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->morphMany('App\Comment','commentable');
    }

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('is_hidden','F');
    }

    public function followers()
    {
        return $this->belongsToMany(User::class,'user_post')->withTimestamps();
    }
}
