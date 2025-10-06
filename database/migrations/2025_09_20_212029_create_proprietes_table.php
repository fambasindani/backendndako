<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProprietesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proprietes', function (Blueprint $table) {
        $table->id();
        $table->integer('id_utilisateur');
        $table->integer('id_type');
        $table->integer('id_province');
        $table->integer('id_ville');
        $table->integer('id_commune');
        $table->string('quartier');
        $table->string('avenue');
        $table->decimal('prix', 12, 2);
        $table->integer('nombre_chambre');
        $table->integer('nombre_salle_de_bain');
        $table->decimal('dimension', 8, 2);
        $table->string('description', 500);
        $table->string('image_principale');
        $table->json('autres_images')->nullable();
        $table->boolean('statut');
        $table->boolean('statut1')->default(false);
        $table->boolean('etat')->default(true);
        $table->decimal('latitude', 10, 7)->nullable(); // Ajout de la colonne latitude
        $table->decimal('longitude', 10, 7)->nullable(); // Ajout de la colonne longitude
        $table->timestamp('date_enregistrement')->nullable();
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
        Schema::dropIfExists('proprietes');
    }
}
