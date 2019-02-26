<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\Project\StoreProject;
use App\Project;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;

class ProjectController extends Controller
{
    /**
     * Create a controller instance.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    /**
     * Get projects.
     * 
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function index()
    {
        // Get projects
        $projects = Project::where('user_id', auth_user('api')->id)->orderBy('id', 'desc')->get();
        //-------------

        // Set response
        if (count($projects)) {
            $response = [
                'status'   => true,
                'message'  => 'Projects found.',
                'projects' => $projects
            ];
        } else {
            $response = [
                'status'   => false,
                'message'  => 'Projects not found.',
                'projects' => []
            ];
        }
        //-------------

        return response()->json($response, 200);
    }

    /**
     * Store project.
     * 
     * @param  StoreProject  $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function store(StoreProject $request)
    {
        // Store project
        $project = Project::create([
            'user_id'     => auth_user('api')->id,
            'name'        => $request['name'],
            'description' => $request['description']
        ]);
        //--------------

        // Set response
        if (! is_null($project)) {
            $response = [
                'status'  => true,
                'message' => 'Project saved.',
                'project' => $project
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => 'Project saving failed, Please try again!',
                'project' => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }

    /**
     * Show project.
     * 
     * @param  $project_id
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function show($project_id)
    {
        // Get project
        $project = Project::with('task_lists.tasks')->where([
            'id'      => $project_id,
            'user_id' => auth_user('api')->id
        ])->first();
        //------------

        // Set response
        if (! is_null($project)) {
            $response = [
                'status'  => true,
                'message' => 'Project found.',
                'project' => $project
            ];
        } else {
            $response = [
                'status'  => false,
                'message' => 'Project not found.',
                'project' => null
            ];
        }
        //-------------

        return response()->json($response, 200);
    }
}
