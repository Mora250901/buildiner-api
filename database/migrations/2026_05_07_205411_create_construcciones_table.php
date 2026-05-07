<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('construcciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('distrito_id')->constrained()->onDelete('cascade');
            $table->string('direccion');
            $table->decimal('latitud', 10, 7)->nullable();
            $table->decimal('longitud', 10, 7)->nullable();
            $table->string('propietario')->nullable();
            $table->string('ingeniero_responsable')->nullable();
            $table->integer('numero_pisos')->default(1);
            $table->enum('estado', [
                'en_planos',
                'cimientos',
                'estructura',
                'albañileria',
                'acabados',
                'culminada',
                'paralizada',
            ])->default('en_planos');
            $table->boolean('tiene_licencia')->default(false);
            $table->string('numero_licencia')->nullable();
            $table->date('fecha_inicio')->nullable();
            $table->date('fecha_estimada_fin')->nullable();
            $table->integer('avance_porcentaje')->default(0);
            $table->text('observaciones')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('construcciones');
    }
};