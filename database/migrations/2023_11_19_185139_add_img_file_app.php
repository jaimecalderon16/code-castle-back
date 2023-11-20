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
        Schema::table('apps', function (Blueprint $table) {
            $table->text('img_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->text('img_path')->nullable();
        });

        Schema::table('apps', function (Blueprint $table) {
            $table->string('version');
            $table->string('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apps', function (Blueprint $table) {
            $table->dropColumn('img_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('img_path');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('version');
            $table->dropColumn('company');
        });
    }
};
