
var validator = $("#AperturaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		monto:{
			required: true
		},
		user_cajero_id:{
			required: true
		},
		password_admin:{
			required: true
		}

	},
	messages: {
		monto: {
			required: "Por favor, ingrese nombre",
			min: "El valor ingresado debe ser igual o mayor a 0"
		},
		user_cajero_id: {
			required: "Por favor, seleccione cajero"
		},
		password_admin: {
			required: "Por favor, ingrese contraseña"
		}
	}
});
function BorrarFormularioApertura() {
    $("#AperturaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonAperturaModal").click(function(event) {
	event.preventDefault();
	if ($('#AperturaForm').valid()) {
		saveApertura();
	} else {
		validator.focusInvalid();
	}
});

$('#modalApertura').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	
	var modal = $(this);
	modal.find(".modal-body input[name='caja_id']").val(id);
	

 }); 
 cargarSelectUserApertura();

function saveApertura(button) {	
	$('.loader').fadeIn();
	var formData = $("#AperturaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenApertura').val()},
		url: APP_URL+"/aperturas_cajas/apertura",
		data: formData,
		dataType: "json",
		statusCode: {
			403: function (xhr) {
				$('.loader').fadeOut(225);
				//console.log('403 response');
				alertify.set('notifier','position', 'top-center');
				alertify.error('El usuario no tiene permisos para realizar esta acción');
			}
		},
		success: function(data) {
			$('.loader').fadeOut(225);
			//BorrarFormularioApertura();
			$('#modalApertura').modal("hide");
			cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Caja Aperturada con Éxito!!');
			cargarSelectUserApertura();			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.password_admin != null) {
				$("#AperturaForm input[name='password_admin'] ").after("<label class='error' id='ErrorPasswordAdmin'>"+errors.password_admin+"</label>");
			}
			else{
				$("#ErrorPasswordAdmin").remove();
			}
		}
		
	});
}

if(window.location.hash === '#apertura')
	{
		$('#modalApertura').modal('show');
	}

	$('#modalApertura').on('hide.bs.modal', function(){
		$("#AperturaForm").validate().resetForm();
		document.getElementById("AperturaForm").reset();
		window.location.hash = '#';
	});

	$('#modalApertura').on('shown.bs.modal', function(){
		window.location.hash = '#apertura';

	});
	
	
	function cargarSelectUserApertura(){
		$('#user_cajero_id').empty();
		$("#user_cajero_id").append('<option value="" selected disabled>Seleccione Usuario</option>');
		$.ajax({
		  type: "GET",
		  url: APP_URL+"/users/cargarA", 
		  dataType: "json",
		  success: function(data){
			$.each(data,function(key, registro) {	

			  $("#user_cajero_id").append('<option value='+registro.id+'>'+registro.name+'</option>');
			  
			});
		
		  },
		  error: function(data) {
			alert('error');
		  }
		  });
	}