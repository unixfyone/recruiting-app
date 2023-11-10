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
        Schema::table('profiles', function(Blueprint $table){
            $table->string('country_id',4)->change();
            $table->string('state_id',4)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function(Blueprint $table){
            $table->integer('country_id')->change();
            $table->integer('state_id')->change();
        });
    }
};
