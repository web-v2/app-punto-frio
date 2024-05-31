<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Evento;
use App\Models\Tipo;

class EventoController extends Controller
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
        $tipos = Tipo::all();

        $ev = Evento::all();
        return view('Eventos.index')->with('tipos', $tipos)->with('ev', $ev);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //print_r($_POST);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $obj = new Evento();
        $obj->tipo_ev_id = Controller::limpiarCadena($request->get('tipo_ev'));
        $obj->nombre_ev = Controller::limpiarCadena(strtoupper($request->get('name_ev')));
        $obj->fechaInicio = $request->get('fecha_ini');
        $obj->horaInicio = $request->get('hora_ini');
        $obj->fechaHoraInicio = $obj->fechaInicio . " " . $obj->horaInicio;
        $obj->fechaFinal = $request->get('fecha_fin');
        $obj->horaFinal = $request->get('hora_fin');
        $obj->fechaHoraFinal = $obj->fechaFinal . " " . $obj->horaFinal;
        $all = (Controller::limpiarCadena($request->get('todoDia')) == 'on') ? true : false;
        $obj->todoDia = $all;
        $obj->descripcion_ev = Controller::limpiarCadena($request->get('descripcion'));
        $obj->save();

        return redirect('/eventos/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $tipos = Tipo::all();
        $ag = Evento::join('tipos', 'Eventos.tipo_ev_id', '=', 'tipos.id')
            ->where('Eventos.idEvento', $idLimp)
            ->get();
        return view('Eventos.show')->with('tipos', $tipos)->with('eventos', $ag);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $tipos = Tipo::all();
        $ag = Evento::join('tipos', 'Eventos.tipo_ev_id', '=', 'tipos.id')
            ->where('Eventos.idEvento', $idLimp)
            ->get();
        return view('Eventos.edit')->with('tipos', $tipos)->with('eventos', $ag);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $obj = Evento::find($idLimp);
        $obj->tipo_ev_id = Controller::limpiarCadena($request->get('tipo_ev'));
        $obj->nombre_ev = Controller::limpiarCadena(strtoupper($request->get('name_ev')));
        $obj->fechaInicio = $request->get('fecha_ini');
        $obj->horaInicio = $request->get('hora_ini');
        $obj->fechaHoraInicio = $obj->fechaInicio . " " . $obj->horaInicio;
        $obj->fechaFinal = $request->get('fecha_fin');
        $obj->horaFinal = $request->get('hora_fin');
        $obj->fechaHoraFinal = $obj->fechaFinal . " " . $obj->horaFinal;
        $all = (Controller::limpiarCadena($request->get('todoDia')) == 'on') ? true : false;
        $obj->todoDia = $all;
        $obj->descripcion_ev = Controller::limpiarCadena($request->get('descripcion'));
        $obj->save();

        $id = $obj->idEvento;
        return redirect('/eventos/' . $id . '/edit');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Evento::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Elemento eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'Elemento no encontrado'], 404);
        }
    }
}
