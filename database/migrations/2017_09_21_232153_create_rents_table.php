<?php

use App\Models\Enums\RentState;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rents', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('rent_date')->default(Carbon\Carbon::now());
            $table->dateTime('expected_return_date')->nullable();
            $table->dateTime('return_date')->nullable();
            $table->float('daily_fee')->default(0.00);
            $table->integer('duration_in_days')->default(1);
            $table->text('comment')->nullable();
            $table->enum('state', RentState::getAll())->default(RentState::ON_GOING);

            $table->integer('employee_id')->unsigned()->default(0);
            $table->foreign('employee_id')->references('id')->on('employees')->onDelete('cascade');
            $table->integer('vehicle_id')->unsigned()->default(0);
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');
            $table->integer('client_id')->unsigned()->default(0);
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');

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
        Schema::dropIfExists('rents');
    }
}
