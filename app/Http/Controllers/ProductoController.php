<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Proveedor;
use App\Models\Producto;

use function PHPUnit\Framework\isEmpty;

class ProductoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pv = Proveedor::where('estado_pv', 'ACTIVO')->get();
        $pd = Producto::join('Proveedors', 'proveedor_id', '=', 'Proveedors.idProveedor')->get();
        return view('Productos.index')->with('pd', $pd)->with('pv', $pv);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'nombre_pd' => ['required', 'string'],
                'proveedor' => ['required', 'int'],
                'val' => ['required', 'int'],
                'stop' => ['required', 'int']
            ]);
            $user_idDB = Auth::id();
            $obj = new Producto();
            $obj->descripcion_pd = Controller::limpiarCadena(strtoupper($request->get('nombre_pd')));
            $obj->proveedor_id = Controller::limpiarCadena($request->get('proveedor'));
            $obj->valor_pd = Controller::limpiarCadena($request->get('val'));
            $obj->existencia_pd = Controller::limpiarCadena($request->get('stop'));
            $obj->user_id = $user_idDB;
            $obj->estado_pd = 'ACTIVO';
            $obj->save();

            return redirect('/productos/');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function show($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $pd = Producto::join('proveedors', 'idProveedor', '=', 'Productos.proveedor_id')
            ->where('idProducto', $idLimp)
            ->get();

        if (!$pd || $pd->isEmpty()) {
            return response()->json(['error' => 'Producto no encontrado'], 404);
        }
        return response()->json($pd);
    }

    public function edit($id)
    {
        $idLimp = Controller::limpiarCadena($id);
        $pv = Proveedor::where('estado_pv', 'ACTIVO')->get();
        $pd = Producto::join('Proveedors', 'proveedor_id', '=', 'Proveedors.idProveedor')
            ->where('idProducto', $idLimp)->get();
        return view('Productos.edit')->with('productos', $pd)->with('proveedores', $pv);
    }

    public function update(Request $request, $id)
    {
        //print_r($request);
        try {
            $request->validate([
                'descripcion_pd' => ['required', 'string'],
                'val' => ['required', 'numeric']
            ]);
            $idLimp = Controller::limpiarCadena($id);
            $obj = Producto::find($idLimp);
            $obj->descripcion_pd = Controller::limpiarCadena(strtoupper($request->get('descripcion_pd')));
            $obj->proveedor_id = Controller::limpiarCadena($request->get('proveedor'));
            $obj->valor_pd = Controller::limpiarCadena($request->get('val'));
            $obj->estado_pd = Controller::limpiarCadena($request->get('status'));
            $obj->save();

            $id = $obj->idProducto;
            return redirect('/productos/' . $id . '/edit');
        } catch (ValidationException $e) {
            //echo $e->validator->errors();
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }

    public function destroy($id)
    {
        $item = Producto::find($id);
        if ($item) {
            $item->delete();
            return response()->json(['message' => 'Elemento eliminado correctamente'], 200);
        } else {
            return response()->json(['error' => 'Elemento no encontrado'], 404);
        }
    }


    public function entrada(Request $request, $id)
    {
        echo "Hay metodo";
        try {
            $request->validate([
                'cant' => ['required', 'numeric']
            ]);
            $idLimp = Controller::limpiarCadena($id);
            $obj = Producto::find($idLimp);
            $obj->existencia_pd += Controller::limpiarCadena($request->get('cant'));
            $obj->save();

            $id = $obj->idProducto;
            return redirect('/productos/' . $id . '/edit');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->errors())->withInput();
        }
    }
}
