<?php

use App\Models\Enums\CommonStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 45);
            $table->string('identification_card', 11);
            $table->enum('work_schedule', [])->default('');//:TODO create schedule enum
            $table->float('commission_percent', 3)->default(0.00);
            $table->date('admission_date');
            $table->enum('state', CommonStatus::getAll())->default(CommonStatus::INACTIVE);
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
