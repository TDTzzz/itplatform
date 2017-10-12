<?php
namespace App;

use Auth;
use Illuminate\Database\Eloquent\Collection;
class MessageCollection extends Collection
{
    public function markAsRead()
    {
        $this->each(function($message) {
            if($message->to_user_id === Auth::user()->id ){
                $message->markAsRead();
            }
        });
    }
}
