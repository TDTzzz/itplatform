<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table='messages';

    protected $fillable=['from_user_id','to_user_id','body','dialog_id'];

    public function fromUser()
    {
        return $this->belongsTo(User::class,'from_user_id');
    }

    public function toUser()
    {
        return $this->belongsTo(User::class,'to_user_id');
    }

    public function markAsRead()
    {
        if ($this->has_read==='F'){
            $this->forceFill(['has_read'=>'T','read_at'=>$this->freshTimestamp()])->save();
        }
    }

    public function newCollection(array $models=[])
    {
        return new MessageCollection($models);
    }

    public function unread()
    {
        return $this->has_read==='F';
    }

    public function isHasRead()
    {
        if(\Auth::user()->id===$this->from_user_id){
            return false;
        }
        return $this->unread();
    }
}
