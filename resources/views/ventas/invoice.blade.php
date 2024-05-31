@extends('adminlte::page')

@section('title', 'Ventas')

@section('content_header')
<h1>Datos de la Factura</h1>
@stop

@section('content')
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fas fa-globe"></i> {{$v[0]->nombres_cl}} - {{$v[0]->dni_cl}}.
                                    <small class="float-right">Fecha Emision: {{$v[0]->fecha_v}}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>Admin, Inc.</strong><br>
                                    795 Folsom Ave, Suite 600<br>
                                    San Francisco, CA 94107<br>
                                    Phone: (804) 123-5432<br>
                                    Email: info@almasaeedstudio.com
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{$v[0]->nombres_cl}}</strong><br>
                                    Número Doc. {{$v[0]->dni_cl}}<br>
                                    Telefono {{$v[0]->telefono_cl}}<br>
                                    Dirección {{$v[0]->direccion_cl}}<br>
                                </address>
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Invoice #<?php echo str_pad($v[0]->idVenta, 4, '0', STR_PAD_LEFT); ?></b><br>
                                <br>
                                <b>Vendedor:</b> 4F3S8J<br>
                                <b>Estado:</b> {{$v[0]->estado_v}}<br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Cód. Producto</th>
                                            <th>Detalles Producto</th>
                                            <th>Valor</th>
                                            <th>Cantidad</th>
                                            <th>Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($d as $det)
                                        <tr>
                                            <td>{{ $det->producto_id }}</td>
                                            <td>{{ $det->descripcion_pd }}</td>
                                            <td>${{ number_format($det->valor_v, 0, ',', '.') }}</td>
                                            <td>{{ $det->cantidad_v }}</td>
                                            <td>${{ number_format($det->neto_v, 0, ',', '.') }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <div class="col-6">-</div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Subtotal:</th>
                                            <td>${{ number_format($v[0]->total_fact, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Comisión (9.3%)</th>
                                            <td>$0</td>
                                        </tr>
                                        <tr>
                                            <th>Descuento</th>
                                            <td>$0</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td class="text-danger">${{ number_format($v[0]->total_fact, 0, ',', '.') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                <a href="#" rel="noopener" target="" class="btn btn-default" id="btnPrint"><i class="fas fa-print"></i> Print</a>
                                <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                                    Payment
                                </button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Generate PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../../plugins/fontawesome-free/css/all.min.css">
<!-- Theme style -->
<link rel="stylesheet" href="../../dist/css/adminlte.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById("btnPrint").addEventListener('click', function() {
        window.print();
    });
</script>
@stop