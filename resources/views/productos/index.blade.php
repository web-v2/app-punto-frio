@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
<style>
    #flexSwitchCheckDefault {
        width: 40px;
        height: 20px;
    }
</style>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h1>Productos</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered shadow-lg mt-4 table-responsive-xl" style="width:100%" id="tb">
            <thead class="bg-success text-white">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre Producto</th>
                    <th scope="col">Razon Social Proveedor</th>
                    <th scope="col">Valor Venta</th>
                    <th scope="col">Stop</th>
                    <th scope="col">Estado</th>
                    <th scope="col">
                        <a href="#newProducto" data-toggle="modal" title="Crear Proveedor" class="btn btn-warning">Nuevo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pd as $item)
                <?php $stts = ($item->estado_pd == 'ACTIVO') ? 'bg-gradient-success text-white' : 'bg-gradient-danger text-white'; ?>
                <tr>
                    <td scope="row">{{$item->idProducto}}</td>
                    <td scope="row">{{$item->descripcion_pd}}</td>
                    <td scope="row">{{$item->nombre_pv}}</td>
                    <td scope="row">${{ number_format($item->valor_pd, 0, ',', '.') }}</td>
                    <td scope="row">{{$item->existencia_pd}}</td>
                    <td scope="row"><span class="btn btn-sm rounded block <?php echo $stts ?>" style="opacity: 0.75; width: 100%;">{{$item->estado_pd}}</span></td>
                    <td scope=" row">
                        <a href="#salidas" data-toggle="modal" title="Salidas" class="btn btn-warning" onclick="confirmarSalida(event, '{{$item->idProducto}}')"><i class="fas fa-long-arrow-alt-left"></i></a>
                        <a href="#entradas" data-toggle="modal" title="Ingresos" class="btn btn-success" onclick="confirmarIngreso(event, '{{$item->idProducto}}')"><i class="fas fa-plus"></i></a>
                        <a href="/productos/{{$item->idProducto}}/edit" title="Editar producto" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <a href="#" title="Eliminar producto" class="btn btn-danger" onclick="confirmarEliminacion(event, '{{$item->idProducto}}')"><i class="fas fa-trash-alt"></i></a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css" rel="stylesheet">
@stop

@section('js')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        $('#tb').DataTable({
            "lengthMenu": [
                [5, 10, 20, 50, -1],
                [5, 10, 20, 50, "All"]
            ]
        });
    });

    function confirmarIngreso(event, id) {
        var idProd = document.getElementById('producto_id');
        var nameProd = document.getElementById('nombre_pd');
        var valorProd = document.getElementById('valor_pd');
        var stopProd = document.getElementById('stop_pd');
        if (id) {
            const resp = axios.get(`/productos/${id}`)
                .then(function(response) {
                    if (response.status == 200) {
                        dataProd = response.data;
                        idProd.value = dataProd[0].idProducto;
                        nameProd.value = dataProd[0].descripcion_pd;
                        valorProd.value = dataProd[0].valor_pd;
                        stopProd.value = dataProd[0].existencia_pd;
                    }
                });
        }
    }

    function confirmarSalida(event, id) {
        var idProdSalidas = document.getElementById('producto_id_sal');
        var nameProdSalidas = document.getElementById('nombre_pd_sal');
        var valorProdSalidas = document.getElementById('valor_pd_sal');
        var stopProdSalidas = document.getElementById('stop_pd_sal');

        const stop = document.getElementById('stopActual');

        if (id) {
            const resp = axios.get(`/productos/${id}`)
                .then(function(response) {
                    if (response.status == 200) {
                        dataProd = response.data;
                        idProdSalidas.value = dataProd[0].idProducto;
                        nameProdSalidas.value = dataProd[0].descripcion_pd;
                        valorProdSalidas.value = dataProd[0].valor_pd;
                        stopProdSalidas.value = dataProd[0].existencia_pd;
                        stop.value = dataProd[0].existencia_pd;
                    }
                });
        }
    }

    function confirmarEliminacion(event, id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro de que deseas eliminar este Producto?",
            text: "Esta acción no se podra revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (id) {
                    axios.delete(`/productos/${id}`)
                        .then(function(response) {
                            if (response.status == 200) {
                                swalWithBootstrapButtons.fire({
                                    title: "Eliminado!",
                                    text: "Los registros fueron eliminados!",
                                    icon: "success"
                                }).then((result) => {
                                    window.location.href = '/productos/';
                                });
                            } else {
                                AlertSweet("Error!", "Se produjo un error durante el proceso de eliminación, notificar al administrador del sistema", "error");
                            }
                        })
                        .catch(function(error) {
                            AlertSweet("Producto no encontrado!", "Favor verificar la información.", "error");
                            console.error(error);
                        });
                }
            } else if (
                result.dismiss === Swal.DismissReason.cancel
            ) {
                swalWithBootstrapButtons.fire({
                    title: "Proceso cancelado",
                    text: "Your imaginary file is safe :)",
                    icon: "error"
                });
            }
        });
    }
</script>
@stop

<div class="modal fade" tabindex="-1" id="newProducto">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Crear Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <form action="/productos" method="post" id="myForm">
                                    {{ csrf_field() }}
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nombre del producto</label>
                                            <input type="text" class="form-control" name="nombre_pd" id="name" required placeholder="Producto">
                                            <span id="name-error" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="proveedor" class="form-label">Nombre del proveedor</label>
                                            <select name="proveedor" id="proveedor" class="form-control" required>
                                                <option value="">Seleccione...</option>
                                                @foreach ($pv as $tipo)
                                                <option value="{{ $tipo->idProveedor }}">{{ $tipo->dni_pv }}-{{ $tipo->nombre_pv }}</option>
                                                @endforeach
                                            </select>
                                            <span id="proveedor-error" class="text-danger"></span>

                                        </div>
                                        <div class="col-md-6">
                                            <label for="val" class="form-label">Valor</label>
                                            <input type="number" class="form-control" name="val" id="val" placeholder="$">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="stop" class="form-label">Inventario Inicial</label>
                                            <input type="number" class="form-control" name="stop" id="stop" placeholder="Cantidad">
                                        </div>
                                    </div><!-- fin div row -->
                        </p>
                        </center>
                    </div><!-- /.fin div card-body -->

                </div><!-- /.fin div card -->
            </div><!-- /.fin div modal-body -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="far fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="resetform()">Limpiar</button>
                <a href="#" id="btnEnvio" class="btn btn-success"><i class="far fa-save"></i> Guardar Cambios</a>
                </form>
                <br>
                <div class="justify-content-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->


<div class="modal fade" tabindex="-1" id="entradas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">Entradas de Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <div class="card-body bg-warning rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nombre del producto</label>
                                            <input type="text" class="form-control" name="nombre_pd" id="nombre_pd" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="val" class="form-label">Valor Anterior</label>
                                            <input type="number" class="form-control" name="val" id="valor_pd" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="stop" class="form-label">Stop Actual</label>
                                            <input type="number" class="form-control" name="stop" id="stop_pd" readonly>
                                        </div>
                                    </div>
                                </div>
                                <form action="/entradas" method="post" id="myFormEntradas">
                                    {{ csrf_field() }}
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <input type="hidden" name="producto_id" id="producto_id" value="">
                                            <label for="nfactura" class="form-label">Número Factura Compra</label>
                                            <input type="text" class="form-control" name="nfactura" id="nfactura" required placeholder="Número Factura">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="vcompra" class="form-label">Valor Compra ind.</label>
                                            <input type="number" class="form-control" name="vcompra" id="vcompra" required placeholder="$ 0">
                                        </div>
                                        <div class="col-md-3">
                                            <label for="cant" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" name="cantidad_ent" id="cantidad_ent" required placeholder="10">
                                        </div>
                                    </div><!-- fin div row -->
                        </p>
                        </center>
                    </div><!-- /.fin div card-body -->

                </div><!-- /.fin div card -->
            </div><!-- /.fin div modal-body -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="far fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="resetform()">Limpiar</button>
                <a href="#" id="btnEnvioEntradas" class="btn btn-success"><i class="far fa-save"></i> Guardar Cambios</a>
                </form>
                <br>
                <div class="justify-content-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<div class="modal fade" tabindex="-1" id="salidas">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <h4 class="modal-title">Salidas de Producto</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <div class="card-body bg-info rounded">
                                    <div class="row g-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">Nombre del producto</label>
                                            <input type="text" class="form-control" name="nombre_pd" id="nombre_pd_sal" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="val" class="form-label">Valor Anterior</label>
                                            <input type="number" class="form-control" name="val" id="valor_pd_sal" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="stop" class="form-label">Stop Actual</label>
                                            <input type="number" class="form-control" name="stop" id="stop_pd_sal" readonly>
                                        </div>
                                    </div>
                                </div>
                                <form action="/salidas" method="post" id="myFormSalidas">
                                    {{ csrf_field() }}
                                    <div class="row g-3">
                                        <div class="col-md-8">
                                            <label for="motivo_sal" class="form-label">Motivo</label>
                                            <input type="text" class="form-control" name="motivo_sal" id="motivo_sal" required placeholder="Venta">
                                        </div>
                                        <div class="col-md-4">
                                            <input type="hidden" name="producto_id_sal" id="producto_id_sal" value="">
                                            <input type="hidden" name="stop" id="stopActual" value="">
                                            <label for="cant" class="form-label">Cantidad</label>
                                            <input type="number" class="form-control" name="cantidad_sal" id="cantidad_sal" required placeholder="10">
                                        </div>
                                    </div><!-- fin div row -->
                        </p>
                        </center>
                    </div><!-- /.fin div card-body -->

                </div><!-- /.fin div card -->
            </div><!-- /.fin div modal-body -->
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-warning" data-dismiss="modal"><i class="far fa-window-close"></i> Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="resetform()">Limpiar</button>
                <a href="#" id="btnEnvioSalidas" class="btn btn-success"><i class="far fa-save"></i> Guardar Cambios</a>
                </form>
                <br>
                <div class="justify-content-center">
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
<script>
    function AlertSweet(title, text, icon) {
        Swal.fire({
            title,
            text,
            icon
        });
    }

    function resetform() {
        $("#myForm")[0].reset();
        $("#myFormEntradas")[0].reset();
        $("#myFormSalidas")[0].reset();
    }

    document.getElementById("cantidad_sal").addEventListener('change', function() {
        var id = document.getElementById('producto_id_sal').value;
        const stop = document.getElementById('stopActual');

        if (id) {
            const resp = axios.get(`/productos/${id}`)
                .then(function(response) {
                    if (response.status == 200) {
                        dataProd = response.data;
                        stop.value = dataProd[0].existencia_pd;
                    }
                });
        }
    });

    document.getElementById("btnEnvioSalidas").addEventListener('click', function() {
        const idProd = document.getElementById('producto_id_sal').value;
        const stop = document.getElementById('stopActual').value;
        const motivo = document.getElementById('motivo_sal').value;
        const cant = document.getElementById('cantidad_sal').value;

        console.log('stop: ' + stop + ' salida: ' + cant);

        if (stop < cant) {
            Swal.fire({
                icon: "error",
                title: "Oops... Stop insuficiente!",
                text: "La cantidad de salida no puede ser mayor al STOP actual."
            });
        } else {

            if (idProd === '' || idProd.length === 0) {
                document.getElementById('producto_id_sal').classList.add('bg-warning');
            } else {
                document.getElementById('producto_id_sal').classList.remove('bg-warning');
                if (motivo === '' || motivo.length === 0) {
                    document.getElementById('motivo_sal').classList.add('bg-warning');
                } else {
                    document.getElementById('motivo_sal').classList.remove('bg-warning');
                    if (cant === '' || cant.length === 0) {
                        document.getElementById('cantidad_sal').classList.add('bg-warning');
                    } else {
                        document.getElementById('cantidad_sal').classList.remove('bg-warning');
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Información Enviada Correctamente!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        document.getElementById('myFormSalidas').submit();
                    }
                }
            }
        }
    });

    document.getElementById("btnEnvioEntradas").addEventListener('click', function() {
        const idProd = document.getElementById('producto_id').value;
        const fact = document.getElementById('nfactura').value;
        const valcomp = document.getElementById('vcompra').value;
        const cant = document.getElementById('cantidad_ent').value;

        if (idProd === '' || idProd.length === 0) {
            document.getElementById('producto_id').classList.add('bg-warning');
        } else {
            document.getElementById('producto_id').classList.remove('bg-warning');
            if (fact === '' || fact.length === 0) {
                document.getElementById('nfactura').classList.add('bg-warning');
            } else {
                document.getElementById('nfactura').classList.remove('bg-warning');
                if (valcomp === '' || valcomp.length === 0) {
                    document.getElementById('vcompra').classList.add('bg-warning');
                } else {
                    document.getElementById('vcompra').classList.remove('bg-warning');
                    if (cant === '' || cant.length === 0) {
                        document.getElementById('cantidad_ent').classList.add('bg-warning');
                    } else {
                        document.getElementById('cantidad_ent').classList.remove('bg-warning');
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Información Enviada Correctamente!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        document.getElementById('myFormEntradas').submit();
                    }
                }
            }
        }
    });

    document.getElementById('btnEnvio').addEventListener('click', function() {
        const nom = document.getElementById('name').value;
        var selectElement = document.querySelector('select[name="proveedor"]');
        var pro = selectElement.value;
        const val = document.getElementById('val').value;
        const cant = document.getElementById('stop').value;

        if (nom === '' || nom.length === 0) {
            document.getElementById('name').classList.add('bg-warning');
        } else {
            document.getElementById('name').classList.remove('bg-warning');
            if (pro === '' || pro.length === 0) {
                document.getElementById('proveedor').classList.add('bg-warning');
            } else {
                document.getElementById('proveedor').classList.remove('bg-warning');
                if (val === '' || val.length === 0) {
                    document.getElementById('val').classList.add('bg-warning');
                } else {
                    document.getElementById('val').classList.remove('bg-warning');
                    if (cant === '' || cant.length === 0) {
                        document.getElementById('stop').classList.add('bg-warning');
                    } else {
                        document.getElementById('stop').classList.remove('bg-warning');
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Información Enviada Correctamente!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        document.getElementById('myForm').submit();
                    }
                }
            }
        }
    });
</script>