<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrebuiltTaskTrackings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prebuilt_folder_task', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('prebuilt_folder_id')->index();
            $table->unsignedBigInteger('task_id')->index();
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
        Schema::dropIfExists('prebuilt_folder_task');
    }
}
