<?php

namespace App\Http\Controllers;
use App\Models\Expenses;
use App\Models\ExpenseCategory;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DB;

class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = Expenses::select(DB::raw("SUM(amount) as amount"), 'categoryID')
            ->orderBy("expensesID")
            ->groupBy(DB::raw("categoryID"))
            ->with('expenseCategory')
            ->get();
        return response()->json(['categoriesexpenses' => $expenses]);
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
        $rules = [
            
        ];
        $validator = Validator::make($request->all(),[
            'categoryID' => 'not_in:selected',
            'amount' => 'required',
            'entryDate' => 'required'
        ]);
        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $expenses = Expenses::create([
                'categoryID' => $request->categoryID,
                'amount' => $request->amount,
                'entry_date' => Carbon::createFromFormat('Y-m-d', $request->entryDate)->toDateTimeString(),
                'status' => 'active'
            ]);
            if($expenses){
                return response()->json([
                    'status' => 200,
                    'message' => 'Expenses Added Successfully'
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
        $expenses = Expenses::where('status', 'active')
            ->with('expenseCategory')
            ->get();
        $category = ExpenseCategory::where('status', 'active')
            ->get();
        return response()->json(['expenses' => $expenses, 'categories' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $expensesID)
    {
        $categoryGet = Expenses::where('expensesID', $expensesID)
            ->where('status', 'active')
            ->first();
        return response()->json(['getCategory' => $categoryGet]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $expsesID)
    {
        $validator = Validator::make($request->all(),[
            'categoryID' => 'not_in:selected',
            'amount' => 'required',
            'entry_date' => 'required'
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages(),
            ],422);
        }else{
            $expensesFind = Expenses::where('expensesID', $expsesID)->first();
            $expensesFind->update([
                'categoryID' => $request->categoryID,
                'amount' => $request->amount,
                'entry_date' => Carbon::createFromFormat('Y-m-d', $request->entry_date)->toDateTimeString()
            ]);

            if($expensesFind->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Expenses Updated Successfully'
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
    public function destroy($expensesID)
    {
        $expensesFind = Expenses::where('expensesID', $expensesID)->first();
        $expensesFind->update([
            'status' => 'inactive'
        ]);

        if($expensesFind->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Expenses Archived Successfully'
            ], 200);
        }else{
            return response()->json([
                'status' => 500,
                'message' => 'Something Went Wrong',
            ], 500);
        }
    }
}
