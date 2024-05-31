@extends('adminlte::page')

@section('title', 'Proveedores')

@section('content_header')
<h1>Actualizar Datos de Proveedor</h1>
@stop

@section('content')
<form action="/proveedores/{{$proveedores[0]->idProveedor}}" method="POST">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="dni" class="form-label">No. Identificación/NIT</label>
                <input type="number" name="dni_pv" id="dni" class="form-control" value="{{$proveedores[0]->dni_pv}}" tabindex="1" required>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nombre/Razon Social</label>
                <input type="text" name="nombre_pv" id="name" class="form-control" value="{{$proveedores[0]->nombre_pv}}" tabindex="2" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Nombre Contacto</label>
                <input type="text" name="contact" id="contact" class="form-control" value="{{$proveedores[0]->contacto_pv}}" tabindex="3" required>
            </div>
            <div class="mb-3">
                <label for="tel" class="form-label">Telefono/Celular</label>
                <input type="text" name="tel" id="tel" class="form-control" value="{{$proveedores[0]->telefono_pv}}" tabindex="4" required>
            </div>

            <div class="mb-3">
                <label for="dir" class="form-label">Dirección</label>
                <input type="text" name="direccion" id="direccion" class="form-control" value="{{$proveedores[0]->direccion_pv}}" tabindex="5" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Estado del Proveedor</label>
                <?php $stt = ($proveedores[0]->estado_pv == 'ACTIVO') ? 'bg-success' : 'bg-danger'; ?>
                <select name="status" id="status" class="form-control <?php echo $stt; ?>" tabindex="6">
                    @if ($proveedores[0]->estado_pv == 'ACTIVO')
                    <option value="{{$proveedores[0]->estado_pv}}" selected>{{$proveedores[0]->estado_pv}}</option>
                    <option value="INACTIVO">INACTIVO</option>
                    @else
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="{{$proveedores[0]->estado_pv}}" selected>{{$proveedores[0]->estado_pv}}</option>
                    @endif
                </select>
            </div>

            <a href="/proveedores" class="btn btn-secondary btn-lg" tabindex="7">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-lg" tabindex="8" onclick="AlertSweet()">Guardar</button>
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
    function AlertSweet() {
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Información Actualizada Correctamente!",
            showConfirmButton: false,
            timer: 1500
        });
    }
</script>
@stop