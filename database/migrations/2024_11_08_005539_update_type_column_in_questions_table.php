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
        Schema::table('questions', function (Blueprint $table) {
            // Supprimez d'abord la colonne `type` pour la recréer
            $table->dropColumn('type');
        });

        Schema::table('questions', function (Blueprint $table) {
            // Recréez la colonne `type` avec l'ajout de `numericrange`
            $table->enum('type', ['onechoice', 'multiplechoice', 'textanswer', 'numericrange'])->default('onechoice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('type');
        });

        Schema::table('questions', function (Blueprint $table) {
            $table->enum('type', ['onechoice', 'multiplechoice', 'textanswer'])->default('onechoice');
        });
    }
};
