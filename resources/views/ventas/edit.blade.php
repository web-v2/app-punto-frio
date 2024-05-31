@extends('adminlte::page')

@section('title', 'Productos')

@section('content_header')
<h1>Actualizar Datos del Producto</h1>
@stop

@section('content')
<form action="/productos/{{$productos[0]->idProducto}}" method="POST" id="formUpdate">
    @csrf
    @method('PUT')
    <div class="card">
        <div class="card-body">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del producto</label>
                <input type="text" name="descripcion_pd" id="descripcion_pd" class="form-control" value="{{$productos[0]->descripcion_pd}}" tabindex="1" required>
            </div>
            <div class="mb-3">
                <label for="proveedor" class="form-label">Nombre del proveedor</label>
                <select name="proveedor" id="proveedor" class="form-control" tabindex="2" required>
                    @foreach ($proveedores as $pv)
                    @if ($productos[0]->proveedor_id == $pv->idProveedor)
                    <option value="{{ $pv->idProveedor }}" selected>{{ $pv->dni_pv }}-{{ $pv->nombre_pv }}</option>
                    @else
                    <option value="{{ $pv->idProveedor }}">{{ $pv->dni_pv }}-{{ $pv->nombre_pv }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="val" class="form-label">Valor</label>
                <input type="text" name="val" id="val" class="form-control" value="{{ number_format($productos[0]->valor_pd, 0, ',', '.') }}" tabindex="3" required>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Estado del Proveedor</label>
                <?php $stt = ($productos[0]->estado_pd == 'ACTIVO') ? 'bg-success' : 'bg-danger'; ?>
                <select name="status" id="status" class="form-control <?php echo $stt; ?>" tabindex="4" required>
                    @if ($productos[0]->estado_pd == 'ACTIVO')
                    <option value="{{$productos[0]->estado_pd}}" selected>{{$productos[0]->estado_pd}}</option>
                    <option value="INACTIVO">INACTIVO</option>
                    @else
                    <option value="ACTIVO">ACTIVO</option>
                    <option value="{{$productos[0]->estado_pd}}" selected>{{$productos[0]->estado_pd}}</option>
                    @endif
                </select>
            </div>

            <a href="/productos" class="btn btn-secondary btn-lg" tabindex="5">Cancelar</a>
            <a href="#" class="btn btn-primary btn-lg" tabindex="6" onclick="enviarUpdate()">Guardar</a>
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
        const nom = document.getElementById('descripcion_pd').value;
        const val = document.getElementById('val').value;

        if (nom === '' || nom.length === 0) {
            document.getElementById('descripcion_pd').classList.add('bg-warning');
            //console.log('No paso name');
        } else {
            document.getElementById('descripcion_pd').classList.remove('bg-warning');
            if (val === '' || val.length === 0) {
                document.getElementById('val').classList.add('bg-warning');
                //console.log('No paso valor');
            } else {
                document.getElementById('val').classList.remove('bg-warning');
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