<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cclass extends Model
{
    protected $table = "class";

    public function exam_class()
    {
        return $this -> hasMany('App\exam_class','class_id','id');
    }

    public function class_student()
    {
        return $this -> hasMany('App\class_student','class_id','id');
    }

 
    public function subject()
    {
        return $this->belongsTo(subject::class, 'subject_id', 'id');
    }
    public function teacher()
    {
        return $this->belongsTo(teacher::class, 'teacher_id', 'id');
    }

    public function student()
    {
        return $this->belongsToMany(student::class,'class_student','class_id','student_id');
    }
    
}
