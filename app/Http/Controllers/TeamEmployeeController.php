<?php

namespace App\Http\Controllers;

use App\Models\TeamEmployee;
use Illuminate\Http\Request;
use App\Http\Requests\TeamEmployeeRequest;
use App\Http\Resources\TeamEmployeeResource;

class TeamEmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // return "hello";
        $page = Request()->has('page') ? Request()->get('page') : 1;
        $employeeName =Request()->has('employee') ? Request()->get('employee') : "";
        $limit =Request()->has('limit') ? Request()->get('limit') : 10;
        $employees = TeamEmployee::where('delete_status',1)
                        ->where(function($query) use ($employeeName){
               if($employeeName){
                $query->where('employee','LIKE','%'.$employeeName . '%');
               }
               return $query;
        })->orderBy('id','asc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)->get();
        $employee= TeamEmployeeResource::collection($employees);
       
        return response()->json([
            'data' => $employee,
            'message' => 'Team Employee list.',
            'total' => $employee->count(),
           'page' => (int)$page,
           'rowPerPages' => (int)$limit,
        ]);
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
    public function store(TeamEmployeeRequest $request)
    {

        $validated = $request->validated();
    //  return $validated;
       
        $data = TeamEmployee::create($validated);
        // return $admin;
        return new TeamEmployeeResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(TeamEmployee $teamEmployee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeamEmployee $teamEmployee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeamEmployee $teamEmployee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TeamEmployee $teamEmployee)
    {
        //
    }
}
