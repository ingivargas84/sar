var columnas  = $("input[name='numero_columnas']").val();
$(".contenedor").css("grid-template-columns", "repeat("+columnas+", 1fr)");

/*$(window).resize(function(){     

  if ($('header').width() <= 640 ){

    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 6.4rem)");  
  }
  else if($('header').width() > 640 && $('header').width() <= 1024){
    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 11.5rem)");  
  }
  else if($('header').width() > 1024){
    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 15.5rem)");
  }

});*/
var datos;
var id;
function nuevaOrden(id, ocupada)
{
  if(ocupada == 1){
      $.ajax({ 
          type: "GET",
          url: APP_URL+"/ordenes_maestro/actual",
          data: {'id': id},
          dataType: "json",
          success: function(data) {
              //$('.loader').fadeOut(225);
            if(data == ""){
              alertify.alert('Alerta', 'La mesa esta ocupada con otro pedido!');
            }else{
              window.location = APP_URL+"/ordenes_maestro/"+data[0].id+"/edit"
            }
          },
          error: function() {
              //$('.loader').fadeOut(225);
              alert("Ocurrio un error Contacte al Administrador!");
          }
      });
  }else{

    $.ajax({ 
        type: "POST",
        url: APP_URL+"/ordenes_maestro/save",
        data: {'id': id},
        dataType: "json",
        success: function(data) {
            //$('.loader').fadeOut(225);
            if (data.success == "ok") {
                window.location = APP_URL+"/ordenes_maestro/"+data.orden_maestro_id+"/edit"
            }
        },
        error: function() {
            //$('.loader').fadeOut(225);
            alert("Ocurrio un error Contacte al Administrador!");
        }
    });
    
  }
}

function existeOrden(datos, id){
  $.ajax({
    async: false, 
    type: "GET",
    url: APP_URL+"/ordenes_maestro/actual",
    data: {'id': id},
    dataType: "json",
    success: function(data){
      datos = data
    },
    error: function() {
        //$('.loader').fadeOut(225);
        alert("Ocurrio un error Contacte al Administrador!");
    }
  });
  return datos;
}

$(".liberar").click(function(){
   id = $(this).parent().data("mesa_id");
   datos = existeOrden(datos, id);
  if (datos !="")
  {
    $("#modalConfirmarAccion").modal('show');

  }else{
    $.ajax({
      async: false, 
      type: "GET",
      url: APP_URL+"/localidades/"+id+"/liberar",
      data: {'id': id},
      dataType: "json",
      success: function(data){
        location.reload();
      },
      error: function() {
          //$('.loader').fadeOut(225);
          alert("Ocurrio un error Contacte al Administrador!");
      }
    });
  }
   
});


$("#btnConfirmarAccion").click(function(event) {
  event.preventDefault();
if ($('#ConfirmarAccionForm').valid()) {
  confirmarAccion();
} else {
  validator.focusInvalid();
}
});

function confirmarAccion(button) {
  //$('.loader').fadeIn();	
  var formData = $("#ConfirmarAccionForm").serialize();
$.ajax({
  type: "GET",
  headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
  url: APP_URL+"/localidades/"+id+"/liberarSeguro",
  data: formData,
  dataType: "json",
  success: function(data) {
    //$('.loader').fadeOut(225);
    $('#modalConfirmarAccion').modal("hide");
    location.reload();    
    //alertify.set('notifier','position', 'top-center');
    //alertify.success('La Localidad se Desactivó Correctamente!!');
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


//Cambiar orden de mes

if(window.location.hash === '#cambiarOrden')
	{
		$('#modalCambiarOrden').modal('show');
	}

	$('#modalCambiarOrden').on('hide.bs.modal', function(){
		$("#CambiarOrdenForm").validate().resetForm();
		document.getElementById("CambiarOrdenForm").reset();
		window.location.hash = '#';
	});

	$('#modalCambiarOrden').on('shown.bs.modal', function(){
		window.location.hash = '#cambiarOrden';

}); 

$('#modalCambiarOrden').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	
	var modal = $(this);
	modal.find(".modal-body input[name='mesa_inicio']").val(id);

 });
 

var validator = $("#CambiarOrdenForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		mesa_id:{
			required: true
		},
	},
	messages: {
		mesa_id: {
			required: "Por favor, seleccione mesa"
		}
	}
});

$("#ButtonCambiarOrdenModal").click(function(event) {
  event.preventDefault();
if ($('#CambiarOrdenForm').valid()) {
  cambiarOrden();
} else {
  validator.focusInvalid();
}
});

function cambiarOrden(button) {
	//$('.loader').fadeIn();
  var mesa_inicio = $("input[name='mesa_inicio']").val();
  var mesa_destino = $("#mesa_id").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCambiarOrden').val()},
		url: APP_URL+"/ordenes_maestro/cambiarMesa",
		data: {'mesa_inicio': mesa_inicio, 'mesa_destino': mesa_destino},
		dataType: "json",
		success: function(data) {
			//$('.loader').fadeOut(225);
      $('#modalCambiarOrden').modal("hide");
      location.reload();
			//alertify.set('notifier','position', 'top-center');
			//alertify.success('Tipo de Localidad Editado con Éxito!!');
		},
		error: function(errors) {
      //$('.loader').fadeOut(225);
      alertify.alert("Ocurrio un error Contacte al Administrador!");
		}
		
	});
}

  function cargarMesaCambioOrden(){
    $('#mesa_id').empty();
    $("#mesa_id").append('<option value="" selected>Seleccione Mesa</option>');
    var tipo_localidad = $("input[name='tipo_localidad']").val();
      $.ajax({
        type: "GET",
        data: {'tipo_localidad': tipo_localidad},
        url: APP_URL+"/localidades/cargarMesaCambioOrden/", 
        dataType: "json",
        success: function(data){
          $.each(data,function(key, registro) {
            $("#mesa_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');	
          });
        },
        error: function(data) {
          alert('error');
        }
        });		
  }

  cargarMesaCambioOrden();