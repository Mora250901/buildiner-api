<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('inspecciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('construccion_id')->constrained('construcciones')->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->date('fecha_inspeccion');
            $table->enum('estado_encontrado', [
                'en_planos',
                'cimientos',
                'estructura',
                'albañileria',
                'acabados',
                'culminada',
                'paralizada',
            ]);
            $table->integer('avance_porcentaje')->default(0);
            $table->text('descripcion')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('inspecciones');
    }
};