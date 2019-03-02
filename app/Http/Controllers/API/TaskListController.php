<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\TaskList\StoreTaskList;
use App\Http\Requests\API\TaskList\UpdateTaskList;
use App\TaskList;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class TaskListController extends Controller
{
    /**
     * Create a controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    
    /**
     * Store task list.
     * 
     * @param  StoreTaskList  $request
     * @param  mixed          $project_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(StoreTaskList $request, $project_id)
    {
        // Store task list
        $task_list = TaskList::create([
            'project_id' => $project_id,
            'name'       => $request['name']
        ]);
        //----------------

        // Set response
        if (! is_null($task_list)) {
            $response = [
                'status'    => true,
                'message'   => 'Task list saved.',
                'task_list' => $task_list
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Task list saving failed, Please try again!',
                'task_list' => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }

    /**
     * Update task list.
     * 
     * @param  UpdateTaskList  $request
     * @param  mixed           $task_list_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function update(UpdateTaskList $request, $task_list_id)
    {
        // Update task list
        $task_list = TaskList::find($task_list_id);
        $task_list->name = $request['name'];
        $updated = $task_list->save();
        //-----------------

        // Set response
        if ($updated) {
            $response = [
                'status'    => true,
                'message'   => 'Task list updated.',
                'task_list' => $task_list
            ];
        } else {
            $response = [
                'status'    => false,
                'message'   => 'Unable to update task list, Please try again!',
                'task_list' => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }
}
