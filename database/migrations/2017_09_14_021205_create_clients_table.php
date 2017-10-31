<?php

use App\Models\Enums\CommonStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 250);
            $table->string('identification_number', 13)->unique();
            $table->string('credit_card_number', 19);
            $table->float('credit_limit', 14, 2);

            $table->integer('person_type_id')->unsigned()->default(0);
            $table->foreign('person_type_id')->references('id')->on('person_types')->onDelete('cascade');

            $table->enum('state', CommonStatus::getAll())->default(CommonStatus::ACTIVE);
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
        Schema::dropIfExists('clients');
    }
}
