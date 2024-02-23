<?php

namespace Tests;

use Database\Seeders\DatabaseSeeder;
use Database\Seeders\TypeTransactionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    public function login()
    {

        $response = $this->post('/api/v1/user/login', [
            "email" => "nbi@gmail.com",
            "password" => "747755738"
        ]);
        $data = $response->json('data');
        return $data['token']['value'];
    }
    protected function seedDatabase()
    {
        $seeder = new DatabaseSeeder();
        $seeder->call(TypeTransactionSeeder::class);
    }
}
