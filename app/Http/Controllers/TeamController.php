<?php

namespace App\Http\Controllers;

use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $teams = Team::all();
        return response()->json([
            "message"=>"Success",
            "data"=>$teams
        ]);
    }
    
    


    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" =>"required|string",
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Fail",
                "data"=>$validator->errors()
            ]);
        }
        $team = Team::create([
            "name"=>$request->name

        ]);
        return response()->json([
            "message"=>"Success",
            "data"=>$team
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Team $team)
    {
        return response()->json([
            "message"=>"Success",
            "data"=>$team
        ]);
    }

  
    
    public function update(Request $request, Team $team)
    {
        $validator = Validator::make($request->all(),[
            "name" =>"required|string",
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Fail",
                "data"=>$validator->errors()
            ]);
        }
        if($team->update($request->all())){
            return response()->json([
                'error'=>false,
                'message'=>'Data Updated Successfully',
                'data'=>$team,
            ]);
            }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Team $team)
    {
        if($team->delete()){
            return response()->json([
                "message"=>"Deleted Successfully"

            ],204);
        }
    }
}
