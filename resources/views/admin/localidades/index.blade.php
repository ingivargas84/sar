@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Localidades
      <small>Todas las localidades</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Localidades</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.localidades.createModal')
@include('admin.localidades.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalLocalidad">
        <i class="fa fa-plus"></i>Agregar Localidad
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="localidades-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      localidades_table.ajax.url("{{route('localidades.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/localidades/index.js')}}"></script>
  <script src="{{asset('js/localidades/create.js')}}"></script>
  <script src="{{asset('js/localidades/edit.js')}}"></script>
@endpush