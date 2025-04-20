@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Lista de Empleados</h1>
        <a href="{{ route('empleado.create') }}" class="btn btn-primary mb-3">Agregar Empleado</a>
        @if (Session::has('mensaje'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('mensaje') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif




        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Apellido Paterno</th>
                    <th>Apellido Materno</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Puesto</th>
                    <th>Salario</th>
                    <th>Fecha de Inicio</th>
                    <th>Fecha de Nacimiento</th>
                    <th>Estado Civil</th>
                    <th>Sexo</th>
                    <th>DNI</th>
                    <th>Nacionalidad</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->id }}</td>
                        <td>
                            @if ($empleado->Foto)
                                <img class="img-thumbnail img-fluid" src="{{ asset('storage/' . $empleado->Foto) }}"
                                    width="80" alt="Foto de {{ $empleado->Nombre }}">
                            @else
                                Sin foto
                            @endif
                        </td>
                        <td>{{ $empleado->Nombre }}</td>
                        <td>{{ $empleado->ApellidoPaterno }}</td>
                        <td>{{ $empleado->ApellidoMaterno }}</td>
                        <td>{{ $empleado->Correo }}</td>
                        <td>{{ $empleado->Telefono }}</td>
                        <td>{{ $empleado->Direccion }}</td>
                        <td>{{ $empleado->Puesto }}</td>
                        <td>{{ $empleado->Salario }}</td>
                        <td>{{ $empleado->FechaInicio }}</td>
                        <td>{{ $empleado->FechaNacimiento }}</td>
                        <td>{{ $empleado->EstadoCivil }}</td>
                        <td>{{ $empleado->Sexo }}</td>
                        <td>{{ $empleado->Dni }}</td>
                        <td>{{ $empleado->Nacionalidad }}</td>
                        <td>

                            <div class="d-flex gap-1">
                                <a href="{{ url('/empleado/' . $empleado->id . '/edit') }}"
                                    class="btn btn-warning btn-sm">Editar</a>

                                <form action="{{ url('/empleado/' . $empleado->id) }}" method="POST"
                                    onsubmit="return confirm('¿Seguro que deseas eliminar este empleado?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Eliminar</button>
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>
        {!! $empleados->links() !!}

    </div>
@endsection
