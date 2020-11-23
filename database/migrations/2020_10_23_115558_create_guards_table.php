<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guards', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('img')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('gender')->nullable();
            $table->string('national_id')->unique();
            $table->string('email')->nullable();
            $table->string('password')->nullable();
            $table->string('kept_pin')->nullable();
            $table->string('api_token')->nullable();
            $table->integer('security_id')->nullable();
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
        Schema::dropIfExists('guards');
    }
}
