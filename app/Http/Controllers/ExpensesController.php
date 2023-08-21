<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Expenses\CreateRequest;
use App\Http\Requests\Expenses\UpdateRequest;
use App\Http\Requests\Expenses\ViewRequest;
use App\Models\Expense;
use App\Services\ExpenseService;
use App\Http\Resources\Expenses\ExpensesCollection;
use App\Http\Resources\Expenses\ExpensesResource;

class ExpensesController extends Controller
{
    protected ExpenseService $expenseService;

    public function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $response = $this->expenseService->getAllExpensesByUser($request->user()->id);
            return response()->json(new ExpensesCollection($response), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => "Internal Server Error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateRequest $request)
    {
        try {
            $response = $this->expenseService->store($request->validated());
            return response()->json($response, Response::HTTP_OK); 
        } catch (\Exception $e) {
            return response()->json(['error' => "Internal Server Error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ViewRequest $request, Expense $expense)
    {
        try {
            $expense = $this->expenseService->get($expense->id);
            return response()->json(new ExpensesResource($expense), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => "Internal Server Error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, Expense $expense)
    {
        try {
            $expense = $this->expenseService->update($expense->id, $request->all());
            return response()->json($expense,Response::HTTP_OK);  
        } catch (\Exception $e) {
            return response()->json(['error' => "Internal Server Error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $expenseId)
    {
        try {
            $this->expenseService->destroy($expenseId);
            return response()->json([], Response::HTTP_NO_CONTENT);
        } catch (\Exception $e) {
            return response()->json(['error' => "Internal Server Error"], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
