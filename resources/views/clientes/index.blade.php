@extends('adminlte::page')

@section('title', 'Clientes')

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
        <h1>Clientes</h1>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <table class="table table-striped table-bordered shadow-lg mt-4 table-responsive-xl" style="width:100%" id="tb">
            <thead class="bg-success text-white">
                <tr>
                    <th scope="col">DNI Cliente</th>
                    <th scope="col">Nombre del Cliente</th>
                    <th scope="col">Telefono</th>
                    <th scope="col">Dirección</th>
                    <th scope="col">Estado</th>
                    <th scope="col">
                        <a href="#cliente" data-toggle="modal" title="Crear Cliente" class="btn btn-warning">Nuevo</a>
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cl as $item)
                <?php $stts = ($item->estado_cl == 'ACTIVO') ? 'bg-gradient-success text-white' : 'bg-gradient-danger text-white'; ?>
                <tr>
                    <td scope="row">{{$item->dni_cl}}</td>
                    <td scope="row">{{$item->nombres_cl}}</td>
                    <td scope="row">{{$item->telefono_cl}}</td>
                    <td scope="row">{{$item->direccion_cl}}</td>
                    <td scope="row"><span class="btn btn-sm rounded block <?php echo $stts ?>" style="opacity: 0.75; width: 100%;">{{$item->estado_cl}}</span></td>
                    <td scope=" row">
                        <a href="/clientes/{{$item->idCliente}}/edit" title="Editar cliente" class="btn btn-primary"><i class="fas fa-edit"></i></a>
                        <a href="#" title="Eliminar cliente" class="btn btn-danger" onclick="confirmarEliminacion(event, '{{$item->idCliente}}')"><i class="fas fa-trash-alt"></i></a>
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

    function confirmarEliminacion(event, id) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: "btn btn-success",
                cancelButton: "btn btn-danger"
            },
            buttonsStyling: false
        });
        swalWithBootstrapButtons.fire({
            title: "¿Estás seguro de que deseas eliminar este Cliente?",
            text: "Esta acción no se podra revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Si, eliminar!",
            cancelButtonText: "No, cancelar!",
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                if (id) {
                    axios.delete(`/clientes/${id}`)
                        .then(function(response) {
                            if (response.status == 200) {
                                swalWithBootstrapButtons.fire({
                                    title: "Eliminado!",
                                    text: "Los registros fueron eliminados!",
                                    icon: "success"
                                }).then((result) => {
                                    window.location.href = '/clientes/';
                                });
                            } else {
                                AlertSweet("Error!", "Se produjo un error durante el proceso de eliminación, notificar al administrador del sistema", "error");
                            }
                        })
                        .catch(function(error) {
                            AlertSweet("Proveedor no encontrado!", "Favor verificar la información.", "error");
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


<div class="modal fade" tabindex="-1" id="cliente">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title">Crear Cliente</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="card-body">
                        <p>
                            <center>
                                <form action="/clientes" method="post" id="myForm">
                                    {{ csrf_field() }}
                                    <div class="row g-3">
                                        <div class="col-md-12">
                                            <label for="dni" class="form-label">No. Identificación/NIT</label>
                                            <input type="number" class="form-control" name="dni_cl" id="dni" required placeholder="Número Identificacion">
                                            <span id="dni-error" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="name" class="form-label">Nombre/Razon Social</label>
                                            <input type="text" class="form-control" name="nombre_cl" id="name" required placeholder="Nombre cliente">
                                            <span id="name-error" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="tel" class="form-label">Telefono/Celular</label>
                                            <input type="text" class="form-control" name="tel" id="tel" placeholder="310 456 7890">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="direccion" class="form-label">Dirección</label>
                                            <input type="text" class="form-control" name="direccion" id="direccion" placeholder="Cll 45 No. ...">
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
                <a href="#" id="btnEnvio" class="btn btn-success disabled"><i class="far fa-save"></i> Guardar Cambios</a>
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
    document.getElementById('dni').addEventListener('blur', function() {
        var dni = this.value;
        if (dni) {
            axios.get('{{ route("clientes.validar_dni") }}', {
                    params: {
                        dni: dni
                    }
                })
                .then(function(response) {
                    var dniError = document.getElementById('dni-error');
                    if (response.data.exists) {
                        dniError.textContent = 'Error, cliente ya está registrado';
                        AlertSweet("Cliente ya está registrado!", "Favor verificar la información.", "error");
                        $('#btnEnvio').addClass('disabled');
                    } else {
                        dniError.textContent = '';
                        $('#btnEnvio').removeClass('disabled');
                    }
                })
                .catch(function(error) {
                    console.error(error);
                });
        }
    });

    function AlertSweet(title, text, icon) {
        Swal.fire({
            title,
            text,
            icon
        });
    }

    function resetform() {
        $("#myForm")[0].reset();
    }

    document.getElementById('btnEnvio').addEventListener('click', function() {
        const dni = document.getElementById('dni').value;
        const nom = document.getElementById('name').value;
        const tel = document.getElementById('tel').value;
        const dir = document.getElementById('direccion').value;

        if (dni === '' || dni.length === 0) {
            document.getElementById('dni').classList.add('bg-warning');
        } else {
            document.getElementById('dni').classList.remove('bg-warning');
            if (nom === '' || nom.length === 0) {
                document.getElementById('name').classList.add('bg-warning');
            } else {
                document.getElementById('name').classList.remove('bg-warning');
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
    });
</script>