@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Compras
      <small>Todos los compras</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Compras</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
@include('admin.compras.editModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a href="{{route('compras.new')}}" class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>Agregar Compra
      </a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="compras-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
        </table>        
        <input type="hidden" name="urlActual" value="{{url()->current()}}">
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
      compras_table.ajax.url("{{route('compras.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/compras/index.js')}}"></script>
  <script src="{{asset('js/compras/edit.js')}}"></script>
@endpush