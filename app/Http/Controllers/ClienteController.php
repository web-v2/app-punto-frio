<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Cliente;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $cl = Cliente::all();
        return view('Clientes.index')->with('cl', $cl);
    }

    public function validarDni(Request $request)
    {
        $dni = Controller::limpiarCadena($request->input('dni'));
        $exists = Cliente::where('dni_cl', $dni)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function getDataCliente(Request $request)
    {
        $dni = Controller::limpiarCadena($request->input('dni_cl'));
        $cl = Cliente::where('dni_cl', $dni)
            ->where('estado_cl', 'ACTIVO')
            ->get();
        return response()->json(['data' => $cl]);
    }

    public function store(Request $request)
    {
        //print_r($_POST);
        try {
            $request->validate([
                'dni_cl' => ['required', 'unique:Clientes'],
                'nombre_cl' => ['required', 'string']
            ]);
            $user_idDB = Auth::id();
            $obj = new Cliente();
            $obj->dni_cl = Controller::limpiarCadena($request->get('dni_cl'));
            $obj->nombres_cl = Controller::limpiarCadena(strtoupper($request->get('nombre_cl')));
            $obj->telefono_cl = Controller::limpiarCadena($request->get('tel'));
            $obj->direccion_cl = Controller::limpiarCadena(strtoupper($request->get('direccion')));
            $obj->user_id = $user_idDB;
            $obj->estado_cl = 'ACTIVO';
            $obj->save();

            return redirect('/clientes/');
        } catch (ValidationException $e) {
            //echo $e->getMessage();
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function edit($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $cl = Cliente::where('idCliente', $idLimp)->get();
        return view('Clientes.edit')->with('clientes', $cl);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'dni_cl' => ['required', 'int'],
                'nombre_cl' => ['required', 'string']
            ]);
            $idLimp = Controller::limpiarCadena($id);
            $obj = Cliente::find($idLimp);
            $obj->dni_cl = Controller::limpiarCadena($request->get('dni_cl'));
            $obj->nombres_cl = Controller::limpiarCadena(strtoupper($request->get('nombre_cl')));
            $obj->telefono_cl = Controller::limpiarCadena($request->get('tel_cl'));
            $obj->direccion_cl = Controller::limpiarCadena(strtoupper($request->get('direccion_cl')));
            $obj->estado_cl = Controller::limpiarCadena($request->get('status'));
            $obj->save();

            $id = $obj->idCliente;
            return redirect('/clientes/' . $id . '/edit'); /**/
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy($id)
    {
        $item = Cliente::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Elemento eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'Elemento no encontrado'], 404);
        }
    }
}
