<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class exam_student_status extends Model
{
    protected $table = "exam_student_status";
    public $timestamps = false;
    protected $dates = ['time_start','time_end'];
    
    public function exam()
    {
        return $this->belongsTo('App\exam','exam_id','id');
    }
}
