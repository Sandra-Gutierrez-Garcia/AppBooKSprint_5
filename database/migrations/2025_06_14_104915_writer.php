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
        //
        Schema::create('writer', function (Blueprint $table) {
        $table->uuid('idwriter')->primary();
        $table->string('name');
        $table->string('username')->unique();
        $table->text('biography')->nullable();
        $table->string('photo')->nullable();
        $table->string('iduser')->unique();
        $table->foreign('iduser')->references('id')->on('users')->onDelete('cascade');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('writer');
    }
};
