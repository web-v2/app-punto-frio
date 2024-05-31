<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;
use App\Models\Cliente;
use App\Models\Venta;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $proveedores = Proveedor::count();
        $productos = Producto::count();
        $clientes = Cliente::count();
        $ventas = Venta::count();
        $eve = 0;
        return view('dashboard.index')
            ->with('eventos', $eve)
            ->with('proveedores', $proveedores)
            ->with('productos', $productos)
            ->with('clientes', $clientes)
            ->with('ventas', $ventas);
    }
}
