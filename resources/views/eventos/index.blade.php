@extends('adminlte::page')

@section('title', 'Eventos')

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
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="sticky-top mb-3">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Crear Evento</h4>
                                </div>
                                <div class="card-body">
                                    <!-- the events -->
                                    <div id="external-events">
                                        <div class="input-group-append">
                                            <a href="#evento" data-toggle="modal" title="Crear Servicio" class="btn btn-warning">Nuevo</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                    <!-- /.col -->
                    <div class="col-md-9">
                        <div class="card card-primary">
                            <div class="card-body p-0">
                                <!-- THE CALENDAR -->
                                <div id="calendar"></div>
                                <div id="calendarFull"></div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
</div>

<div class="modal" tabindex="-1" id="evento">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Eventos</h5>
                <!--<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>-->
            </div>
            <div class="modal-body">
                <form action="/eventos" method="POST" id="formularioEventos" name="formularioEventos">
                    {{ csrf_field() }}
                    <div class="form-group d-none">
                        <label for="id">ID</label>
                        <input type="text" class="form-control" name="dni" id="dni" aria-describedby="helpId" placeholder="">
                        <span id="dni-error" class="text-red-500"></span>
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
                    <div class="form-group">
                        <label for="title">Tipo de Evento</label>
                        <select class="form-control" name="tipo_ev" id="tipo_ev" aria-describedby="helpId" tabindex="1" required>
                            <option value="">Seleccione...</option>
                            @foreach ($tipos as $tipos)
                            <option value="{{$tipos->id}}">{{ $tipos->name}} </option>
                            @endforeach
                        </select>
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
                    <div class="form-group">
                        <label for="title">Nombre del Evento</label>
                        <input type="text" name="name_ev" id="name_ev" class="form-control" placeholder="Nombre del Evento" required tabindex="2">
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
                    <div class="row">
                        <label for="">Datos de Inicio</label>
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" name="fecha_ini" id="fecha_ini" aria-describedby="helpId" placeholder="" tabindex="3" required>
                            <small id="helpId" class="form-text text-muted">Fecha</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="hora_ini" id="hora_ini" aria-describedby="helpId" placeholder="" tabindex="4" required>
                            <small id="helpId" class="form-text text-muted">Hora</small>
                        </div>
                    </div>
                    <div class="row">
                        <label for="">Datos de Fin</label>
                        <div class="form-group col-md-6">
                            <input type="date" class="form-control" name="fecha_fin" id="fecha_fin" aria-describedby="helpId" placeholder="" tabindex="5" required>
                            <small id="helpId" class="form-text text-muted">Fecha</small>
                        </div>
                        <div class="form-group col-md-6">
                            <input type="time" class="form-control" name="hora_fin" id="hora_fin" aria-describedby="helpId" placeholder="" tabindex="6" required>
                            <small id="helpId" class="form-text text-muted">Hora</small>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-check form-switch">
                            <input class="form-check-input" name="todoDia" type="checkbox" id="flexSwitchCheckDefault" tabindex="7">
                            <label class="form-check-label" for="flexSwitchCheckDefault"> Activar si el evento es todo el día</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="descripcion">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3" tabindex="8" required></textarea>
                        <small id="helpId" class="form-text text-muted">&nbsp;</small>
                    </div>
            </div>
            <div class="modal-footer">
                <!-- button type="button" class="btn btn-secondary" id="btnCerrar" data-bs-dismiss="modal">Close</button>-->
                <button type="submit" class="btn btn-success" id="btnGuardar">Guardar</button>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#btnCerrar').on('click', function() {
            $('#evento').hide();
        });
    });
</script>

<script src="../vendor/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- jQuery UI -->
<script src="../vendor/jquery-ui/jquery-ui.min.js"></script>
<!-- AdminLTE App -->
<script src="../js/agenda.js"></script>


<!-- fullCalendar 2.2.5 -->
<script src="../vendor/moment/moment.min.js"></script>
<script src="../vendor/fullcalendar/main.js"></script>
<!-- AdminLTE for demo purposes -->
<!-- Page specific script -->
<script>
    $(function() {

        /* initialize the external events
         -----------------------------------------------------------------*/
        function ini_events(ele) {
            ele.each(function() {

                // create an Event Object (https://fullcalendar.io/docs/event-object)
                // it doesn't need to have a start or end
                var eventObject = {
                    title: $.trim($(this).text()) // use the element's text as the event title
                }

                // store the Event Object in the DOM element so we can get to it later
                $(this).data('eventObject', eventObject)

                // make the event draggable using jQuery UI
                $(this).draggable({
                    zIndex: 1070,
                    revert: true, // will cause the event to go back to its
                    revertDuration: 0 //  original position after the drag
                })

            })
        }

        ini_events($('#external-events div.external-event'))

        /* initialize the calendar
         -----------------------------------------------------------------*/
        //Date for the calendar events (dummy data)
        var date = new Date()
        var d = date.getDate(),
            m = date.getMonth(),
            y = date.getFullYear()

        var Calendar = FullCalendar.Calendar;
        var Draggable = FullCalendar.Draggable;

        var containerEl = document.getElementById('external-events');
        var checkbox = document.getElementById('drop-remove');
        var calendarEl = document.getElementById('calendar');

        // initialize the external events
        // -----------------------------------------------------------------

        new Draggable(containerEl, {
            itemSelector: '.external-event',
            eventData: function(eventEl) {
                return {
                    title: eventEl.innerText,
                    backgroundColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    borderColor: window.getComputedStyle(eventEl, null).getPropertyValue('background-color'),
                    textColor: window.getComputedStyle(eventEl, null).getPropertyValue('color'),
                };
            }
        });

        var calendar = new Calendar(calendarEl, {
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'listYear,dayGridMonth,timeGridWeek,timeGridDay'
            },
            themeSystem: 'bootstrap',

            //Random default events
            events: [
                <?php
                for ($i = 0; $i < sizeof($ev); $i++) {

                    $f2 = explode(" ", $ev[$i]["fechaInicio"]);
                    $ff = explode("-", $f2[0]);
                    $mes = $ff[1] - 1;
                    $dia = $ff[2];
                    $ano = $ff[0];

                    $partes = explode(":", $ev[$i]["horaInicio"]);
                    $hora = $partes[0];
                    $min = $partes[1];
                    $seg = $partes[2];

                    $f3 = explode(" ", $ev[$i]["fechaFinal"]);
                    $fff = explode("-", $f3[0]);
                    $mesF = $fff[1] - 1;
                    $diaF = $fff[2];
                    $anoF = $fff[0];

                    $partesF = explode(":", $ev[$i]["horaFinal"]);
                    $horaF = $partesF[0];
                    $minF = $partesF[1];
                    $segF = $partesF[2];
                    $todoDia = $ev[$i]["todoDia"];
                ?> {
                        title: '<?php echo $ev[$i]["nombre_ev"]; ?>',
                        start: new Date(<?php echo $ano ?>, <?php echo $mes ?>, <?php echo $dia ?>, <?php echo $hora ?>, <?php echo $min ?>),
                        end: new Date(<?php echo $anoF ?>, <?php echo $mesF ?>, <?php echo $diaF ?>, <?php echo $horaF ?>, <?php echo $minF ?>),
                        url: '/eventos/<?php echo $ev[$i]["idEvento"]; ?>/edit',
                        backgroundColor: '#0073b7', //Blue
                        borderColor: '#0073b7', //Blue
                        allDay: <?php echo $todoDia ?>
                    },
                <?php } ?>
            ],
            editable: false,
            droppable: false, // this allows things to be dropped onto the calendar !!!
            drop: function(info) {
                // is the "remove after drop" checkbox checked?
                if (checkbox.checked) {
                    // if so, remove the element from the "Draggable Events" list
                    info.draggedEl.parentNode.removeChild(info.draggedEl);
                }
            }
        });
        calendar.render();
        // console.log('Start: ', dataStart;);
        // console.log('End: ', dataEnd;);
        /* $dataEnd = "'" . $anoF . "-" . $mesF . "-" . $diaF . "T" . $horaF . ":" . $minF . ":" . $segF;
                    $ini = $ev[$i]["fechaHoraInicio"];
                    $fin = $ev[$i]["fechaHoraFinal"]; */
        //$dataStart = $ano . "-" . $mes . "-" . $dia . "T" . $hora . ":" . $min . ":" . $seg;

        /* ADDING EVENTS */
        var currColor = '#3c8dbc' //Red by default
        // Color chooser button
        $('#color-chooser > li > a').click(function(e) {
            e.preventDefault()
            // Save color
            currColor = $(this).css('color')
            // Add color effect to button
            $('#add-new-event').css({
                'background-color': currColor,
                'border-color': currColor
            })
        })
        $('#add-new-event').click(function(e) {
            e.preventDefault()
            // Get value and make sure it is not null
            var val = $('#new-event').val()
            if (val.length == 0) {
                return
            }

            // Create events
            var event = $('<div />')
            event.css({
                'background-color': currColor,
                'border-color': currColor,
                'color': '#fff'
            }).addClass('external-event')
            event.text(val)
            $('#external-events').prepend(event)

            // Add draggable funtionality
            ini_events(event)

            // Remove event from text input
            $('#new-event').val('')
        })
    })
</script>
@stop