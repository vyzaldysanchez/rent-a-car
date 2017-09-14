<?php

use App\Models\Enums\VehicleState;
use App\Models\Vehicle;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->string('chassis_number', Vehicle::CHASSIS_LENGTH);
            $table->string('engine_number', Vehicle::ENGINE_LENGTH);
            $table->string('plate_number', Vehicle::PLATE_LENGTH);

            $table->integer('vehicle_type_id')->unsigned()->default(0);
            $table->integer('vehicle_brand_id')->unsigned()->default(0);
            $table->integer('vehicle_model_id')->unsigned()->default(0);
            $table->integer('fuel_id')->unsigned()->default(0);

            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');
            $table->foreign('vehicle_brand_id')->references('id')->on('vehicle_brands');
            $table->foreign('vehicle_model_id')->references('id')->on('vehicle_models');
            $table->foreign('fuel_id')->references('id')->on('fuels');

            $table->enum('state', VehicleState::getStates())->default(VehicleState::AVAILABLE);
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
        Schema::dropIfExists('vehicles');
    }
}
