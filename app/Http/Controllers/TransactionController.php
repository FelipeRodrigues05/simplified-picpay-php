<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Transaction;
use App\Services\TransactionService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public TransactionService $transactionService;

    public function __construct(TransactionService $transactionService) {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): Collection
    {
        return Transaction::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTransactionRequest $request): Transaction
    {
        return $this->transactionService->createTransaction($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction): Transaction
    {
        return $transaction;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        return response(['success' => "false", 'message' => "Method not allowed"], 405);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        return response(['success' => "false", 'message' => "Method not allowed"], 405);
    }
}
