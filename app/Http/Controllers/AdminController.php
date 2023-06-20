<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\AdminResource;
use App\FileOperations\AdminImageOperation;
use App\Http\Requests\AdminPasswordRequest;
use App\Http\Resources\AdminPasswordResource;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // return "hello";
        $page = Request()->has('page') ? Request()->get('page') : 1;
        $adminName =Request()->has('name') ? Request()->get('name') : "";
        $limit =Request()->has('limit') ? Request()->get('limit') : 5;
        $admins = Admin::where('delete_status',1)
                        ->where(function($query) use ($adminName){
               if($adminName){
                $query->where('name','LIKE','%'.$adminName . '%');
               }
               return $query;
        });
        return response()->json([
            'data' => $admins->orderBy('id','asc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->get(),
        'message' => 'User list.',
        'total' => $admins->count(),
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
    public function register(AdminRequest $request)
    {

        $validated = $request->validated();
    //  return $validated;
        $validated['password'] = bcrypt($validated['password']);
        $validated["auth_token"] = uniqid(base64_encode(Str::random(21)));
        $validated["token_expired_at"]  = Carbon::now()->addWeeks(1);
        $admin = Admin::create($validated);
        // return $admin;
        return new AdminResource($admin);

    }//End Method

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdminRequest $request,Admin $admin)
    {
        // return $admin;
        $validated = $request->validated();
         return $validated;
        if (isset($request->photo)) {
         $operation = new AdminImageOperation($request->photo,$request->name,'admin-images');
         $url = $operation->storeImage();
         $validated['photo'] = $url;
     }
    if($validated['photo'] == null){
        $validated['photo']= $admin->photo;
         $admin->update($validated);
        return new adminResource($admin);

    }else{
       $admin->update($validated);
       return new adminResource($admin);

     };

    }//End Method

    //Admin Password Updated
    public function adminPasswordUpdate(AdminPasswordRequest $request)
    {
           $request->validated();
    //    return $validated;
       $user = Admin::where('id',$request->id)->first();
    //    return $user;
       // dd($user->password);
       if (Hash::check($request->old_password,$user->password)) {
        // return "hello";
          $user->update([
             'password'=>Hash::make($request->new_password)
          ]);
         return new AdminPasswordResource($user);
       }
    }//End method
    public function destroy(string $id)
    {
        $admin = Admin::find($id);
        if($admin){
            $admin->delete_status =0;
            if($admin->save()){
                return new AdminResource($admin);

            }
        }
    }
}
