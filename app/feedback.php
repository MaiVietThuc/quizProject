<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class feedback extends Model
{
    protected $table = 'feedback';
    public $timestamps = false;

    /**
     * Get the student that owns the feedback
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this -> belongsTo('App\student','student_id','id');
    }
    
}
