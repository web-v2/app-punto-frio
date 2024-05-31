<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\tipo;

class TipoController extends Controller
{
    public function index()
    {
        $tipos = Tipo::all();
        return $tipos;
    }
}
