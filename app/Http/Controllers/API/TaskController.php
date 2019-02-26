<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Task\StoreTask;
use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TaskController extends Controller
{
    /**
     * Get tasks.
     * 
     * @param  integer  $task_list_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index($task_list_id)
    {
        dd(1);
        // Get tasks
        $tasks = Task::orderBy('id', 'desc')->get();
        //----------

        // Set response
        if (count($tasks)) {
            $response = [
                'status'  => true,
                'message' => 'Tasks found.',
                'tasks'   => $tasks
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => 'Tasks not found.',
                'task'    => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }

    /**
     * Store task.
     * 
     * @param  StoreTask  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(StoreTask $request)
    {
        // Store task
        $task = Task::create([
            'parent_id'   => $request['task'],
            'name'        => $request['name'],
            'description' => $request['description']
        ]);
        //----------- 

        // Set response
        if (! is_null($task)) {
            $response = [
                'status'  => true,
                'message' => 'Task saved.',
                'task'    => $task
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => 'Task saving failed, Please try again!',
                'task'    => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }
}
