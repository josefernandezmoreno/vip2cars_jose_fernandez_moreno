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
          Schema::dropIfExists('cliente_vehiculo');

        Schema::create('cliente_vehiculo', function (Blueprint $table) {
            $table->id(); // id autoincremental BIGINT UNSIGNED
            $table->unsignedInteger('cliente_id'); // coincide con clientes.idCliente (INT UNSIGNED)
            $table->unsignedBigInteger('vehiculo_id'); // coincide con vehiculos.id (BIGINT UNSIGNED)
            $table->text('observaciones')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('cliente_id')
                  ->references('idCliente')
                  ->on('clientes')
                  ->onDelete('cascade');

            $table->foreign('vehiculo_id')
                  ->references('id')
                  ->on('vehiculos')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cliente_vehiculos');
    }
};
