<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'task_list_id', 'name', 'description'
    ];

    /**
     * Get the task list that owns the task.
     */
    public function task_list()
    {
        return $this->belongsTo('App\TaskList');
    }

    /**
     * Get the log hours.
     */
    public function log_hours()
    {
        return $this->hasMany('App\LogHour');
    }
}
