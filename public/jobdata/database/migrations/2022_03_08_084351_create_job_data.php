<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_data', function (Blueprint $table) {
            $table->id();
            $table->string("job_title")->nullable();
            $table->string("company")->nullable();
            $table->string("website")->nullable();
            $table->string("industry")->nullable();
            $table->string("salary")->nullable();
            $table->string("remote")->nullable();
            $table->string("area")->nullable();
            $table->string("city")->nullable();
            $table->string("state")->nullable();
            $table->string("zipcode")->nullable();
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
        Schema::dropIfExists('job_data');
    }
};
