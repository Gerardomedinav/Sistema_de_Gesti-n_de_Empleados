<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $table = 'empleados';

    protected $fillable = [
        'Nombre',
        'ApellidoPaterno',
        'ApellidoMaterno',
        'Correo',
        'Telefono',
        'Direccion',
        'Puesto',
        'Salario',
        'FechaInicio',
        'FechaNacimiento',
        'EstadoCivil',
        'Sexo',
        'Dni',
        'Nacionalidad',
        'Foto',
    ];
}
