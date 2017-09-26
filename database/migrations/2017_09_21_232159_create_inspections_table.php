<?php

use App\Models\Enums\VehicleTireStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInspectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inspections', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('has_scratches')->default(0);
            $table->boolean('has_spare_tire')->default(0);
            $table->boolean('has_jack')->default(0);
            $table->boolean('has_broken_glasses')->default(0);
            $table->float('fuel_qty', 8, 2);
            $table->dateTime('date')->default(\Carbon\Carbon::now());
            $table->enum('top_left_tire_state', VehicleTireStatus::getAll())->default(VehicleTireStatus::NEW);
            $table->enum('top_right_tire_state', VehicleTireStatus::getAll())->default(VehicleTireStatus::NEW);
            $table->enum('bottom_left_tire_state', VehicleTireStatus::getAll())->default(VehicleTireStatus::NEW);
            $table->enum('bottom_right_tire_state', VehicleTireStatus::getAll())->default(VehicleTireStatus::NEW);

            $table->integer('rent_id')->unsigned()->default(0);
            $table->foreign('rent_id')->references('id')->on('rents');
            $table->integer('client_id')->unsigned()->default(0);
            $table->foreign('client_id')->references('id')->on('clients');
            $table->integer('employee_id')->unsigned()->default(0);
            $table->foreign('employee_id')->references('id')->on('employees');

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
        Schema::dropIfExists('inspections');
    }
}
