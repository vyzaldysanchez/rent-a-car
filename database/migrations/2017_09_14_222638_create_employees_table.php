<?php

use App\Models\Enums\CommonStatus;
use App\Models\Enums\EmployeeWorkSchedule;
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
            $table->string('identification_card', 11)->unique();
            $table->enum('work_schedule', EmployeeWorkSchedule::getAll());
            $table->float('commission_percent', 3)->default(0.00);
            $table->date('admission_date');
            $table->enum('state', CommonStatus::getAll())->default(CommonStatus::INACTIVE);

            $table->integer('user_id')->unsigned()->default(0);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

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
