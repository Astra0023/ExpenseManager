<?php

namespace App\Http\Controllers;
use App\Models\Roles;
use Illuminate\Http\Request;
use Validator;

class RolesController extends Controller
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
            'description' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $role = Roles::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => 'active'
            ]);

            if($role){
                return response()->json([
                    'status' => 200,
                    'message' => 'Role Added Successfully'
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $roleID)
    {
        $roleGet = Roles::where('roleID', $roleID)
        ->where('status', 'active')
        ->first();
    return response()->json(['getRole' => $roleGet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $roleID)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $roleFind = Roles::where('roleID', $roleID)->first();
            $roleFind->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if($roleFind->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Role Updated Successfully'
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
    public function destroy(string $id)
    {
        //
    }

    public function getRoles(Request $request){
        $roleLists = Roles::where('status', 'active')->get();
        return response()->json(['roles' => $roleLists]);
    }
}
