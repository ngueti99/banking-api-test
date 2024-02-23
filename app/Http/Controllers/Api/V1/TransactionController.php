<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{

    protected TransactionService $transactionService;

    public function __construct(TransactionService $transactionService)
    {
        $this->transactionService = $transactionService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'amount' => 'required',
                'type_transaction_id' => 'required',
                'receiver_bank_account_id' => 'nullable',
                'transmitter_bank_account_id' => 'required',
            ]
        );

        $data = $this->transactionService->createTransaction($request);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function getTransactionOnSpecifiqueType(Request $request)
    {
        $this->validate(
            $request,
            [
                'type_transaction_id' => 'required',
                'bank_account_id' => 'required',
            ]
        );
        $data = $this->transactionService->getTransactionOnSpecifiqueType($request);
        return $data;
    }

    public function getBalance($id)
    {

        $data = $this->transactionService->getBalance($id);
        return $data;
    }
}
