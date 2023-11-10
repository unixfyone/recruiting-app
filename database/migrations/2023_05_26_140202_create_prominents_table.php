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
        Schema::create('prominents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('profile_id')->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
            $table->string('comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prominents');
    }
};
