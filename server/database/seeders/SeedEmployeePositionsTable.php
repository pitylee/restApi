<?php

namespace Database\Seeders;

use App\Models\EmployeePositions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SeedEmployeePositionsTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (['developer', 'management'] as $name) {
            EmployeePositions::create([
                'name' => ucfirst($name),
                'slug' => Str::slug($name, '-'),
            ]);
        }
    }
}
