@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Movimientos de Caja
      <small>Todos los Movimientos</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('cajas.index')}}"><i class="fa fa-eye"></i> Cajas</a></li>
      <li class="active">Movimientos</li>
    </ol>
  </section>

  @endsection

@section('content')
<div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="movimientos_cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
    movimientos_cajas_table.ajax.url("{{route('cajas.getJsonDetalle', $caja->id)}}").load();
  });

</script>

  <script src="{{asset('js/cajas/show.js')}}"></script>
@endpush