<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrescribersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescribers', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('npi');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->bigInteger('phone');
            $table->integer('phone_extension')->nullable();
            $table->bigInteger('fax')->nullable();
            $table->enum('role', ['prescriber']);
            $table->boolean('is_admin');
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
        //
    }
}
