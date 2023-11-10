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
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id')->nullable(); //Obligatorio
            $table->string('position', 100)->nullable();
            $table->string('company_name', 200)->nullable();
            $table->text('functions')->nullable();
            $table->boolean('currently')->nullable();
            $table->date('date_from')->nullable();
            $table->date('date_to')->nullable(null);
            $table->timestamps();
            $table->foreign('profile_id')->references('id')->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
