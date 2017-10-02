<?php

use App\Models\Enums\CommonStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehicleModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicle_models', function (Blueprint $table) {
            $table->increments('id');
            $table->text('description');
            $table->enum('state', [CommonStatus::ACTIVE, CommonStatus::INACTIVE])
                ->default(CommonStatus::ACTIVE);
            $table->timestamps();
            $table->integer('vehicle_brand_id')->unsigned()->default(0);
            $table->foreign(['vehicle_brand_id'])->references('id')->on('vehicle_brands')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vehicle_models');
    }
}
