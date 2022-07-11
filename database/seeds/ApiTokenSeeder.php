<?php

use App\Models\ApiToken;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
                'token' => Hash::make(Str::random(8), [
                    'memory' => 1024,
                    'time' => 2,     
                    'threads' => 2,       
                ])
            ]
        ];

        foreach($tokens as $token) {
            ApiToken::query()->updateOrCreate(['client' => $token['client']], $token);
        }
    }
}
