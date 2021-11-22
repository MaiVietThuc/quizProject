<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class teacher extends Authenticatable
// class teacher extends Model
{
    use Notifiable;

    protected $table = 'teacher';
    protected $fillable = [
        'name', 'email', 'password','avatar','status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function cclass()
    {
        return $this -> hasMany('App\cclass','teacher_id','id');
    }
    public function exam()
    {
        return $this -> hasManyThrough('App\exam','App\cclass','teacher_id','class_id','id');
    }
    public function subject()
    {
        return $this->belongsToMany(subject::class,'teach_subj','id_teacher','id_subject');
    }

    public function exam_feedback()
    {
        return $this-> hasmanyThrough('App\exam_feedback','App\exam','teacher_id','exam_id','id' );
    }
    
    public function class_student()
    {
        return $this -> hasmanyThrough('App\class_student','App\cclass','teacher_id','class_id','id');
    }
    
}
