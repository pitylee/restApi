<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Employees;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Employees::TABLE, function (Blueprint $table) {
            $table->id();
            $table->text('name');
            $table->unsignedInteger('position')->nullable();
            $table->unsignedInteger('superior')->nullable();
            $table->date('startDate');
            $table->date('endDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
