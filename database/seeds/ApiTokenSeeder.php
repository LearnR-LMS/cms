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
            ]
        ];

        foreach($tokens as $token) {
            ApiToken::query()->updateOrCreate(['client' => $token['client']], $token);
        }
    }
}
