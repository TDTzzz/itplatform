<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
/**
 * Class Comment
 * @package App
 */
class postComment extends Model
{
    /**
     * @var string
     */
    protected $table = 'post_comment';
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'body', 'post_id'];
    /**
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
