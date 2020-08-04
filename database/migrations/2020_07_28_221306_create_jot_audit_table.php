<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJotAuditTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jot_audits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('author_id')->index();
            $table->unsignedBigInteger('jot_id')->index();
            $table->boolean('is_admin')->default(0);
            $table->boolean('read')->default(0);
            //author id
            //jot id
            //isAdmin
            //boolean read by audience if
            //user get any unread admin audits for jots you own
            //admin get any unread audits by users
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
        Schema::dropIfExists('jot_audits');
    }
}
