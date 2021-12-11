<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam_feedback extends Model
{
    protected $table = "exam_feedback";

    public function student()
    {
        return $this-> belongsTo('App\student','student_id','id')
        ->select(['id','name','avatar']);
    }

    // public function teacher()
    // {
    //     $this-> belongsTo('App\teacher','teacher_id','id');
    // }
    public function exam()
    {
       return $this -> belongsTo('App\exam','exam_id','id')
       ->select(['id','title']);
    }
}
