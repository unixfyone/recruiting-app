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
        Schema::create('education', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id')->nullable(); //Obligatorio
            $table->string('institution', 100)->nullable();
            $table->enum('level', ['Primaria', 'Bachiller', 'Técnico', 'Universitario', 'Especialización', 'Curso', 'Diplomado', 'Postgrado', 'Doctorado', 'Postdoctorado']);
            $table->string('tesis_title', 200)->nullable(); //Si es universitario+
            $table->boolean('currently')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable(true);
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('education');
    }
};
