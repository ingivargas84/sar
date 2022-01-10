@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Crear Insumo
      <small>Crear Insumo</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('insumos.index')}}"><i class="fa fa-list"></i> Insumos</a></li>
      <li class="active">Crear</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
      <form method="POST" id="InsumoForm"  action="{{route('insumos.save')}}">
      {{csrf_field()}}
        <div class="row">
          <div class="form-group col-sm-4 {{ $errors->has('nombre') ? 'has-error': '' }}">
            <label for="nombre">Nombre de Insumo:</label>
            <input type="text" name="nombre" placeholder="Ingrese Nombre de Insumo" class="form-control" value="{{old('nombre')}}">
            {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-4 {{ $errors->has('unidad_id') ? 'has-error': '' }}">
            <label for="unidad_id">Unidad:</label>
            <select class="form-control" name="unidad_id">
              <option value="">Selecciona Unidad</option>
                  @foreach($unidades as $unidad)
                      <option value="{{ $unidad->id }}">{{ $unidad->nombre }}</option>
                  @endforeach
            </select>
            {!! $errors->first('unidad_id', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-4 {{ $errors->has('categoria_insumo_id') ? 'has-error': '' }}">
            <label for="categoria_insumo_id">Categoria:</label>
            <select class="form-control" name="categoria_insumo_id">
              <option value="">Selecciona Categoria</option>
                  @foreach($categorias as $categoria)
                      <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                  @endforeach
            </select>
            {!! $errors->first('categoria_insumo_id', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group col-sm-6 {{ $errors->has('medida_id') ? 'has-error': '' }}">
            <label for="medida_id">Medida:</label>
            <select class="form-control" name="medida_id">
              <option value="">Selecciona Medida</option>
                  @foreach($unidades as $medida)
                      <option value="{{ $medida->id }}">{{ $medida->nombre }}</option>
                  @endforeach
            </select>
            {!! $errors->first('medida_id', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-6 {{ $errors->has('cantidad_medida') ? 'has-error': '' }}">
            <label for="cantidad_medida">Cant.X Medida:</label>
            <input type="number" name="cantidad_medida" placeholder="Cant.X Medida" class="form-control">
            {!! $errors->first('cantidad_medida', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group col-sm-6 {{ $errors->has('stock_minimo') ? 'has-error': '' }}">
            <label for="stock_minimo">Stock Minimo</label>
            <input type="number" name="stock_minimo" placeholder="Stock Minimo" class="form-control">
            {!! $errors->first('stock_minimo', '<span class="help-block">:message</span>') !!}
          </div>
          <div class="form-group col-sm-6 {{ $errors->has('total_stock') ? 'has-error': '' }}">
            <label for="total_stock">Total Stock Minimo</label>
            <input type="text" name="total_stock" placeholder="Total Stock Minimo" class="form-control" disabled>
            {!! $errors->first('total_stock', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <br>
        <div class="text-right m-t-15">
          <a class="btn btn-default" href="{{ route('insumos.index') }}">Regresar</a>
          <button class="btn btn-primary form-button" id="ButtonInsumo">Guardar</button>
        </div>
      </form>
      <div class="loader loader-bar"></div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box primary --> 

@endsection


@push('styles')
  
@endpush

@push('scripts')
  <script>
    $.validator.addMethod("nombreUnico", function(value, element) {
    var valid = false;
    $.ajax({
      type: "GET",
      async: false,
      url: "{{route('insumos.nombreDisponible')}}",
      data: "nombre=" + value,
      dataType: "json",
      success: function(msg) {
        valid = !msg;
      }
    });
    return valid;
  }, "El nombre del insumo ya está registrado en el sistema");
  </script>
  <script src="{{asset('js/insumos/create.js')}}"></script>
@endpush