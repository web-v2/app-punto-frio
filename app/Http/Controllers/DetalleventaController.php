<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\detalleVenta;
use App\Models\Venta;
use App\Models\Producto;
use App\Models\Proveedor;

class DetalleventaController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\detalleventa  $detalleventa
     * @return \Illuminate\Http\Response
     */
    public function show(detalleventa $detalleventa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\detalleventa  $detalleventa
     * @return \Illuminate\Http\Response
     */
    public function edit(detalleventa $detalleventa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\detalleventa  $detalleventa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, detalleventa $detalleventa)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\detalleventa  $detalleventa
     * @return \Illuminate\Http\Response
     */
    public function destroy(detalleventa $detalleventa)
    {
        //
    }
}
