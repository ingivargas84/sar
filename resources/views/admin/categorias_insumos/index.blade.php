@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Categorias
      <small>Todos las Categorias</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Categorias</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.categorias_insumos.createModal')
@include('admin.categorias_insumos.editModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCategoriaInsumo">
        <i class="fa fa-plus"></i>Agregar Categoria
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="categorias_insumos-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
        </table>
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')

  <script>
  $(document).ready(function() {
    $('.loader').fadeOut(225);
    categorias_insumos_table.ajax.url("{{route('categorias_insumos.getJson')}}").load();
  });

  function confirmarAccion(button) {
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: "{{route('categorias_insumos.delete')}}",
		data: formData,
		dataType: "json",
		success: function(data) {
      $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			categorias_insumos_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Categoria de Insumo se Desactivó Correctamente!!');
		},
		error: function(errors) {
      $('.loader').fadeOut(225);
      if(errors.responseText !=""){
          var errors = JSON.parse(errors.responseText);
          if (errors.password_actual != null) {
              $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
          }
          else{
              $("#ErrorPassword_actual").remove();
          }
      }    
		}
		
	});
}
  
  </script>
 
 
@endpush

@push('scripts')
  <script src="{{asset('js/categorias_insumos/index.js')}}"></script>
  <script src="{{asset('js/categorias_insumos/create.js')}}"></script>
  <script src="{{asset('js/categorias_insumos/edit.js')}}"></script>
@endpush