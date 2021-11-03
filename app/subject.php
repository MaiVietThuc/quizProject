<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class subject extends Model
{
    protected $table = "subject";

    public function cclass()
    {
        return $this -> hasMany('App\cclass','subject_id','id');
    }
    public function teacher()
    {
        return $this->belongsToMany(teacher::class,'teach_subj','id_subject','id_teacher');
    }
}
