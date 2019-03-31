<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCustomUserModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_user_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname',50)->nullable();
            $table->date('birthdate',25)->nullable();
            $table->string('username',25)->nullable()->unique();
            $table->string('password',120)->nullable();
            $table->string('photo',15)->nullable();
            $table->datetime('date_last_login')->nullable();
            $table->integer('visitor',11)->nullable();
            $table->string('email',25)->nullable();
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
        Schema::dropIfExists('custom_user_models');
    }
}
