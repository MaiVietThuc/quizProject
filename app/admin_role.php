<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class admin_role extends Model
{
    protected $table = "admin_role";

    public function admin(){
        return $this -> hasMany('App\admin','role_id','id');
    }
}
