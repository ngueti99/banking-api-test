<?php

namespace App\Services;

use App\Models\bankAccount;
use App\Models\Transaction;

class TransactionService{
    public function createTransaction($request){
        $transaction = new Transaction();
        $transaction->amount = $request->input('amount');
        $transaction->user_id = auth()->user()->id;
        $transaction->type_transaction_id = $request->input('type_transaction_id');
        $transaction->transmitter_bank_account_id = $request->input('transmitter_bank_account_id');
        $transaction->receiver_bank_account_id = $request->input('receiver_bank_account_id');
        $transaction->save();
        $data = [
            'status' => 'success',
            'data' => $transaction
        ];
        return response($data, 201);
    }
    
    public function getTransactionOnSpecifiqueType($request)
    {
        $transactions = Transaction::where('type_transaction_id', $request->input('type_transaction_id'))
                                    ->where('transmitter_bank_account_id', $request->input('bank_account_id'))
                                    ->get();
        $data = [
            'status' => 'success',
            'data' => $transactions
        ];
        return response($data, 200);
    }

    public function getTransaction($id)
    {
        $transactions = Transaction::where('transmitter_bank_account_id', $id)->get();
        $data = [
            'status' => 'success',
            'data' => $transactions
        ];
        return response($data, 200);
    }
    
    public function getBalance($id)
    {
        $deposit = Transaction::where('transmitter_bank_account_id', $id)
                                ->where('type_transaction_id', 1)
                                ->sum('amount');
        $withdrawal =   Transaction::where('transmitter_bank_account_id', $id)
                                    ->where('type_transaction_id', 2)
                                    ->sum('amount');

        $transfer = Transaction::where('transmitter_bank_account_id', $id)
                                ->where('type_transaction_id', 3)
                                ->sum('amount');

        $current_balance = bankAccount::where('id', $id)->sum('balance');

        $balance = ($deposit+$current_balance)-($withdrawal+$transfer);
        $data = [
            'status' => 'success',
            'data' => $balance
        ];
        return response($data, 200);
    }

}
