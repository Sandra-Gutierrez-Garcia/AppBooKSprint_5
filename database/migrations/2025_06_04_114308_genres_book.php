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
        Schema::create('genres_book',function(Blueprint $table){
            $table->unsignedBigInteger('idgenre');
            $table->unsignedBigInteger('idbook');
            $table->foreign('idgenre')->references('idgenre')->on('genre')->onDelete('cascade');
            $table->foreign('idbook')->references('idbook')->on('book')->onDelete('cascade');


        });

        //
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('genres-book');
    }
};
