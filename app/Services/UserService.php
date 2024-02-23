<?php

namespace App\Services;

use App\Models\bankAccount;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

 class UserService {

    public function createUser($request) 
    {
        $user = new User();
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->role = $request->input('role');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        if ($request->input('role')=='customer') {
            $data = [
                'status' => 'success',
                'data' => $user
            ];
            return response($data, 201);
        }
        
        $token = $this->generateUserTokenFromIp($user, request()->ip());
         $data = [
            'status' => 'success',
            'data' =>[
                'user'=>$user,
                'token'=>$token
            ]
        ];
        return response($data, 201);

    }
    public function generateUserTokenFromIp(User $user, string $ip): array
    {
        $token = $user->createToken($ip);

        $accessToken = $token->accessToken;

        return [
                'value' => $token->plainTextToken,
                'type' => 'bearer',
                'expire_at' => $accessToken->expired_at
        ];
    }
    public function login($request){
        $user = User::where(['email' => $request->input('email')])->first();
        if (!$user || !Hash::check($request->input('password'), $user->password)) {
            $data = [
                'status' => 'error',
                'message' => 'Invalid fields'
            ];
            return response($data, 400);
        }
        $token = $this->generateUserTokenFromIp($user, request()->ip());
        $data = [
            'status' => 'success',
            'data' => [
                'user' => $user,
                'token' => $token
            ]
        ];
        return response($data, 200);
    }
    public function logout(){
        auth()->user()->tokens()->delete();
        $data = [
            'status' => 'success',
            'message' => 'logout',
        ];
        return $data;
    }
    public function getAllCustomer()
    {
        $users = User::where('role', 'customer')->paginate(10);
        $data = [
            'data' => $users
        ];
        return response($data, 200);
    }
    public function getCustomerByName($name){
        $users = User::where('role', 'customer')
                        ->where('first_name', 'like', $name .'%')
                        ->orWhere('last_name', 'like', $name . '%')->get();
        $data = [
            'status' => 'success',
            'data' => $users
        ];
        return response($data, 200);
    }
    public function createAccount($request){
        $already_exist = bankAccount::where('number_account', $request->input('number_account'))->first();
        if($already_exist) {
            $data = [
                'status' => 'error',
                'message'=>'conflict.account is already exit',
                'data'=> $already_exist
            ];
            return response($data,409);
        }
        $bank_account = new bankAccount();
        $bank_account->user_id = $request->input('user_id');
        $bank_account->number_account = $request->input('number_account');
        $bank_account->balance = $request->input('balance');
        $bank_account->save();
        $data = [
            'status' => 'success',
            'data' => $bank_account
        ];
        return response($data, 201);
    }

 }
