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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Razao Social para pessoa Juridica');
            $table->string('fantasy_name')->nullable();
            $table->integer('type');
            $table->string('register')->comment('CPF para pessoa física e CNPJ para pessoa jurídica')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->float('balance')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
