<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConnectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('connects', function (Blueprint $table) {
            $table->id();
            $table->string('chat_id');
            $table->integer('status')->default(-1);
            $table->string('gender')->default('any');
            $table->string('province')->default('any');
            $table->string('city')->default('any');
            $table->string('connected_to')->default(0);
            $table->string('user_gender')->nullable();
            $table->integer('user_city')->nullable();
            $table->integer('province_id')->nullable();
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
        Schema::dropIfExists('connects');
    }
}
