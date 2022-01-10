@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Listado de Empleados
      <small>Todos los empleados</small>
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li class="active">Empleados</li>
    </ol>
  </section>

  @endsection

@section('content')
@include('admin.empleados.asignaUserModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <a class="btn btn-primary pull-right" href="{{route('empleados.new')}}">
        <i class="fa fa-plus"></i>Agregar Empleado</a>
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">
        <table id="empleados-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap"  width="100%">            
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
      empleados_table.ajax.url("{{route('empleados.getJson')}}").load();
    });

  //Desactivar Empleado
    $(document).on('click', 'a.remove-empleado', function(e) {
      e.preventDefault(); // does not go through with the link.

      var $this = $(this);
      
      alertify.confirm('Desactivar Empleado', 'Esta seguro de desactivar el empleado', 
          function(){
              $('.loader').fadeIn();
              var id = $this.data('id');
              $.post({
                  type: 'DELETE',
                  //url: $this.attr('href'),
                  url: "{{route('empleados.delete')}}",
                  data: {'id':id},
              }).done(function (data) {
                $('.loader').fadeOut(225);
                  empleados_table.ajax.reload();
                      alertify.set('notifier','position', 'top-center');
                      alertify.success('Empleado Desactivado con Éxito!!');
              }); 
          }
          , function(){
              alertify.set('notifier','position', 'top-center'); 
              alertify.error('Cancel')
          });   
    });


    //Asignar usuario
    function cargarSelectUser(){
    $('#usuarios_id').empty();
    $("#usuarios_id").append('<option value="" selected>Seleccione Usuario</option>');
    var user_id = $("input[name='user_id']").val();
    $.ajax({
      type: "GET",
      url: "{{route('users.cargar')}}", 
      dataType: "json",
      data: "user_id=" + user_id,
      success: function(data){
        $.each(data,function(key, registro) {
          if(registro.id == user_id){
          $("#usuarios_id").append('<option value='+registro.id+' selected>'+registro.name+'</option>');
          
          }else{
          $("#usuarios_id").append('<option value='+registro.id+'>'+registro.name+'</option>');
          }	

          console.log(registro.id);
        });
    
      },
      error: function(data) {
        alert('error');
      }
      });
      }
 

  </script>
  <script src="{{asset('js/empleados/index.js')}}"></script>
  <script src="{{asset('js/empleados/asignarUser.js')}}"></script>
@endpush