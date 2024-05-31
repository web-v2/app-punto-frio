<?php


namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Entrada;

class EntradaController extends Controller
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
                'producto_id' => ['required', 'int'],
                'nfactura' => ['required', 'string'],
                'cantidad_ent' => ['required', 'int'],
                'vcompra' => ['required', 'numeric']
            ]);
            $user_idDB = Auth::id();
            $obj = new Entrada();
            $obj->producto_id = Controller::limpiarCadena($request->get('producto_id'));
            $obj->num_factura = Controller::limpiarCadena(strtoupper($request->get('nfactura')));
            $obj->fecha_ent = Date('Y-m-d');
            $obj->cantidad_ent = Controller::limpiarCadena($request->get('cantidad_ent'));
            $obj->valor_pd = Controller::limpiarCadena($request->get('vcompra'));
            $obj->user_id = $user_idDB;
            $obj->save();

            try {
                $idLimp = Controller::limpiarCadena($request->get('producto_id'));
                $obj = Producto::find($idLimp);
                $obj->valor_pd = Controller::limpiarCadena($request->get('vcompra'));
                $obj->existencia_pd += Controller::limpiarCadena($request->get('cantidad_ent'));
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
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function edit(Entrada $entrada)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Entrada $entrada)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entrada  $entrada
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entrada $entrada)
    {
        //
    }
}
