@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Editar Producto
      <small>Editar Producto</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('productos.index')}}"><i class="fa fa-list"></i> Productos</a></li>
      <li class="active">Editar</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
      <form method="POST" id="ProductoUpdateForm"  action="{{route('productos.update', $producto)}}">
      {{csrf_field()}}  {{ method_field('put') }}
      <input type="text" name="id" hidden value="{{$producto->id}}">
        <div class="row">
          <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
            <label for="nombre">Nombre de Producto:</label>
            <input type="text" name="nombre" placeholder="Ingrese Nombre de Producto" class="form-control" value="{{old('nombre',$producto->nombre)}}">
            {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-6 {{ $errors->has('categoria_menu_id') ? 'has-error': '' }}">
            <label for="categoria_menu_id">Categoria:</label>
            <select class="form-control" name="categoria_menu_id">
              <option value="">Selecciona Categoria</option>
                  @foreach($categorias as $categoria)
                    @if($categoria->id == $producto->categoria_menu_id)
                      <option value="{{ $categoria->id }}" selected>{{ $categoria->nombre }}</option>
                    @else
                      <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endif
                  @endforeach
            </select>
            {!! $errors->first('categoria_menu_id', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <br>
        <div class="row">
          <div class="form-group col-sm-6 {{ $errors->has('destino_pedido_id') ? 'has-error': '' }}">
            <label for="destino_pedido_id">Destino:</label>
            <select class="form-control" name="destino_pedido_id">
              <option value="">Seleccione Destino</option>
                  @foreach($destinos as $destino)
                    @if($destino->id == $producto->destino_pedido_id)
                      <option value="{{ $destino->id }}" selected>{{ $destino->destino }}</option>
                    @else
                      <option value="{{ $destino->id }}">{{ $destino->destino }}</option>
                    @endif
                  @endforeach
            </select>
            {!! $errors->first('destino_pedido_id', '<span class="help-block">:message</span>') !!}
          </div>
          <div class="form-group col-sm-6 {{ $errors->has('precio') ? 'has-error': '' }}">
            <label for="precio">Precio:</label>
            <input type="number" name="precio" placeholder="precio" class="form-control" value="{{old('nombre',$producto->precio)}}">
            {!! $errors->first('precio', '<span class="help-block">:message</span>') !!}
          </div>
        </div>
        <br>
        <div class="text-right m-t-15">
          <a class="btn btn-default" href="{{ route('productos.index') }}">Regresar</a>
          <button class="btn btn-primary form-button" id="ButtonProductoUpdate">Actualizar</button>
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
      $.validator.addMethod("nombreUnicoEdit", function(value, element) {
      var valid = false;
      var urlActual =  $("input[name='urlActual']").val();
      var id = $("input[name='id']").val();
      $.ajax({
        type: "GET",
        async: false,
        url: "{{route('productos.nombreDisponibleEdit')}}",
        data: {"nombre" : value, "id" : id},
        dataType: "json",
        success: function(msg) {
          valid = !msg;
        }
      });
      return valid;
    }, "El nombre del producto ya está registrado en el sistema");
  </script>
  <script src="{{asset('js/productos/edit.js')}}"></script>
@endpush