<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class student extends Authenticatable
{
    protected $table = "student";

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_code','name', 'email', 'password','majors_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   

    public function majors()
    {
        return $this->belongsTo(majors::class, 'majors_id', 'id');
    }
    public function cclass()
    {
        return $this->belongsToMany(cclass::class,'class_student','student_id','class_id');
    }
    public function exam()
    {
        return $this->belongsToMany(exam::class,'exam_student_status','student_id','exam_id');
    }
    public function exam_feedback()
    {
        return $this->hasMany(exam_feedback::class,'student_id','id');
    }
    public function exam_student_status(){
        return $this -> hasMany('App\exam_student_status','student_id','id');
    }
}
