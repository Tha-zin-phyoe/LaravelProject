<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Http\Requests\AttendanceRequest;
use App\Http\Resources\AttendanceResource;

class AttendanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
   
        //  return "hello";
        $page = Request()->has('page') ? Request()->get('page') : 1;
        $dateTime =Request()->has('datetime') ? Request()->get('datetime') : "";
        $limit =Request()->has('limit') ? Request()->get('limit') : 10;
        $attendances = Attendance::where('delete_status',1)
                        ->where(function($query) use ($dateTime){
               if($dateTime){
                $query->where('datetime','LIKE','%'.$dateTime . '%');
               }
               return $query;
        })->orderBy('id','asc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)->get();
        $attendance= AttendanceResource::collection($attendances);
    
        return response()->json([
            'data' => $attendance,
            'message' => ' Attendance list.',
            'total' => $attendance->count(),
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
    public function store(AttendanceRequest $request)
    {
    
        $validated = $request->validated();
    //  return $validated;
        $data = Attendance::create($validated);
        // return $admin;
        return new AttendanceResource($data);
    }

    /**
     * Display the specified resource.
     */
    public function show(Attendance $attendance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attendance $attendance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AttendanceRequest $request, Attendance $attendance)
    {
        // return $attendance;
        $validated = $request->validated();
        // return $validated;
        $attendance->update($validated);
        return new AttendanceResource($attendance);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attendance $attendance)
    {
      
        $data = $attendance;
        if($data){
            $data->delete_status =0;
            if($data->save()){
                return response()->json([
                    "error"=>false,
                    "message"=>"Deleted Successfully!",
                    "data"=>$data
                  ]);

            }
        }

    }
}
