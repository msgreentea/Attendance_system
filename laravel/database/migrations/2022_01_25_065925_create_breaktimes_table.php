<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBreaktimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('breaktimes', function (Blueprint $table) {
            $table->id();
            $table->id('attendances_id')->unsigned()->after('attendances');
            $table->foreign('attendances_id')->references('attendances_id')->on('id')->onDelete('cascade');
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
        // Schema::dropIfExists('breaktimes');
        Schema::dropIfExists('breaktimes', function (Blueprint $table) {
            $table->dropForeign('breaktimes_attendances_id_foreign');
        });
    }
}