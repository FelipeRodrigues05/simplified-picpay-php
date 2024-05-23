<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Services\TransactionService;
use App\Models\Transaction;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class TransactionController extends Controller
{
    public TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }

    /**
     * Display a listing of the resource.
     * @return AnonymousResourceCollection
     */
    public function index(): AnonymousResourceCollection
    {
        return TransactionResource::collection(Transaction::paginate());
    }

    /**
     * Store a newly created resource in storage.
     * @param StoreTransactionRequest  $request
     * @return TransactionResource
     */
    public function store(StoreTransactionRequest $request): TransactionResource
    {
        return new TransactionResource($this->transactionService->createTransaction($request->validated()));
    }

    /**
     * Display the specified resource.
     * @param Transaction $transaction
     * @return TransactionResource
     */
    public function show(Transaction $transaction): TransactionResource
    {
        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     * @return \Illuminate\Foundation\Application|Response|Application|ResponseFactory
     */
    public function update(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        return response(['success' => "false", 'message' => "Method not allowed"], 405);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Foundation\Application|Response|Application|ResponseFactory
     */
    public function destroy(): \Illuminate\Foundation\Application|Response|Application|ResponseFactory
    {
        return response(['success' => "false", 'message' => "Method not allowed"], 405);
    }
}
