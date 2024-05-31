<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detalleventa extends Model
{
    protected $primaryKey = 'idDetalleVenta';
    use HasFactory;
    protected $fillable = [
        'venta_id',
        'producto_id',
        'valor_v',
        'cantidad_v',
        'neto_v',
        'user_id'
    ];
}
