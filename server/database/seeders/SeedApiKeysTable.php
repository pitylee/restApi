<?php

namespace Database\Seeders;

use App\Models\ApiKeys;
use Illuminate\Database\Seeder;

class SeedApiKeysTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ApiKeys::create([
            'api_key' => 'asd',
            'api_secret' => 'asd',
        ]);
    }
}
