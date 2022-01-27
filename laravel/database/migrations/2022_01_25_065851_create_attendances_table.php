<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->id('user_id')->unsigned()->after('users');
            $table->foreign('user_id')->references('users_id')->on('id')->onDelete('cascade');
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time')->nullable();
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attendances', function (Blueprint $table) {
            $table->dropforeign('attendance_user_id_foreign');
        });
    }
}