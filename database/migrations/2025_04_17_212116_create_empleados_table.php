<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */  public function up(): void
{
    Schema::create('empleados', function (Blueprint $table) {
        $table->id();
        $table->string('Nombre');
        $table->string('ApellidoPaterno');
        $table->string('ApellidoMaterno');
        $table->string('Correo')->unique(); // correo único
        $table->string('Telefono');
        $table->string('Direccion');
        $table->string('Puesto');
        $table->decimal('Salario', 10, 2); // mayor precisión que float
        $table->date('FechaInicio');
        $table->date('FechaNacimiento');
        $table->string('EstadoCivil', 20); // limita longitud
        $table->string('Sexo', 10);        // limita longitud
        $table->string('Dni')->unique();   // dni único
        $table->string('Nacionalidad');
        $table->string('Foto');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empleados');
    }
};
