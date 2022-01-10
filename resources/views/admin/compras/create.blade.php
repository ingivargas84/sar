@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Crear Compra
      <small>Crear Compra</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('compras.index')}}"><i class="fa fa-list"></i> Compras</a></li>
      <li class="active">Crear</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
          <div class="form-group col-sm-3 {{ $errors->has('proveedor_id') ? 'has-error': '' }}">
            <label for="proveedor_id">Proveedor</label>
            <select class="form-control" name="proveedor_id" id="proveedor_id">
              <option value="" disabled selected>Seleccione Proveedor</option>
                  @foreach($proveedores as $proveedor)
                      <option value="{{ $proveedor->id }}">{{ $proveedor->nombre_comercial }}</option>
                  @endforeach
            </select>
            {!! $errors->first('proveedor_id', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="col-sm-3">
            <label>Fecha de Factura</label>
            <input name="fecha_factura" type="date" class="form-control">

          </div>

          <div class="col-sm-3">
            <label for="">Serie</label>
            <input type="text" name="serie" class="form-control">
          </div>

          <div class="col-sm-3">
            <label for="">Núnero Documento</label>
            <input type="text" name="numero_doc" class="form-control">
          </div>

        </div>
        <br>        
        <div class="row">
          <div class="form-group col-sm-3 {{ $errors->has('insumo_id') ? 'has-error': '' }}">
            <label for="insumo_id">Insumo:</label>
            <select class="form-control select2" name="insumo_id" id="insumo_id">
            </select>
            {!! $errors->first('insumo_id', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-3 {{ $errors->has('cantidad') ? 'has-error': '' }}">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" placeholder="Cantidad" class="form-control" min="1" pattern="^[1-9]+">
            {!! $errors->first('cantidad', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-3 {{ $errors->has('precio') ? 'has-error': '' }}">
            <label for="precio">Precio</label>
            <input type="number" name="precio" placeholder="Precio" class="form-control" min="0" pattern="^[0-9]+">
            {!! $errors->first('precio', '<span class="help-block">:message</span>') !!}
            <input type="hidden" name="subtotal">
            <input type="hidden" name="cantidad_medida">
          </div>

          <div class="form-group col-sm-3 {{ $errors->has('unidad_medida_id') ? 'has-error': '' }}">
            <label for="unidad_medida_id">Unidad de Medida:</label>
            <select class="form-control" name="unidad_medida_id" id="unidad_medida_id" disabled>
              <option value="">Selecciona Unidad de Medida</option>
                  @foreach($unidades as $medida)
                      <option value="{{ $medida->id }}">{{ $medida->nombre }}</option>
                  @endforeach
            </select>
            {!! $errors->first('unidad_medida_id', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <div class="text-right m-t-15">
          <button class="btn btn-primary form-button" id="btnDetalle">Agregar</button>
        </div>
        <hr>

          <div id="detalle-grid"></div>
        
        <br>
        <div class="row">
          <div class="col-sm-4">
              <h2>Total</h2>
              <input type="text" name="total" class="form-control" disabled>
          </div>
        </div>
        
        <br>
        <div class="text-right m-t-15">
          <a class="btn btn-default" href="{{ route('compras.index') }}">Regresar</a>
          <button class="btn btn-primary form-button" id="ButtonCompra">Guardar</button>
        </div>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box primary --> 

@endsection


@push('styles')

@endpush

@push('scripts')
  <script>

    $('.select2').select2();

    $("#insumo_id").change(function() {
        var codigo = $("#insumo_id").val();
        var url = "{{route('insumos.get', ['codigo='])}}" + codigo;  
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("#unidad_medida_id").val("");
                $("#unidad_medida_id").change();
                $("input[name='cantidad_medida']").val("");
                $("input[name='precio']").val("");
            }
            else {
                $("#unidad_medida_id").val(result[0].unidad_id);
                $("#unidad_medida_id").change();
                $("input[name='precio']").val(result[0].precio);
                $("input[name='cantidad_medida']").val(result[0].cantidad_medida);
            }
        });
    })
    function cargarSelectInsumo(query){
    $('#insumo_id').empty();
    $("#insumo_id").append('<option value="" selected disabled>Seleccione Insumo</option>');
    $.ajax({
      type: "GET",
      url: "{{route('insumos.cargar')}}", 
      dataType: "json",
      data: "query=" + query,
      success: function(data){
        $.each(data,function(key, registro) {

        $("#insumo_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');

        });
    
      },
      error: function(data) {
        alert('error');
      }
      });
      }
  </script>
  <script src="{{asset('js/compras/create.js')}}"></script>
@endpush