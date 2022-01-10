@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Unidades de Medida
      <small>Todas las unidades de medida</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Unidades de Medida</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.unidades_medida.createModal')
@include('admin.unidades_medida.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalUnidadMedida">
        <i class="fa fa-plus"></i>Agregar Unidad de Medida
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="unidades_medida-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      unidades_medida_table.ajax.url("{{route('unidades_medida.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/unidades_medida/index.js')}}"></script>
  <script src="{{asset('js/unidades_medida/create.js')}}"></script>
  <script src="{{asset('js/unidades_medida/edit.js')}}"></script>
@endpush