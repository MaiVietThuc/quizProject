<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class teacher extends Model
{
    protected $table = 'teacher';

    public function cclass()
    {
        return $this -> hasMany('App\cclass','teacher_id','id');
    }
    public function exam()
    {
        return $this -> hasMany('App\exam','teacher_id','id');
    }
    public function subject()
    {
        return $this->belongsToMany(subject::class,'teach_subj','id_teacher','id_subject');
    }
    
    
}
