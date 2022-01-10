@extends('admin.layoutadmin')

@section('header')
  <section class="content-header">
    <h1>
      Detalle de Receta
      <small>Detalle de receta</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('recetas.index')}}"><i class="fa fa-list"></i> Recetas</a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

@endsection

@section('content')
@include('admin.recetas.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="receta" style="display: none">{{ $receta->id }}</div>
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="recetasdetalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      recetasdetalle_table.ajax.url("{{route('recetas.getJsonDetalle', $receta->id)}}").load();
    });
    
  </script>
  <script src="{{asset('js/recetas/show.js')}}"></script>
  <script src="{{asset('js/recetas/editDetalle.js')}}"></script>
@endpush