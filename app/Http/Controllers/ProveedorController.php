<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Proveedor;

class ProveedorController extends Controller
{
    public $idProveedor, $dni_pv, $nombre_pv, $contacto_pv, $telefono_pv, $direccion_pv, $user_id, $estado_pv;
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pv = Proveedor::all();
        return view('Proveedores.index')->with('pv', $pv);
    }

    public function validarDni(Request $request)
    {
        $dni = Controller::limpiarCadena($request->input('dni'));
        $exists = Proveedor::where('dni_pv', $dni)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'dni_pv' => ['required', 'unique:proveedors'],
                'nombre_pv' => ['required', 'string']
            ]);
            $user_idDB = Auth::id();
            $obj = new Proveedor();
            $obj->dni_pv = Controller::limpiarCadena($request->get('dni_pv'));
            $obj->nombre_pv = Controller::limpiarCadena(strtoupper($request->get('nombre_pv')));
            $obj->contacto_pv = Controller::limpiarCadena(strtoupper($request->get('contact')));
            $obj->telefono_pv = Controller::limpiarCadena($request->get('tel'));
            $obj->direccion_pv = Controller::limpiarCadena(strtoupper($request->get('direccion')));
            $obj->user_id = $user_idDB;
            $obj->estado_pv = 'ACTIVO';
            $obj->save();

            return redirect('/proveedores/');
        } catch (ValidationException $e) {
            //echo $e->validator->errors();
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function show($id)
    {
        /* echo $id;
        $idLimp = Controller::limpiarCadena($id);
        $pv = Proveedor::where('dni_pv', $idLimp)->get();
        return view('Proveedores.show')->with('proveedor', $pv); */
    }

    public function edit($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $pv = Proveedor::where('idProveedor', $idLimp)->get();
        return view('Proveedores.edit')->with('proveedores', $pv);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'dni_pv' => ['required', 'int'],
                'nombre_pv' => ['required', 'string']
            ]);
            $idLimp = Controller::limpiarCadena($id);
            $obj = Proveedor::find($idLimp);
            $obj->dni_pv = Controller::limpiarCadena($request->get('dni_pv'));
            $obj->nombre_pv = Controller::limpiarCadena(strtoupper($request->get('nombre_pv')));
            $obj->contacto_pv = Controller::limpiarCadena(strtoupper($request->get('contact')));
            $obj->telefono_pv = Controller::limpiarCadena($request->get('tel'));
            $obj->direccion_pv = Controller::limpiarCadena(strtoupper($request->get('direccion')));
            $obj->estado_pv = Controller::limpiarCadena($request->get('status'));
            $obj->save();

            $id = $obj->idProveedor;
            return redirect('/proveedores/' . $id . '/edit'); /**/
        } catch (ValidationException $e) {
            //echo $e->validator->errors();
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy($id)
    {
        $item = Proveedor::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Elemento eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'Elemento no encontrado'], 404);
        }
    }
}
