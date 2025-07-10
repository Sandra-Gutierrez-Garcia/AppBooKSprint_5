<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('book',function(Blueprint $table){
            $table->bigIncrements('idbook');
            $table->uuid('idwriter'); 
            $table->foreign('idwriter')->references('idwriter')->on('writer')->onDelete('cascade');
            $table->string('title');
            $table->string('description');
            $table->date('publish_date')->nullable();
            $table->string('photo')->nullable();
            $table->text('content'); // Añadir campo faltante
            $table->timestamps(); // Agregar timestamps






    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('book');
    }
};
