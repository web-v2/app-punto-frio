@extends('adminlte::page')

@section('title', 'Eventos')

@section('content_header')
<h1>Evento No. {{$eventos[0]->idEvento}}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <!-- Main content -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Evento: {{$eventos[0]->nombre_ev}}</h5>
            </div>
            <div class="modal-body">
                <form action="/eventos/{{$eventos[0]->idEvento}}" method="POST" id="formularioEventos" name="formularioEventos">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Tipo de Evento</label>
                        <select class="form-control" name="tipo_ev" id="tipo_ev" aria-describedby="helpId" tabindex="1" required>
                            <option value="">Seleccione...</option>
                            @foreach ($tipos as $tipos)
                            @if($eventos[0]->tipo_ev_id == $tipos->id)
                            <option value="{{$tipos->id}}" selected>{{ $tipos->name}} </option>
                            @else
                            <option value="{{$tipos->id}}">{{ $tipos->name}} </option>
                            @endif
                            @endforeach
                        </select>
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
                    <div class="form-group">
                        <label for="title">Nombre del Evento</label>
                        <input type="text" name="name_ev" id="name_ev" class="form-control" placeholder="Nombre del Evento" required tabindex="2" value="{{$eventos[0]->nombre_ev}}">
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
                    <div class="row">
                        <label for="">Datos de Inicio</label>
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" name="fecha_ini" id="fecha_ini" aria-describedby="helpId" placeholder="" tabindex="3" value="{{$eventos[0]->fechaInicio}}">
                            <small id="helpId" class="form-text text-muted">Fecha</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="hora_ini" id="hora_ini" aria-describedby="helpId" placeholder="" tabindex="4" value="{{$eventos[0]->horaInicio}}">
                            <small id="helpId" class="form-text text-muted">Hora</small>
                        </div>
                    </div>
                    <div class="row">
                        <label for="">Datos de Fin</label>
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" aria-describedby="helpId" placeholder="" tabindex="5" value="{{$eventos[0]->fechaFinal}}">
                            <small id="helpId" class="form-text text-muted">Fecha</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="hora_fin" id="hora_fin" aria-describedby="helpId" placeholder="" tabindex="6" value="{{$eventos[0]->horaFinal}}">
                            <small id="helpId" class="form-text text-muted">Hora</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="todoDia" type="checkbox" id="flexSwitchCheckDefault" tabindex="7" @if($eventos[0]->todoDia) checked @endif>
                            <label class="form-check-label" for="flexSwitchCheckDefault"> Activar si el evento es todo el día</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" tabindex="8">{{$eventos[0]->descripcion_ev}}</textarea>
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="btnGuardar">Actualizar Evento</button>
                <a href="#" class="btn btn-warning" onclick="confirmarEliminacion(event, <?php echo $eventos[0]->idEvento ?>)">Cancelar Evento</a>
                <a href="/eventos" class="btn btn-secondary">Cerrar</a>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
<!-- Font Awesome -->
<link rel="stylesheet" href="../vendor/fontawesome-free/css/all.min.css">
<!-- fullCalendar -->
<link rel="stylesheet" href="../vendor/fullcalendar/main.css">
<!-- Theme style -->
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="text/javascript">
    function confirmarEliminacion(event, id) {
        event.preventDefault();
        Swal.fire({
            title: "¿Estás seguro de que deseas eliminar este evento?",
            text: "Esta acción no se podra revertir!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, eliminar!"
        }).then((result) => {
            if (result.isConfirmed) {
                eliminarElemento(id);
                Swal.fire({
                    title: "Eliminado!",
                    text: "Registro eliminado correctamente!",
                    icon: "success"
                });
            }
        });
    }

    function eliminarElemento(id) {

        axios.delete(`/eventos/${id}`)
            .then(response => {
                window.location.href = '/eventos/';
            })
            .catch(error => {
                console.error('Error al eliminar el elemento:', error);
                alert('Error al eliminar el elemento. Por favor, inténtalo de nuevo.');
            });

    }

    $(document).ready(function() {
        $('#btnGuardar').on('click', function() {
            Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Registro actualizado correctamente!',
                showConfirmButton: false,
                timer: 1500
            });
        })
    })
</script>
@stop