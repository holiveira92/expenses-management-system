<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\Expenses\CreateRequest;
use App\Http\Requests\Expenses\UpdateRequest;
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
    public function index()
    {
        try {
            $response = $this->expenseService->getCollection();
            return response()->json(new ExpensesCollection($response), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(int $expenseId)
    {
        try {
            $response = $this->expenseService->get($expenseId);
            return response()->json(new ExpensesResource($response), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Display the specified resource.
     */
    public function showAllByUser(int $expenseId, string $filterDate=null)
    {
        try {
            $response = $this->expenseService->getAllExpensesByUser($expenseId, $filterDate);
            return response()->json(new ExpensesCollection($response), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, int $expenseId)
    {
        try {
            $response = $this->expenseService->update($expenseId, $request->all());
            return response()->json($response,Response::HTTP_OK);  
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
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
            return response()->json(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
