@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Crear Receta
      <small>Crear Receta</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('recetas.index')}}"><i class="fa fa-list"></i> Recetas</a></li>
      <li class="active">Crear</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
          <div class="form-group col-sm-6 {{ $errors->has('producto_id') ? 'has-error': '' }}">
            <label for="producto_id">Producto:</label>
            <select class="form-control" name="producto_id" id="producto_id">
              <option value="">Seleccione Producto</option>
                  @foreach($productos as $producto)
                      <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                  @endforeach
            </select>
            {!! $errors->first('producto_id', '<span class="help-block">:message</span>') !!}
          </div>

        </div>
        <br>
        
        <div class="row">
          <div class="form-group col-sm-4 {{ $errors->has('insumo_id') ? 'has-error': '' }}">
            <label for="insumo_id">Insumo:</label>
            <select class="form-control" name="insumo_id" id="insumo_id">
            </select>
            {!! $errors->first('insumo_id', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-4 {{ $errors->has('cantidad') ? 'has-error': '' }}">
            <label for="cantidad">Cantidad</label>
            <input type="number" name="cantidad" placeholder="Cantidad" class="form-control">
            {!! $errors->first('cantidad', '<span class="help-block">:message</span>') !!}
          </div>

          <div class="form-group col-sm-4 {{ $errors->has('unidad_medida_id') ? 'has-error': '' }}">
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
        <div class="text-right m-t-15">
          <a class="btn btn-default" href="{{ route('recetas.index') }}">Regresar</a>
          <button class="btn btn-primary form-button" id="ButtonReceta">Guardar</button>
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
    $("#insumo_id").change(function() {
        var codigo = $("#insumo_id").val();
        var url = "{{route('insumos.get', ['codigo='])}}" + codigo;  
        $.getJSON( url , function ( result ) {
            if (result == 0 ) {
                $("#unidad_medida_id").val("");
                $("#unidad_medida_id").change();
            }
            else {
                $("#unidad_medida_id").val(result[0].medida_id);
                $("#unidad_medida_id").change();
            }
        });
    })
    function cargarSelectInsumo(query){
    $('#insumo_id').empty();
    $("#insumo_id").append('<option value="" selected>Seleccione Insumo</option>');
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

  //Funcion para llenar GRID
    (function() {

    var db = {

        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },

        insertItem: function(insertingLink) {
            this.links.push(insertingLink);
            console.log(insertingLink);
        },

        updateItem: function(updatingLink) {
            console.log(updatingLink);
        },

        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_compra);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);

            var query = "SELECT I.id, I.nombre FROM insumos I WHERE I.estado = 1 ";
            var consulta ="";
            
            db.links.forEach(function(valor, indice, array){
                consulta += "AND I.id !="+ valor.insumo_id + " ";
            });
            var insumos = query + consulta;

            cargarSelectInsumo(insumos);
        }

    };
    window.db = db;
    db.links = [];

    //Funcion para guardar detalle
    function saveDetalle(button) {
      $('.loader').fadeIn();
        var producto_id = $("#producto_id").val();
        if ( producto_id != '') 
        {
            var formData = {producto_id : producto_id}
                var Datos = {'formData': formData, 'detalle': db.links}; 
                $.ajax({ 
                    type: "POST",
                    url: "{{route('recetas.save')}}",
                    data: Datos,
                    dataType: "json",
                    success: function(data) {
                      $('.loader').fadeOut(225);
                        if (data.success == "ok") {
                            window.location = "{{url('/recetas')}}"
                                }
                    },
                    error: function() {
                      $('.loader').fadeOut(225);
                        alert("Ocurrio un error Contacte al Administrador!");
                    }
                });
            }
            else
            {
                alert ('Verifique que los datos de la receta esten ingresados');
            }

        }

        $("#ButtonReceta").click(function(event) {
            saveDetalle();
        });


        $(document).ready(function () {

            $("#detalle-grid").jsGrid({
                width: "",
                filtering: false,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                inserting: false,
                pageSize: 20,
                pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
                pageNextText: '>',
                pagePrevText: '<',
                deleteConfirm: "Esta seguro de borrar el producto",
                controller: db,
                fields: [
                { title: "Insumo", name: "nombre", type: "text", editing: false},
                { title: "Codigo", name: "insumo_id", type: "text", visible:false},
                { title: "Cantidad", name: "cantidad", type: "text"},
                { title: "Unidad de Medida", name: "nombre_medida", type: "text", editing: false},
                //{ title: "Precio Compra", name: "precio_compra", type: "text"},
                //{ title: "Subtotal", name: "subtotal_compra", type: "text"},
                { type: "control" }
                ],
                onItemInserting: function (args) {
                },
                onItemUpdating: function (object) {
                },
                onRefreshed : function () {
                    $('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
                }
            });
        });
    }());
  </script>
  <script src="{{asset('js/recetas/create.js')}}"></script>
@endpush