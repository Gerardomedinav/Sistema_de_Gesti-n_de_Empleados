<?php

namespace App\Http\Controllers;

use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Laravel\Pail\ValueObjects\Origin\Console;

use function Illuminate\Log\log;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $datos['empleados'] = Empleado::paginate(5);
        return view('empleado.index', $datos);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $empleado = new Empleado(); // instancia vacía
        return view('empleado.create', compact('empleado'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {



        //
        $datosEmpleado = request()->except('_token');
        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email|max:50',
            'Telefono' => 'required|string|max:11',
            'Direccion' => 'required|string|max:100',
            'Puesto' => 'required|string|max:50',
            'Salario' => 'required|numeric',
            'FechaInicio' => 'required|date',
            'FechaNacimiento' => 'required|date',
            'EstadoCivil' => 'required|string|max:20',
            'Sexo' => 'required|string|max:10',
            'Dni' => 'required|string|max:8',
            'Nacionalidad' => 'required|string|max:50',
            'Foto' => 'nullable|image|max:2048'
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido',
            'Foto.image' => 'El archivo debe ser una imagen'

        ];
        $this->validate($request, $campos, $mensaje);



        if ($request->hasFile('Foto')) {
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }
        Empleado::insert($datosEmpleado);
        return redirect('empleado')->with('mensaje', 'Empleado agregado');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empleado $empleado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {


        $empleado = Empleado::findOrFail($id);
        return view('empleado.edit', compact('empleado'));
    }

    public function update(Request $request, $id)
    {
        $datosEmpleado = request()->except(['_token', '_method']);

        $campos = [
            'Nombre' => 'required|string|max:100',
            'ApellidoPaterno' => 'required|string|max:100',
            'ApellidoMaterno' => 'required|string|max:100',
            'Correo' => 'required|email|max:50',
            'Telefono' => 'required|string|max:11',
            'Direccion' => 'required|string|max:100',
            'Puesto' => 'required|string|max:50',
            'Salario' => 'required|numeric',
            'FechaInicio' => 'required|date',
            'FechaNacimiento' => 'required|date',
            'EstadoCivil' => 'required|string|max:20',
            'Sexo' => 'required|string|max:10',
            'Dni' => 'required|string|max:8',
            'Nacionalidad' => 'required|string|max:50',
           
        ];
        $mensaje = [
            'required' => 'El :attribute es requerido',
           

        ];

        if ($request->hasFile('Foto')) {
            $campos['Foto'] = 'required|max:10000|mimes:jpeg,png,jpg';
            $mensaje['Foto.required'] = 'La foto requerida';
        }
        $this->validate($request, $campos, $mensaje);






        if ($request->hasFile('Foto')) {
            $empleado = Empleado::findOrFail($id);
            Storage::delete('public/' . $empleado->Foto);
            $datosEmpleado['Foto'] = $request->file('Foto')->store('uploads', 'public');
        }

        Empleado::where('id', '=', $id)->update($datosEmpleado);

        return redirect('empleado')->with('mensaje', 'Empleado actualizado');
    }


    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $empleado = Empleado::findOrFail($id);

        if ($empleado->Foto && Storage::disk('public')->exists($empleado->Foto)) {
            Storage::disk('public')->delete($empleado->Foto);
        }

        Empleado::destroy($id);

        return redirect('empleado')->with('mensaje', 'Empleado eliminado');
    }
}
