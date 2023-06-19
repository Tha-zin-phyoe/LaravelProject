<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        if (count($projects) < 1) {
            return response()->json([
                "message" => "there is no projects",
            ], 404);
        }
        return response()->json([
            "message" => "success",
            "data" => $projects

        ], 200);
    }
 public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => 'required|string',
            "duration" => "integer",
        ]);
        if ($validator->fails()) {
            return response()->json([
                "message" => "Fails",
                "error" => $validator->errors()
            ], 422);
        }
        $projects = Project::create([
            "name" => $request->name,
            "duration" => $request->duration
        ]);
        return response()->json([
            "message" => "Success",
            "data" => $projects
        ], 200);
    }
    public function show(Project $project)
    {
        if ($project) {
            return response()->json([
                "message" => "Success",
                "data" => $project
            ], 200);
        } 
    }

  
    public function update(Request $request, Project $project)
    {
        $request->validate([
            "name"=>"required",
            "duration"=>"required"
        ]);
       
        $project->update([
            'name'=>$request->name,
            'duration'=>$request->duration
        ]);
      
        // $validator = Validator::make($request->all(),[
        //     "name"=>'required|string',
        //     "duration"=>'required',
            
        // ]);
        // if($validator->fails()){
        //     return response()->json([
        //         "message"=>"Validation Error",
        //         "error"=>$validator->errors()

        //     ],400);
        // }
        // $project->name = $request->input('name');
        // $project->duration = $request->input('duration');
        // $project->save();
    
        return response()->json([
            'message' => 'Project updated successfully',
            'data' => $project
        ], 200);
    }
    public function destroy(Project $project)
    {
        if($project->delete()){
            return response()->json([
                "message"=>"Deleted Successfully"

            ],204);
        }
    }
}
