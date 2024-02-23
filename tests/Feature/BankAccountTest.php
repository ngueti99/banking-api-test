<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BankAccountTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_store_employer(): void
    {
        $this->seedDatabase();
        $response = $this->post('/api/v1/user/register', [
            "first_name" => "brice",
            "last_name" => "ngueti",
            "password" => "747755738",
            "email" => "nbi@gmail.com",
            "role" => "employer"
        ]);

        $response->assertStatus(201);
    }
    public function test_store_customer(): void
    {
        $response = $this->post('/api/v1/user/register', [
            "first_name" => "noni",
            "last_name" => "filio",
            "password" => "733747483",
            "email" => "huoln@gmail.com",
            "role" => "customer",
        ]);

        $response->assertStatus(201);
    }
    public function test_login(): void
    {

        $response = $this->post('/api/v1/user/login', [
            "email" => "nbi@gmail.com",
            "password" => "747755738"
        ]);
        $token = $response->json('access_token');
        $response->assertStatus(200);
    }
    public function test_seach_customer(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->get('/api/v1/customer/search', [
            "name" => "noni"
        ]);
        $response->assertStatus(200);
    }
    public function test_get_all_customer(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->get('/api/v1/customer/index');
        $response->assertStatus(200);
    }
   
    public function test_create_bank_account(): void
    {

        $this->withoutExceptionHandling();

        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->post('/api/v1/account/create', [
            "number_account" => "38843943984935",
            "balance" => "400",
            "user_id" => "1"
        ]);
        $response = $this->withHeaders($headers)->post('/api/v1/account/create', [
            "number_account" => "388439434935",
            "balance" => "400",
            "user_id" => "1"
        ]);

        $response->assertStatus(201);
    }
    public function test_store_transaction(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->post('/api/v1/transaction/store', [
            "receiver_bank_account_id" => "1",
            "transmitter_bank_account_id" => "2",
            "type_transaction_id" => "3",
            "user_id" => "1",
            "amount" => "100",

        ]);

        $response->assertStatus(201);
    }
    public function test_history_transaction(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->get('/api/v1/transaction/history/1');
        $response->assertStatus(200);
    }
    public function test_balance(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->get('/api/v1/transaction/balance/1');
        $response->assertStatus(200);
    }
    public function test_logout(): void
    {
        $this->withoutExceptionHandling();
        $token = $this->login();
        $headers = [
            'Authorization' => 'Bearer ' . $token,
        ];
        $response = $this->withHeaders($headers)->post('/api/v1/user/logout');
        $response->assertStatus(200);
    }
}
