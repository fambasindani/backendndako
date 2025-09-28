<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTypeProprietesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

    Schema::create('type_proprietes', function (Blueprint $table) {
    $table->id();
    $table->string('nom_propriete')->unique();
    $table->boolean('etat')->default(1);
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
        Schema::dropIfExists('type_proprietes');
    }
}
