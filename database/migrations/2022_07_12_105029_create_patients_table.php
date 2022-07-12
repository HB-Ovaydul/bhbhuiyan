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
            $table->string('first_name');
            $table->string('last_name') -> nullable();
            $table->string('email') -> unique();
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
            $table->boolean('status') ->default(true);
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
