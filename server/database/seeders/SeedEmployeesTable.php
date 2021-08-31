<?php

namespace Database\Seeders;

use App\Models\Employees;
use App\Models\EmployeePositions;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Carbon\Carbon;
use Nubs\RandomNameGenerator\All as RandomName;

class SeedEmployeesTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $randomEmployees = Employees::inRandomOrder()->first();
            $randomPositions = EmployeePositions::inRandomOrder()->first();

            Employees::create([
                'name' => RandomName::create()->getName(),
                'position' => Arr::random(array_merge(
                    $randomPositions ? $randomPositions->pluck('id')->toArray() : [],
                    [null]
                )),
                'superior' => Arr::random(array_merge(
                    $randomEmployees ? $randomEmployees->pluck('id')->toArray() : [],
                    [null]
                )),
                'startDate' => Carbon::now()->subDays(rand(0, 365 * 5))->format('Y-m-d'),
                'endDate' => Arr::random([
                    Carbon::now()->addDays(rand(0, 365 * 5))->format('Y-m-d'),
                    null,
                ]),
            ]);
        }
    }
}
