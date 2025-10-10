<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gastos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // relación con usuario
            $table->unsignedBigInteger('presupuesto_id'); // relación con presupuesto
            $table->string('descripcion');
            $table->decimal('monto', 10, 2);
            $table->date('fecha'); // fecha del gasto
            $table->timestamps();

            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('presupuesto_id')->references('id')->on('presupuestos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gastos');
    }
};
