<h1>{{ $modo }} Empleado</h1>

@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif  

<div class="form-group mb-3">
    <label for="Nombre" class="form-label">Nombre</label>
    <input type="text" id="Nombre" name="Nombre" class="form-control"
           value="{{ old('Nombre', $empleado->Nombre ?? '') }}"
           pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
</div>

<div class="form-group mb-3">
    <label for="ApellidoPaterno" class="form-label">Apellido Paterno</label>
    <input type="text" id="ApellidoPaterno" name="ApellidoPaterno" class="form-control"
        value="{{ old('ApellidoPaterno', $empleado->ApellidoPaterno ?? '') }}"
        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
</div>

<div class="form-group mb-3">
    <label for="ApellidoMaterno" class="form-label">Apellido Materno</label>
    <input type="text" id="ApellidoMaterno" name="ApellidoMaterno" class="form-control"
        value="{{ old('ApellidoMaterno', $empleado->ApellidoMaterno ?? '') }}"
        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
</div>

<div class="form-group mb-3">
    <label for="Correo" class="form-label">Correo</label>
    <input type="email" id="Correo" name="Correo" class="form-control"
        value="{{ old('Correo', $empleado->Correo ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="Telefono" class="form-label">Teléfono</label>
    <input type="tel" id="Telefono" name="Telefono" class="form-control"
        value="{{ old('Telefono', $empleado->Telefono ?? '') }}"
        pattern="[0-9]{8,15}">
</div>

<div class="form-group mb-3">
    <label for="Direccion" class="form-label">Dirección</label>
    <input type="text" id="Direccion" name="Direccion" class="form-control"
        value="{{ old('Direccion', $empleado->Direccion ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="Puesto" class="form-label">Puesto</label>
    <input type="text" id="Puesto" name="Puesto" class="form-control"
        value="{{ old('Puesto', $empleado->Puesto ?? '') }}"
        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+">
</div>

<div class="form-group mb-3">
    <label for="Salario" class="form-label">Salario</label>
    <input type="number" id="Salario" name="Salario" step="0.01" min="0" class="form-control"
        value="{{ old('Salario', $empleado->Salario ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="FechaInicio" class="form-label">Fecha de Inicio</label>
    <input type="date" id="FechaInicio" name="FechaInicio" class="form-control"
        value="{{ old('FechaInicio', $empleado->FechaInicio ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="FechaNacimiento" class="form-label">Fecha de Nacimiento</label>
    <input type="date" id="FechaNacimiento" name="FechaNacimiento" class="form-control"
        value="{{ old('FechaNacimiento', $empleado->FechaNacimiento ?? '') }}"
        max="{{ date('Y-m-d') }}">
</div>

<div class="form-group mb-3">
    <label for="EstadoCivil" class="form-label">Estado Civil</label>
    <select id="EstadoCivil" name="EstadoCivil" class="form-select">
        <option value="" disabled {{ old('EstadoCivil', $empleado->EstadoCivil ?? '') == '' ? 'selected' : '' }}>Seleccione una opción</option>
        <option value="Soltero/a" {{ old('EstadoCivil', $empleado->EstadoCivil ?? '') == 'Soltero/a' ? 'selected' : '' }}>Soltero/a</option>
        <option value="Casado/a" {{ old('EstadoCivil', $empleado->EstadoCivil ?? '') == 'Casado/a' ? 'selected' : '' }}>Casado/a</option>
        <option value="Divorciado/a" {{ old('EstadoCivil', $empleado->EstadoCivil ?? '') == 'Divorciado/a' ? 'selected' : '' }}>Divorciado/a</option>
        <option value="Viudo/a" {{ old('EstadoCivil', $empleado->EstadoCivil ?? '') == 'Viudo/a' ? 'selected' : '' }}>Viudo/a</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="Sexo" class="form-label">Sexo</label>
    <select id="Sexo" name="Sexo" class="form-select">
        <option value="" disabled {{ old('Sexo', $empleado->Sexo ?? '') == '' ? 'selected' : '' }}>Seleccione el sexo</option>
        <option value="Masculino" {{ old('Sexo', $empleado->Sexo ?? '') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
        <option value="Femenino" {{ old('Sexo', $empleado->Sexo ?? '') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
        <option value="Otro" {{ old('Sexo', $empleado->Sexo ?? '') == 'Otro' ? 'selected' : '' }}>Otro</option>
    </select>
</div>

<div class="form-group mb-3">
    <label for="Dni" class="form-label">DNI</label>
    <input type="text" id="Dni" name="Dni" class="form-control"
        pattern="[0-9]{6,15}"
        value="{{ old('Dni', $empleado->Dni ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="Nacionalidad" class="form-label">Nacionalidad</label>
    <input type="text" id="Nacionalidad" name="Nacionalidad" class="form-control"
        pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
        value="{{ old('Nacionalidad', $empleado->Nacionalidad ?? '') }}">
</div>

<div class="form-group mb-3">
    <label for="Foto" class="form-label">Foto</label>
    <input type="file" id="Foto" name="Foto" class="form-control" accept="image/*">
    @if (!empty($empleado->Foto))
        <img class="img-thumbnail img-fluid mt-2" src="{{ asset('storage/' . $empleado->Foto) }}" alt="Foto actual" width="80">
    @endif
</div>

<div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">{{ $modo }} datos</button>
    <a href="{{ route('empleado.index') }}" class="btn btn-secondary">Volver</a>
</div>
