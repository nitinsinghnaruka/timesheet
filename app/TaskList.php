<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskList extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'name'
    ];

    /**
     * Get the project that owns the task list.
     */
    public function project()
    {
        return $this->belongsTo('App\Project');
    }

    /**
     * Get the tasks.
     */
    public function tasks()
    {
        return $this->hasMany('App\Task');
    }
}
