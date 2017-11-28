<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    //
    protected $fillable =['user_id','question_id','body'];
    public function user()
    {
        return $this->belongTo(User::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
