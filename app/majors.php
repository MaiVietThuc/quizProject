<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class majors extends Model
{
    protected $table = "majors";

    public function student(){
        return $this -> hasMany('App\student','majors_id','id');
    }
}
