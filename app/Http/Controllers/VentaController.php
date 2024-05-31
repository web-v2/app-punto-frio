<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Proveedor;
use App\Models\detalleVenta;

class VentaController extends Controller
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
        $pv = Proveedor::where('estado_pv', 'ACTIVO')->get();
        $v = Venta::join('Clientes', 'cliente_id', '=', 'Clientes.idCliente')->get();
        $user_data_DB = Auth::user();
        $user_DB = $user_data_DB->name;
        return view('Ventas.index')->with('v', $v)->with('pv', $pv)->with('vendedor', $user_DB);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
                'idCl' => ['required', 'int'],
                'valTotal' => ['required', 'numeric']
            ]);
            $user_idDB = Auth::id();
            $obj = new Venta();
            $obj->cliente_id = Controller::limpiarCadena($request->get('idCl'));
            $obj->total_fact = Controller::limpiarCadena($request->get('valTotal'));
            $obj->user_id = $user_idDB;
            $obj->save();

            $idVenta = $obj->idVenta;
            try {
                // Obtener los datos del formulario
                $cod_pd = $request->input('cod_pd');
                $valor_pd = $request->input('valor_pd');
                $cant = $request->input('cant');
                $valor_neto = $request->input('valor_neto');

                // Iterar sobre los arrays e insertar los datos en la base de datos
                for ($i = 0; $i < count($cod_pd); $i++) {
                    detalleVenta::create([
                        'venta_id' => $idVenta,
                        'producto_id' => $cod_pd[$i],
                        'valor_v' => $valor_pd[$i],
                        'cantidad_v' => $cant[$i],
                        'neto_v' => $valor_neto[$i],
                        'user_id' => $user_idDB
                    ]);
                }
            } catch (ValidationException $e) {
                return redirect()->back()->withErrors($e->validator->errors())->withInput();
            }

            return redirect('/ventas/');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function invoice($id)
    {
        $v = Venta::join('Clientes', 'cliente_id', '=', 'Clientes.idCliente')
            ->where('idVenta', $id)
            ->get();
        $d = detalleVenta::join('Productos', 'producto_id', '=', 'Productos.idProducto')
            ->where('venta_id', $id)
            ->get();
        //echo $v;
        return view('Ventas.invoice')->with('v', $v)->with('d', $d);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function show(venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function edit(venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, venta $venta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\venta  $venta
     * @return \Illuminate\Http\Response
     */
    public function destroy(venta $venta)
    {
        //
    }
}
