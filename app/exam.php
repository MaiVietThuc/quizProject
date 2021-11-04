<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam extends Model
{
    protected $table = "exam";

    public function question(){
        return $this -> hasMany('App\question','exam_id','id');
    }
    public function student_answer(){
        return $this -> hasMany('App\student_answer','exam_id','id');
    }
    public function exam_student_status(){
        return $this -> hasMany('App\exam_student_status','exam_id','id');
    }
    public function exam_class(){
        return $this -> hasMany('App\exam_class','exam_id','id');
    }
    public function cclass()
    {
        return $this->belongsToMany(cclass::class,'exam_class','exam_id','class_id');
    }
}
