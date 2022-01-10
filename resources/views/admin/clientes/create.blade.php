@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          CLIENTES
          <small>Crear Cliente</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ClienteForm"  action="{{route('clientes.save')}}">
            {{csrf_field()}}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="cui">CUI/DPI</label>
                                <input type="text" class="form-control" placeholder="CUI/DPI" name="cui">
                            </div>
                            <div class="col-sm-4">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" >
                            </div>
                            <div class="col-sm-4">
                                <label>Fecha de Nacimiento:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_nacimiento" type="text" class="form-control pull-right" id="datepickerN">
                                </div>
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres:" name="nombres" >
                            </div>
                            <div class="col-sm-6">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" >
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono:" name="telefono" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Celular:</label>
                                <input type="text" class="form-control" placeholder="Celular:" name="celular" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Email:</label>
                                <input type="text" class="form-control" placeholder="Email:" name="email" >
                            </div>                                
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Dirección:</label>
                                <input type="text" class="form-control" placeholder="Dirección:" name="direccion" >
                            </div>                                
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                            <button class="btn btn-success form-button">Guardar</button>
                        </div>
                                    
                    </div>
                </div>                
            </div>
    </form>
<div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')

<script>
    $.validator.addMethod("cuiUnico", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "{{route('clientes.dpiDisponible')}}",
            data: "cui=" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El DPI ya está asignado a otro cliente registrado en el sistema");

    $.validator.addMethod("nitUnico", function(value, element) {
        var valid = false;
        $.ajax({
            type: "GET",
            async: false,
            url: "{{route('clientes.nitDisponible')}}",
            data: "nit=" + value,
            dataType: "json",
            success: function(msg) {
                valid = !msg;
            }
        });
        return valid;
    }, "El nit ya está registrado en el sistema");
</script>

<script src="{{asset('js/clientes/create.js')}}"></script>
@endpush