<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminAuthRequest;
use App\Http\Resources\AuthAdminResource;

class AdminAuthController extends Controller
{
    //login
    public function login(AdminAuthRequest $request)
    {

    $validated = $request->validated();
//   return $validated;
    $admin = Admin::where('email', $validated['email'])->first();
    if (!$admin || !Hash::check($validated['password'], $admin->password)) {
        return Response([
            'error' => true,
            'message' => 'Username or Password is incorrect!'
        ], 401);
    } else {
        // $admin->last_login = new \DateTime();
        $admin->auth_token = uniqid(base64_encode(Str::random(21)));
        $admin->save();
        return new AuthAdminResource($admin);
    };
}//End Method
public function logout(Request $request)
{
  $validated = $request->validate([
      'admin_id'=>'required',
  ]);
    Admin::where("id", $validated['admin_id'])->update(['auth_token' => null, 'token_expired_at' => null]);
    return response()->json([
        'error' => false,
        'authorize' => true,
        'message' => 'Admin logout Successfully!',
    ]);
}//End method
}
