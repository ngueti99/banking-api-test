<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = $this->userService->getAllCustomer();
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'first_name' => 'required|string|min:4|max:24',
                'role' => 'required',
                'last_name' => 'required|string|min:4|max:24',
                'phone' => 'sometimes|string',
                'email' => ['string', 'email', 'max:255', Rule::requiredIf(empty($request->phone))],
                'password' => [
                    'required',
                    'string'
                ],
            ]
        );
        $data = $this->userService->createUser($request);
        return $data;
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $data= [
            'status' =>'error',
            'message' => 'unauthenticated',
        ] ;
        return response($data, 403);
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
    public function logout()
    {
        $data = $this->userService->logout();
        return $data;
    }
    public function login(Request $request)
    {
        $this->validate(
            $request,
            [
                'email' => ['string', 'email', 'max:255'],
                'password' => [
                    'required'
                ],
            ]
        );
        $data = $this->userService->login($request);
        return $data;
    }
    public function getCustomerByName(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => ['string'],
            ]
        );
        $data = $this->userService->getCustomerByName($request->input('name'));
        return $data;
    }
    public function createAccount(Request $request)
    {
        $this->validate(
            $request,
            [
                'number_account' => 'required',
                'user_id' => 'required'
            ]
        );

        $data = $this->userService->createAccount($request);
        return $data;
    }
}
