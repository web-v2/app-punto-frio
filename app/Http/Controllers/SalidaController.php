<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Salida;

class SalidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'producto_id_sal' => ['required', 'int'],
                'motivo_sal' => ['required', 'string'],
                'cantidad_sal' => ['required', 'int']
            ]);
            $user_idDB = Auth::id();
            $obj = new Salida();
            $obj->producto_id = Controller::limpiarCadena($request->get('producto_id_sal'));
            $obj->motivo_sal = Controller::limpiarCadena(strtoupper($request->get('motivo_sal')));
            $obj->fecha_sal = Date('Y-m-d');
            $obj->cantidad_sal = Controller::limpiarCadena($request->get('cantidad_sal'));
            $obj->user_id = $user_idDB;
            $obj->save();

            try {
                $idLimp = Controller::limpiarCadena($request->get('producto_id_sal'));
                $obj = Producto::find($idLimp);
                $obj->existencia_pd -= Controller::limpiarCadena($request->get('cantidad_sal'));
                $obj->save();
            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->validator->errors())->withInput();
            }

            return redirect('/productos/');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Salida $salida)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Salida  $salida
     * @return \Illuminate\Http\Response
     */
    public function destroy(Salida $salida)
    {
        //
    }
}
