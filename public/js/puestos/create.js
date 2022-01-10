$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponible",
		data: "nombre=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre del puesto ya está registrado en el sistema");

var validator = $("#PuestoForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});
function BorrarFormularioPuesto() {
    $("#PuestoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonPuestoModal").click(function(event) {
	event.preventDefault();
	if ($('#PuestoForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {	
	var formData = $("#PuestoForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$('.loader').fadeIn();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenPuesto').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalPuesto').modal("hide");
			puestos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Puesto Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#PuestoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalPuesto').modal('show');
	}

	$('#modalPuesto').on('hide.bs.modal', function(){
		$("#PuestoForm").validate().resetForm();
		document.getElementById("PuestoForm").reset();
		window.location.hash = '#';
		//BorrarFormularioPuesto();
	});

	$('#modalPuesto').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 