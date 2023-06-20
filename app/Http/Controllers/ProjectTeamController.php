<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectTeam;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProjectTeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects =  Project::with('team')->get();
        return $projects;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "project_id"=>'required',
            "team_id"=>'required',
            
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Validation Error",
                "error"=>$validator->errors()

            ],400);
        }
        $projects =  ProjectTeam::create([
            "project_id"=>$request->project_id,
            "team_id"=>$request->team_id,
            
        ]);
       return response()->json([
        "message"=>'Success',
        "data"=>$projects,

       ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ProjectTeam $projectTeam)
    {
        return response()->json([
            "data"=>$projectTeam,
            "message"=>"success"

        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProjectTeam $projectTeam)
    {
        $validator = Validator::make($request->all(),[
            "project_id"=>'required',
            "team_id"=>'required',
            
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Validation Error",
                "error"=>$validator->errors()

            ],400);
        }
        if($projectTeam->update($request->all())){
            return response()->json([
                'error'=>false,
                'message'=>'Data Updated Successfully',
                'data'=>$projectTeam,
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProjectTeam $projectTeam)
    {
        if($projectTeam->delete()){
            return response()->json([
                "message"=>"Deleted Successfully"

            ],204);
        }
    }
}
