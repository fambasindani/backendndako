<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUtilisateursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
         $table->id();
        $table->integer('id_type_compte');
        $table->string('prenom');
        $table->string('nom_famille');
        $table->string('email')->unique();
        $table->string('telephone');
        $table->string('password');
        $table->string('role');
        $table->boolean('etat')->default(true);
        $table->boolean('statut')->default(true);
        $table->timestamps();
        $table->string('avatar');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('utilisateurs');
    }
}
