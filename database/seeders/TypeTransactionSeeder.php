<?php

namespace Database\Seeders;

use App\Models\TypeTransaction;
use Illuminate\Database\Seeder;

class TypeTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $deposit = new TypeTransaction([
            'name' => 'deposit',
        ]);
        $deposit->save();

        $withdrawal = new TypeTransaction([
            'name' => 'withdrawal',
        ]);
        $withdrawal->save();

        $transfer = new TypeTransaction([
            'name' => 'transfer',
        ]);
        $transfer->save();
    }
}
