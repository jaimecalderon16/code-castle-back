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
        Schema::create('tags_apps', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('app_id')->constrained('apps');
            $table->timestamps();
        });

        Schema::table('apps', function (Blueprint $table) {
            $table->decimal('qualification')->nullable()->change();
            $table->date('upload_date')->nullable()->change();
            $table->integer('n_downloads')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags_apps');
    }
};
