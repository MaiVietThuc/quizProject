<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class student_answer extends Model
{
    protected $table = "student_answer";
    public $timestamps = false;

    public function question()
    {
        return $this->belongsTo('App\question','question_id','id');
    }
    public function exam()
    {
        return $this->belongsTo('App\exam','exam_id','id');
    }
}
