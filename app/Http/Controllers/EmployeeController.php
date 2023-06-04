<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $employees = Employee::all();
        if($employees){
            return response()->json([
                "data"=>$employees,
                "message"=>"Retrieved all the employess successfully"
            ],200);
        }
        else{
            return response()->json([
                "message"=>"No user data found"
            ],404);
        }
    }

    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "fullname"=>'required|string',
            "email"=>'required|string|email',
            "phone"=>'required|string',
            "password"=>'required|string',
            "photo"=>'required|string',
            "position"=>'required|string',
            "salary"=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Validation Error",
                "error"=>$validator->errors()

            ],400);
        }
        $employee =  Employee::create([
            "fullname"=>$request->fullname,
            "email"=>$request->email,
            "phone"=>$request->phone,
            "password"=>$request->password,
            "photo"=>$request->photo,
            "position"=>$request->position,
            "salary"=>$request->salary,
        ]);
       return response()->json([
        "message"=>'Success',
        "data"=>$employee,

       ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        return response()->json([
            "data"=>$employee,
            "message"=>"success"

        ],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
  
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employee $employee)
    {
     
        $validator = Validator::make($request->all(),[
            "fullname"=>'required|string',
            "email"=>'required|string|email',
            "phone"=>'required|string',
            "password"=>'required|string',
            "photo"=>'required|string',
            "position"=>'required|string',
            "salary"=>'required|string',
        ]);
        if($validator->fails()){
            return response()->json([
                "message"=>"Validation Error",
                "error"=>$validator->errors()

            ],400);
        }
       
        if($employee->update($request->all())){
            return response()->json([
                'error'=>false,
                'message'=>'Data Updated Successfully',
                'data'=>$employee,
            ]);
            }
    }
    /**
     * Remove the specified resourc from storage.
     */
    public function destroy(Employee $employee)
    {
        if($employee->delete()){
            return response()->json([
                "message"=>"Deleted Successfully"

            ],204);
        }
    }
}
