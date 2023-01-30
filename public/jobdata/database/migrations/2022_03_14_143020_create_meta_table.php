<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMetaTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create(config('meta.table_name'), function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id');
            $table->string('model_type');
            $table->string('meta_key');
            $table->string('meta_value')->nullable();
            $table->timestamps();

            $table->index('model_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists(config('meta.table_name'));
    }
}
