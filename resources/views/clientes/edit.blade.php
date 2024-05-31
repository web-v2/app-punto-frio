@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
<h1>Actualizar Datos del Cliente</h1>
@stop

@section('content')
<form action="/clientes/{{$clientes[0]->idCliente}}" method="POST" id="formUpdate">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="dni" class="form-label">DNI del Cliente</label>
                <input type="number" name="dni_cl" id="dni_cl" class="form-control" value="{{$clientes[0]->dni_cl}}" tabindex="1" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombres del cliente</label>
                <input type="text" name="nombre_cl" id="nombre_cl" class="form-control" value="{{$clientes[0]->nombres_cl}}" tabindex="2" required>
            </div>
            <div class="mb-3">
                <label for="tel_cl" class="form-label">Telefonos</label>
                <input type="text" name="tel_cl" id="tel_cl" class="form-control" value="{{ $clientes[0]->telefono_cl}}" tabindex="3" required>
            </div>
            <div class="mb-3">
                <label for="direccion_cl" class="form-label">Dirección</label>
                <input type="text" name="direccion_cl" id="direccion_cl" class="form-control" value="{{ $clientes[0]->direccion_cl}}" tabindex="4" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Estado del Cliente</label>
                <?php $stt = ($clientes[0]->estado_cl == 'ACTIVO') ? 'bg-success' : 'bg-danger'; ?>
                <select name="status" id="status" class="form-control <?php echo $stt; ?>" tabindex="5" required>
                    @if ($clientes[0]->estado_cl == 'ACTIVO')
                    <option value="{{$clientes[0]->estado_cl}}" selected>{{$clientes[0]->estado_cl}}</option>
                    <option value="INACTIVO">INACTIVO</option>
                    @else
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="{{$clientes[0]->estado_cl}}" selected>{{$clientes[0]->estado_cl}}</option>
                    @endif
                </select>
            </div>

            <a href="/clientes" class="btn btn-secondary btn-lg" tabindex="6">Cancelar</a>
            <a href="#" class="btn btn-primary btn-lg" tabindex="7" onclick="enviarUpdate()">Guardar</a>
        </div>
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
</form>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function enviarUpdate() {
        const dni = document.getElementById('dni_cl').value;
        const nom = document.getElementById('nombre_cl').value;
        const tel = document.getElementById('tel_cl').value;
        const dir = document.getElementById('direccion_cl').value;

        if (dni === '' || dni.length === 0) {
            document.getElementById('dni_cl').classList.add('bg-warning');
        } else {
            document.getElementById('dni_cl').classList.remove('bg-warning');
            if (nom === '' || nom.length === 0) {
                document.getElementById('nombre_cl').classList.add('bg-warning');
            } else {
                document.getElementById('nombre_cl').classList.remove('bg-warning');
                Swal.fire({
                    position: "top-end",
                    icon: "success",
                    title: "Información Actualizada Correctamente!",
                    showConfirmButton: false,
                    timer: 1500
                });
                console.log('Todo OK - Formulario a enviar');
                document.getElementById('formUpdate').submit();
            }
        }
    }
</script>
@stop
