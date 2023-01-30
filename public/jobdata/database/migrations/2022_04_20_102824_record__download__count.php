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
        Schema::create('record_download_count', function (Blueprint $table) {
            $table->id();
            $table->string("user_email");
            $table->integer("today_count")->default(0);
            $table->integer("month_count")->default(0);
            $table->integer("all_time_count")->default(0);
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
        Schema::dropIfExists("record_download_count");
    }
};
