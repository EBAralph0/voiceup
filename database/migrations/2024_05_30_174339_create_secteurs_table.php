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
        Schema::create('entreprises', function (Blueprint $table) {
            $table->string('id_entreprise')->primary();
            $table->string('nom_entreprise');
            $table->string('sigle');
            $table->string('slogan');
            $table->string('description');
            $table->string('numero_entreprise')->unique();
            $table->string('mail_entreprise')->unique();
            $table->string('logo_entreprise')->nullable();
            $table->string('id_secteur');
            $table->foreignId('created_by_id')->nullable()->constrained('users');
            $table->foreign('id_secteur')->references('id_secteur')->on('secteurs');
            $table->unsignedBigInteger('proprietaire_id')->nullable();
            $table->foreign('proprietaire_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('entreprises');
    }
};
