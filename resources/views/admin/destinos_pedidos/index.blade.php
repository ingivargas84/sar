@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Destinos de Pedido
      <small>Todos los destinos de pedido</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Destinos de Pedido</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.destinos_pedidos.createModal')
@include('admin.destinos_pedidos.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalDestino">
        <i class="fa fa-plus"></i>Agregar Destino
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="destinos_pedidos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">
        {{--<input type="text" name="urlActual" value="{{Request::path()}}">--}}
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      destinos_pedidos_table.ajax.url("{{route('destinos_pedidos.getJson')}}").load();
    });
  </script>
@endpush

@push('scripts')
  <script src="{{asset('js/destinos_pedidos/index.js')}}"></script>
  <script src="{{asset('js/destinos_pedidos/create.js')}}"></script>
  <script src="{{asset('js/destinos_pedidos/edit.js')}}"></script>
@endpush