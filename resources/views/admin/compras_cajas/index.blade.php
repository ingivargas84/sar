@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Compras por Caja
      <small>Todas las compras por caja</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Compras por Caja</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.compras_cajas.createModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCompraCaja">
        <i class="fa fa-plus"></i>Agregar Compra
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="compras_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      compras_cajas_table.ajax.url("{{route('compras_cajas.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/compras_cajas/index.js')}}"></script>
  <script src="{{asset('js/compras_cajas/create.js')}}"></script>
@endpush