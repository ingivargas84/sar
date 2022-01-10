@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Tipos de Localidad
      <small>Todos los tipos de localidad</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Tipos de localidad</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.tipos_localidad.createModal')
@include('admin.tipos_localidad.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalTipoLocalidad">
        <i class="fa fa-plus"></i>Agregar Tipo de Localidad
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="tipos_localidad-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      tipos_localidad_table.ajax.url("{{route('tipos_localidad.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/tipos_localidad/index.js')}}"></script>
  <script src="{{asset('js/tipos_localidad/create.js')}}"></script>
  <script src="{{asset('js/tipos_localidad/edit.js')}}"></script>
@endpush