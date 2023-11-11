<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {Schema::dropIfExists('apps');
        Schema::create('apps', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('aplication_name');
            $table->string('description');
            $table->string('download_link');
            $table->decimal('qualification');
            $table->date('upload_date');
            $table->integer('n_downloads');
            $table->foreignId('user_id')->constrained('users');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apps');
    }
};
