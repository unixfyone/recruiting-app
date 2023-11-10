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
            $table->string('area_interest')->change()->nullable(true)->after('languages');
            $table->string('uri_cv')->nullable(false)->after('area_interest');
            $table->string('title',60)->nullable(true)->after('last_name');
            $table->enum('status_general',['Nuevo','Visto','Destacado','Blacklist'])->nullable(false)->after('uri_cv');
            $table->enum('status',['Incompleto','Completado'])->nullable(false)->after('status_general');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profiles', function(Blueprint $table){
            $table->string('area_interest')->change()->nullable(true)->after('updated_at');
            $table->dropColumn('uri_cv');
            $table->dropColumn('title');
            $table->dropColumn('status_general');
            $table->dropColumn('status');
        });
    }
};
