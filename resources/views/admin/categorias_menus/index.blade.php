@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Categorias de Menú
      <small>Todas las Categorias de Menú</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Categorias de Menú</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.categorias_menus.createModal')
@include('admin.categorias_menus.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCategoriaMenu">
        <i class="fa fa-plus"></i>Agregar Categoria
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="categorias_menus-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      categorias_menus_table.ajax.url("{{route('categorias_menus.getJson')}}").load();
    });
  </script>

  <script src="{{asset('js/categorias_menus/index.js')}}"></script>
  <script src="{{asset('js/categorias_menus/create.js')}}"></script>
  <script src="{{asset('js/categorias_menus/edit.js')}}"></script>
@endpush