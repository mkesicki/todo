<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string("firstname");
            $table->string("lastname");
            $table->string("email")->unique();
            $table->date("birthdate");
            $table->string("phone");
            $table->string("password");
            $table->enum('gender', ["male", "female"]); //should we be more fancy here :)
            $table->string('api_key')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
        Schema::dropIfExists('categories');
        Schema::dropIfExists('lists');
        Schema::dropIfExists('users');
    }
}
