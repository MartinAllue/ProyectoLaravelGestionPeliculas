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
        Schema::create('movies', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->string('director');
            $table->year('anio');
            $table->integer('duracion')->nullable();
            $table->string('genero');
            $table->text('sinopsis')->nullable();
            $table->string('reparto')->nullable();
            $table->string('pais');
            $table->string('imagen_url')->nullable();
            $table->string('clasificacion_edad')->nullable();
            $table->decimal('valoracion_media', 3, 2)->nullable();

            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};
