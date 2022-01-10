@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Series
      <small>Todos los puestos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Series</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.series.createModal')
@include('admin.series.editModal')
@include('admin.users.confirmarAccionModal')
@include('admin.series.EstadoModal')
<div class="loader loader-bar is-active"></div>

<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalSerie">
        <i class="fa fa-plus"></i>Agregar Serie
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="series-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  ellspacing="0" width="100%" >            
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
  </script>
  <script src="{{asset('js/series/index.js')}}"></script>
  <script src="{{asset('js/series/create.js')}}"></script>
  <script src="{{asset('js/series/edit.js')}}"></script>
  <script src="{{asset('js/series/estado.js')}}"></script>
@endpush