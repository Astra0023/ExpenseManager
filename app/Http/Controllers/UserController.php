<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Roles;
use Validator;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
            'name' => 'required',
            'email' => 'required|email'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $user = Users::create([
                'name' => $request->name,
                'email' => $request->email,
                'roleID' => $request->roleID,
                'status' => 'active'
            ]);

            if($user){
                return response()->json([
                    'status' => 200,
                    'message' => 'User Added Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                ], 500);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $userLists = Users::where('status', 'active')
            ->with('role')
            ->get();
        $userRole = Roles::where('status', 'active')
            ->get();
        return response()->json(['users' => $userLists, 'roles' => $userRole]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $userID)
    {
        $userGet = Users::where('userID', $userID)
            ->where('status', 'active')
            ->first();
        return response()->json(['userGet' => $userGet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $userID)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $roleFind = Users::where('userID', $userID)->first();
            $roleFind->update([
                'name' => $request->name,
                'email' => $request->email,
                'roleID' => $request->roleID
            ]);

            if($roleFind->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'User Updated Successfully'
                ], 200);
            }else{
                return response()->json([
                    'status' => 500,
                    'message' => 'Something Went Wrong',
                ], 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, $userID)
    {
        $userFind = Users::where('userID', $userID)->first();
        $userFind->update([
            'status' => 'inactive'
        ]);
        if($userFind->save()){
            return response()->json([
                'status' => 200,
                'message' => 'User Archived Successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
            ], 500);
        }
    }
}
