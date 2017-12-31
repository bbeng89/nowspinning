<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUserProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->string('turntable')->nullable();
            $table->string('turntable_cartridge')->nullable();
            $table->string('cd_player')->nullable();
            $table->string('tape_deck')->nullable();
            $table->string('amp_receiver')->nullable();
            $table->string('preamp')->nullable();
            $table->string('speakers')->nullable();
            $table->string('subwoofer')->nullable();
            $table->string('other')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                ->references('id')
                ->on('users')
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
        Schema::dropIfExists('user_profiles');
    }
}
