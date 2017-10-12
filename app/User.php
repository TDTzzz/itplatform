<?php

namespace App;

use Mail;
use Naux\Mail\SendCloudTemplate;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','avatar','confirmation_token','api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
//    protected $casts=[
//        'settings'=>'array'
//    ];
    public function sendPasswordResetNotification($token)
    {
        $data=['url'=> url('password/reset', $token)];
        $template='zhihu_password_reset';
        $content = new SendCloudTemplate($template, $data);
        $email=$this->email;
        Mail::raw($content, function ($message) use ($email){
            $message->from('tt1150976163@outlook.com', 'Laravel');
            $message->to($email);
        });

    }//覆盖原本的密码重置方法

    public function owns(Model $model)
    {
        return $this->id==$model->user_id;
    }

    public function follows()
    {
        return $this->belongsToMany(Question::class,'user_question')->withTimestamps();
    }

    public function followThis($question)
    {
        return $this->follows()->toggle($question);
    }

    public function followed($question)
    {
        return !!$this->follows()->where('question_id',$question)->count();
    }

    public function followers()
    {
        return $this->belongsToMany(self::class,'followers','follower_id','followed_id')->withTimestamps();
        //用户与用户的多对多
    }
    public function followersUser()
    {
        return $this->belongsToMany(self::class,'followers','followed_id','follower_id')->withTimestamps();
    }

    public function followThisUser($user)
    {
        return $this->followers()->toggle($user);
    }

    public function votes()
    {
        return $this->belongsToMany(Answer::class,'votes')->withTimestamps();
    }

    public function hasVotedFor($answer)
    {
        return !!$this->votes()->where('answer_id',$answer)->count();
    }

    public function voteFor($answer)
    {
        return $this->votes()->toggle($answer);
    }

    public function messages()
    {
        return $this->hasMany(Message::class,'to_user_id');
    }
}
