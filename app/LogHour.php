<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LogHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id', 'body'
    ];

    /**
     * Get the task that owns the log hour.
     */
    public function task()
    {
        return $this->belongsTo('App\Task');
    }
}
