<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserReleaseShelfTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_release_shelf', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_release_id')->unsigned();
            $table->integer('shelf_id')->unsigned();
            $table->timestamps();

            $table->foreign('user_release_id')
                ->references('id')
                ->on('user_releases')
                ->onDelete('cascade');

            $table->foreign('shelf_id')
                ->references('id')
                ->on('shelves')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_release_shelf');
    }
}
