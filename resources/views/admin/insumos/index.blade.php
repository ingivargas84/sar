@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Insumos
      <small>Todos los insumos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Insumos</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a href="{{route('insumos.new')}}" class="btn btn-primary pull-right">
        <i class="fa fa-plus"></i>Agregar Insumo
      </a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="insumos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      insumos_table.ajax.url("{{route('insumos.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/insumos/index.js')}}"></script>
@endpush