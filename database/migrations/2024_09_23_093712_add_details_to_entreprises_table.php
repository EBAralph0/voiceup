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
        Schema::table('entreprises', function (Blueprint $table) {
            $table->date('date_anniversaire')->nullable();
            $table->string('siege_social')->nullable();
            $table->enum('nb_employes_interval', ['1-10', '11-50', '51-200', '201-500', '501+'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('entreprises', function (Blueprint $table) {
            $table->dropColumn(['date_anniversaire', 'siege_social', 'nb_employes_interval']);
        });
    }
};
