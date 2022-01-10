@extends('admin.layoutadmin')

@section('header')
    <section class="content-header">
        <h1>
          CLIENTES
          <small>Editar Cliente</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> Inicio</a></li>
          <li><a href="{{route('clientes.index')}}"><i class="fa fa-list"></i> Clientes</a></li>
          <li class="active">Crear</li>
        </ol>
    </section>
@stop

@section('content')
    <form method="POST" id="ClienteUpdateForm"  action="{{route('clientes.update', $cliente)}}">
            {{csrf_field()}} {{ method_field('PUT') }}
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4 {{$errors->has('cui')? 'has-error' : ''}}">
                                <label for="cui">CUI/DPI</label>
                                <input type="text" class="form-control" placeholder="CUI/DPI" name="cui" value="{{old('cui', $cliente->cui)}}">
                                {!!$errors->first('cui', '<label class="error">:message</label>')!!}
                            </div>
                            <div class="col-sm-4 {{$errors->has('nit')? 'has-error' : ''}}">
                                <label for="nit">Nit:</label>
                                <input type="text" class="form-control" placeholder="Nit:" name="nit" value="{{old('nit', $cliente->nit)}}" >
                                {!!$errors->first('nit', '<label class="error">:message</label>')!!}
                            </div>
                            <div class="col-sm-4">
                                <label>Fecha de Nacimiento:</label>
                        
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
    
                                    <input name="fecha_nacimiento" type="text" class="form-control pull-right" id="datepickerN" value="{{old('fecha_nacimiento', $cliente->fecha_nacimiento ? $cliente->fecha_nacimiento->format('d-m-Y') : null) }}">
                                </div>
                            </div>
                        </div>
                        <br>                
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="nombres">Nombres:</label>
                                <input type="text" class="form-control" placeholder="Nombres:" name="nombres" value="{{old('nombres', $cliente->nombres)}}">
                            </div>
                            <div class="col-sm-6">
                                <label for="apellidos">Apellidos:</label>
                                <input type="text" class="form-control" placeholder="Apellidos:" name="apellidos" value="{{old('apellidos', $cliente->apellidos)}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm-4">
                                <label for="telefono">Teléfono:</label>
                                <input type="text" class="form-control" placeholder="Teléfono:" name="telefono" value="{{old('telefono', $cliente->telefono)}}" >
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Celular:</label>
                                <input type="text" class="form-control" placeholder="Celular:" name="celular" value="{{old('celular', $cliente->celular)}}">
                            </div>
                            <div class="col-sm-4">
                                <label for="celular">Email:</label>
                                <input type="text" class="form-control" placeholder="Email:" name="email" value="{{old('email', $cliente->email)}}">
                            </div>                                
                        </div>
                        <br>

                        <div class="row">
                            <div class="col-sm-12">
                                <label for="direccion">Direcciónn:</label>
                                <input type="text" class="form-control" placeholder="Direcciónn:" name="direccion" value="{{old('direccion', $cliente->direccion)}}">
                            </div>                                
                        </div>
                        <br>
                        <div class="text-right m-t-15">
                            <a class='btn btn-primary form-button' href="{{ route('clientes.index') }}">Regresar</a>
                            <button class="btn btn-success form-button" id="ButtonClienteUpdate">Guardar</button>
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

<script src="{{asset('js/clientes/edit.js')}}"></script>
@endpush