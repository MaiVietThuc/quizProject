<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class question extends Model
{
    protected $table = "question";
    public function exam()
    {
        return $this->belongsTo('App\exam','exam_id','id');
    }
    public function student_answer()
    {
        return $this-> hasOne('App\student_answer','question_id','id');
    }
}
