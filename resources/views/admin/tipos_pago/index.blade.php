@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Tipos de Pago
      <small>Todos los tipos de pago</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Tipos de Pago</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.tipos_pago.createModal')
@include('admin.tipos_pago.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalTipoPago">
        <i class="fa fa-plus"></i>Agregar Tipo de Pago
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="tipos_pago-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      tipos_pago_table.ajax.url("{{route('tipos_pago.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/tipos_pago/index.js')}}"></script>
  <script src="{{asset('js/tipos_pago/create.js')}}"></script>
  <script src="{{asset('js/tipos_pago/edit.js')}}"></script>
@endpush