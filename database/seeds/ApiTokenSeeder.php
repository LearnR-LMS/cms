<?php

use App\Models\ApiToken;
use Illuminate\Database\Seeder;

class ApiTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tokens = [
            [
                'client' => 'eFox',
                'token' => '$2y$10$LPGvaMwX70htWg/O/gT.LuLC7h6cZZOGV2csGjBZzm8xT1rEry2UK'
            ],
            [
                'client' => 'lr',
                'token' => '65870fafa7946927b6a5f3fcab1ed6439a91b8f9'
            ]
        ];

        foreach($tokens as $token) {
            ApiToken::query()->updateOrCreate(['client' => $token['client']], $token);
        }
    }
}
