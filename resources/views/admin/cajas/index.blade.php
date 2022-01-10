@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Cajas
      <small>Todas las cajas</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Cajas</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.cajas.createModal')
@include('admin.cajas.editModal')
@include('admin.aperturas_cajas.aperturaModal')
@include('admin.aperturas_cajas.cierreModal')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#modalCaja">
        <i class="fa fa-plus"></i>Agregar Caja
      </button>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="cajas-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
    cajas_table.ajax.url("{{route('cajas.getJson')}}").load();
  });

  function confirmarAccion(button) {
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
    //var id = $("#idConfirmacion").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
    //url: "/cajas/" + id + "/delete",
    url: "{{route('cajas.delete')}}",
		data: formData,
		dataType: "json",
		success: function(data) {
      $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			cajas_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Caja se Desactivó Correctamente!!');
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

  <script src="{{asset('js/cajas/index.js')}}"></script>
  <script src="{{asset('js/cajas/create.js')}}"></script>
  <script src="{{asset('js/cajas/edit.js')}}"></script>
  <script src="{{asset('js/aperturas_cajas/apertura.js')}}"></script>
  <script src="{{asset('js/aperturas_cajas/cierre.js')}}"></script>
@endpush