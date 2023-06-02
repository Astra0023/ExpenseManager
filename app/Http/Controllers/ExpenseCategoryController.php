<?php

namespace App\Http\Controllers;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Validator;

class ExpenseCategoryController extends Controller
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
            $role = ExpenseCategory::create([
                'name' => $request->name,
                'description' => $request->description,
                'status' => 'active'
            ]);

            if($role){
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Added Successfully'
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
    public function show(Request $request)
    {
        $category = ExpenseCategory::where('status', 'active')
            ->get();
        return response()->json(['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $categoryID)
    {
        $categoryGet = ExpenseCategory::where('categoryID', $categoryID)
            ->where('status', 'active')
            ->first();
        return response()->json(['getCategory' => $categoryGet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $categoryID)
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
            $categoryFind = ExpenseCategory::where('categoryID', $categoryID)->first();
            $categoryFind->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if($categoryFind->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Category Updated Successfully'
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
    public function destroy($categoryID)
    {
        $categoryFind = ExpenseCategory::where('categoryID', $categoryID)->first();
        $categoryFind->update([
            'status' => 'inactive'
        ]);

        if($categoryFind->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Category Archived Successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
            ], 500);
        }
    }
}
