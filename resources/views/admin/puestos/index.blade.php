@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Puestos
      <small>Todos los puestos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Puestos</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.puestos.createModal')
@include('admin.puestos.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalPuesto">
        <i class="fa fa-plus"></i>Agregar Puesto
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="puestos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
    });
    $(document).ready(function() {
      puestos_table.ajax.url("{{route('puestos.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/puestos/index.js')}}"></script>
  <script src="{{asset('js/puestos/create.js')}}"></script>
  <script src="{{asset('js/puestos/edit.js')}}"></script>
@endpush