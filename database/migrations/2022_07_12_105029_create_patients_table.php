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
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->string('first_name') -> nullable();
            $table->string('last_name') -> nullable();
            $table->string('email') -> unique('email');
            $table->string('mobile') -> unique();
            $table->string('password');
            $table->text('photo') -> nullable();
            $table->string('deta_of_birth') -> nullable();
            $table->integer('age') -> nullable();
            $table->string('blood_group') -> nullable();
            $table->string('adress') -> nullable();
            $table->string('country') -> nullable();
            $table->string('city') -> nullable();
            $table->string('location') -> nullable();
            $table->string('access_token') -> nullable();
            $table->boolean('status') ->default(false);
            $table->boolean('trash') ->default(false);
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
        Schema::dropIfExists('patients');
    }
};
