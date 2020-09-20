<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTestingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('testings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('time', 8)->default('00:00:00');
            $table->json('questions')->default('[]');

            $table->unsignedBigInteger('creator_id')->index();

            $table->foreign('creator_id')->references('id')
                ->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('app_models_testings');
    }
}
