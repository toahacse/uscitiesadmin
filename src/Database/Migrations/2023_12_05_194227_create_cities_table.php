<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */

    public function up()
    {
        Schema::create('cities', function (Blueprint $table) {            
            $table->id();
            $table->uuid('uuid');
            $table->string('city')->nullable();
            $table->string('city_ascii')->nullable();
            $table->string('state_id')->nullable();
            $table->string('state_name')->nullable();
            $table->integer('county_fips')->nullable();
            $table->string('county_name')->nullable();
            $table->string('lat')->nullable();
            $table->string('lng')->nullable();
            $table->integer('population')->nullable();
            $table->integer('density')->nullable();
            $table->string('source')->nullable();
            $table->string('military')->nullable();
            $table->string('incorporated')->nullable();
            $table->string('timezone')->nullable();
            $table->integer('ranking')->nullable();
            $table->string('zips')->nullable();
            $table->timestamps();
            $table->unsignedInteger('created_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cities');
    }
};
