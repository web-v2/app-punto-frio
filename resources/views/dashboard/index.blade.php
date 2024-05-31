@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')

@stop

@section('content')
<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-gradient-yellow">
            <div class="inner">
                <h3><?php echo $proveedores; ?></h3>
                <p>Proveedores</p>
            </div>
            <div class="icon">
                <i class="far fa-building"></i>
            </div>
            <a href="/proveedores" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-gradient-green">
            <div class="inner">
                <h3><?php echo $productos; ?></h3>
                <p>Productos</p>
            </div>
            <div class="icon">
                <i class="fas fa-boxes"></i>
            </div>
            <a href="/productos" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-gradient-blue">
            <div class="inner">
                <h3><?php echo $clientes; ?></h3>
                <p>Clientes</p>
            </div>
            <div class="icon">
                <i class="fas fa-users"></i>
            </div>
            <a href="/clientes" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="small-box bg-gradient-red">
            <div class="inner">
                <h3><?php echo $ventas; ?></h3>
                <p>Ventas</p>
            </div>
            <div class="icon">
                <i class="fas fa-file-invoice-dollar"></i>
            </div>
            <a href="/ventas" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
            </a>
        </div>
    </div>


</div>
<center>
    <x-jet-authentication-card-logo />
</center>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script>
    console.log('Hi AdminLLTE!');
</script>
@stop