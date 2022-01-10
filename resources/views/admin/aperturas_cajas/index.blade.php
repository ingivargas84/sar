@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Apertura / Cierre de caja
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Apertura / Cierre</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="aperturas_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
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
      aperturas_cajas_table.ajax.url("{{route('aperturas_cajas.getJson')}}").load();
    });
  </script>
  <script src="{{asset('js/aperturas_cajas/index.js')}}"></script>
@endpush