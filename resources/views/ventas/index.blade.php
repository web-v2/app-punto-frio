@extends('adminlte::page')

@section('title', 'Ventas')

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
        <h1>Ventas</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered shadow-lg mt-4 table-responsive-xl" style="width:100%" id="tb">
            <thead class="bg-success text-white">
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Fecha</th>
                    <th scope="col">Nombre Cliente</th>
                    <th scope="col">Valor Factura</th>
                    <th scope="col">Estado</th>
                    <th scope="col">
                        <a href="#newVenta" data-toggle="modal" title="Nueva Venta" class="btn btn-warning">Nuevo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($v as $item)
                <?php $stts = ($item->estado_v == 'ABIERTA') ? 'bg-gradient-success text-white' : 'bg-gradient-danger text-white'; ?>
                <?php $formattedId = str_pad($item->idVenta, 4, '0', STR_PAD_LEFT); ?>
                <tr>
                    <td scope="row">{{$formattedId}}</td>
                    <td scope="row">{{$item->fecha_v}}</td>
                    <td scope="row">{{$item->dni_cl}} - {{$item->nombres_cl}}</td>
                    <td scope="row">${{ number_format($item->total_fact, 0, ',', '.') }}</td>
                    <td scope="row"><span class="btn btn-sm rounded block <?php echo $stts ?>" style="opacity: 0.75; width: 100%;">{{$item->estado_v}}</span></td>
                    <td scope=" row">
                        <a href="#salidas" data-toggle="modal" title="Salidas" class="btn btn-warning" onclick="confirmarSalida(event, '{{$item->idVenta}}')"><i class="fas fa-long-arrow-alt-left"></i></a>
                        <a href="/ventas/{{$item->idVenta}}/invoice" title="Factura" class="btn btn-success" onclick="confirmarIngreso(event, '{{$item->idVenta}}')"><i class="fas fa-file-invoice-dollar"></i>
                            <a href="/productos/{{$item->idVenta}}/edit" title="Editar producto" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                            <a href="#" title="Eliminar producto" class="btn btn-danger" onclick="confirmarEliminacion(event, '{{$item->idVenta}}')"><i class="fas fa-trash-alt"></i></a>
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

<div class="modal fade" tabindex="-1" id="newVenta">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-danger">
                <h4 class="modal-title">Nueva Venta - Vendedor: {{$vendedor}}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <form action="/ventas" method="post" id="myFormVenta">
                                    {{ csrf_field() }}
                                    <div class="row g-3 mb-3 bg-warning rounded">
                                        <div class="col-md-3">
                                            <label for="dni_cl" class="form-label">DNI Cliente</label>
                                            <input type="number" class="form-control" name="dni_cl" id="dni_cl" placeholder="CC" tabindex="1">
                                            <input type="hidden" name="idCl" id="idCl" value="">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="nombre_cl" class="form-label">Nombres del Cliente</label>
                                            <input type="text" class="form-control" name="nombre_cl" id="nombre_cl" readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="tel_cl" class="form-label">Telefono</label>
                                            <input type="number" class="form-control" name="tel_cl" id="tel_cl" readonly>
                                        </div>
                                        <div class="col-md-12">-</div>
                                    </div><!-- fin div row -->
                                    <div class="container">
                                        <div id="productRows" class="row g-3 table-bordered rounded">
                                            <div class="col-md-2">
                                                <label for="cod_pd" class="form-label">Cód. Producto</label>
                                                <input type="number" class="form-control" name="cod_pd[]" id="cod_pd" placeholder="1">
                                            </div>
                                            <div class="col-md-4">
                                                <label for="nombre_pd" class="form-label">Producto</label>
                                                <input type="text" class="form-control" name="nombre_pd[]" id="nombre_pd" readonly>
                                                <input type="hidden" name="stop_pd[]" id="stop_id" value="">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="valor_pd" class="form-label">Valor Producto</label>
                                                <input type="number" class="form-control" name="valor_pd[]" id="valor_pd" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="cant" class="form-label">Cantidad</label>
                                                <input type="number" class="form-control" name="cant[]" id="cant" placeholder="5">
                                            </div>
                                            <div class="col-md-2">
                                                <label for="valor_neto" class="form-label">Valor Neto</label>
                                                <input type="number" class="form-control" name="valor_neto[]" id="valor_neto" readonly>
                                            </div>
                                            <div class="col-md-1">
                                                <label for="btns" class="form-label">Acciones</label>
                                                <button type="button" class="btn btn-sm btn-success add-row"><i class="fas fa-plus"></i></button>
                                                <button type="button" class="btn btn-sm btn-danger remove-row"><i class="fas fa-trash-alt"></i></button>
                                            </div>
                                        </div><!-- fin div row -->
                                    </div>
                        </p>
                        </center>
                    </div><!-- /.fin div card-body -->

                </div><!-- /.fin div card -->
                <div align="right" class="text-danger">
                    <h2><span id="valTotal"></span></h2>
                    <input type="hidden" name="valTotal" id="valTotalFinal" value="0">
                </div>
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

<script>
    function AlertSweet(title, text, icon) {
        Swal.fire({
            title,
            text,
            icon
        });
    }

    function resetform() {
        $("#myFormVenta")[0].reset();
    }

    document.getElementById("dni_cl").addEventListener('blur', function() {
        var id = document.getElementById('dni_cl').value;
        const idCl = document.getElementById('idCl');
        const name = document.getElementById('nombre_cl');
        const cel = document.getElementById('tel_cl');

        if (id) {
            axios.get('{{ route("clientes.getDataCliente") }}', {
                    params: {
                        dni_cl: id
                    }
                })
                .then(function(response) {
                    if (response.status == 200 && response.data.data.length > 0) {
                        data = response.data.data;
                        idCl.value = data[0].idCliente;
                        name.value = data[0].nombres_cl;
                        cel.value = data[0].telefono_cl;
                        $('#btnEnvio').removeClass('disabled');
                    } else {
                        name.value = '';
                        cel.value = '';
                        AlertSweet("Cliente No Existe o Inactivo!", "Favor verificar la información.", "error");
                        $('#btnEnvio').addClass('disabled');
                    }
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    });

    var total = 0;
    document.addEventListener('DOMContentLoaded', (event) => {
        const productRows = document.getElementById('productRows');

        function formatCurrency(value) {
            return new Intl.NumberFormat('es-CO', {
                style: 'currency',
                currency: 'COP',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(value);
        }

        function handleCodPdBlur(event) {
            const row = event.target.closest('.row');
            const cod = row.querySelector('#cod_pd').value;
            const prod = row.querySelector('#nombre_pd');
            const val = row.querySelector('#valor_pd');
            const stop = row.querySelector('#stop_id');

            if (cod) {
                axios.get(`/productos/${cod}`)
                    .then(function(response) {
                        if (response.status == 200) {
                            const data = response.data;
                            prod.value = data[0].descripcion_pd;
                            val.value = data[0].valor_pd;
                            stop.value = data[0].existencia_pd;
                            document.getElementById('btnEnvio').classList.remove('disabled');
                        } else {
                            prod.value = '';
                            val.value = '';
                            stop.value = '';
                            Swal.fire("Producto No Existe o Inactivo!", "Favor verificar la información.", "error");
                            document.getElementById('btnEnvio').classList.add('disabled');
                        }
                    })
                    .catch(function(error) {
                        console.error(error);
                        prod.value = '';
                        val.value = '';
                        Swal.fire("Producto No Existe o Inactivo!", "Favor verificar la información.", "error");
                        document.getElementById('btnEnvio').classList.add('disabled');
                    });
            }
        }

        function handleCantBlur(event) {
            const row = event.target.closest('.row');
            const cant = row.querySelector('#cant').value;
            const val = row.querySelector('#valor_pd').value;
            const stop = row.querySelector('#stop_id').value;
            const neto = row.querySelector('#valor_neto');
            const totalFinal = document.getElementById('valTotalFinal');

            if (cant) {
                const stop_p = parseInt(stop, 10);
                const cant_p = parseInt(cant, 10);
                if (stop_p > cant_p) {
                    const resp = val * cant;
                    neto.value = resp;
                    total += resp;
                    totalFinal.value = total;
                    document.getElementById('valTotal').textContent = formatCurrency(total);
                } else {
                    Swal.fire("Stop Insuficiente", "Favor verificar la cantidad de existencia del producto ya que es menor a la cantidad solicitada para la operación.", "error");
                    neto.value = 0;
                }
            }
        }

        function addRow() {
            const newRow = productRows.cloneNode(true);
            newRow.querySelectorAll('input').forEach(input => input.value = '');
            newRow.querySelector('.add-row').addEventListener('click', addRow);
            newRow.querySelector('.remove-row').addEventListener('click', removeRow);
            newRow.querySelector('#cod_pd').addEventListener('blur', handleCodPdBlur);
            newRow.querySelector('#cant').addEventListener('blur', handleCantBlur);
            productRows.parentNode.insertBefore(newRow, productRows.nextSibling);
        }

        function removeRow(event) {
            if (document.querySelectorAll('.row.table-bordered').length > 1) {
                event.target.closest('.row.table-bordered').remove();
            } else {
                alert("Debe haber al menos una fila.");
            }
        }

        // Añadir eventos a los botones de la fila inicial
        document.querySelector('.add-row').addEventListener('click', addRow);
        document.querySelector('.remove-row').addEventListener('click', removeRow);

        // Añadir manejadores de eventos a los inputs de la fila inicial
        document.getElementById('cod_pd').addEventListener('blur', handleCodPdBlur);
        document.getElementById('cant').addEventListener('blur', handleCantBlur);
    });

    /**/
    document.getElementById('btnEnvio').addEventListener('click', function() {
        var idCliente = document.getElementById('dni_cl').value;
        const codProd = document.getElementById('cod_pd').value;
        const cant = document.getElementById('cant').value;
        const neto = document.getElementById('valor_neto').value;

        if (idCliente === '' || idCliente.length === 0) {
            document.getElementById('dni_cl').classList.add('bg-warning');
        } else {
            document.getElementById('dni_cl').classList.remove('bg-warning');
            if (codProd === '' || codProd.length === 0) {
                document.getElementById('cod_pd').classList.add('bg-warning');
            } else {
                document.getElementById('cod_pd').classList.remove('bg-warning');
                if (cant === '' || cant.length === 0) {
                    document.getElementById('cant').classList.add('bg-warning');
                } else {
                    document.getElementById('cant').classList.remove('bg-warning');
                    if (neto === '' || neto.length === 0) {
                        document.getElementById('valor_neto').classList.add('bg-warning');
                    } else {
                        document.getElementById('valor_neto').classList.remove('bg-warning');
                        Swal.fire({
                            position: "top-end",
                            icon: "success",
                            title: "Información Enviada Correctamente!",
                            showConfirmButton: false,
                            timer: 1500
                        });
                        document.getElementById('myFormVenta').submit();
                    }
                }
            }
        }
    });
</script>