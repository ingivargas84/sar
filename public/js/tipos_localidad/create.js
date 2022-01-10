$.validator.addMethod("tipolocalidadUnico", function(value, element) {
	var valid = false;
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/tipolocalidadDisponible",
		data: "nombre=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre del tipo de localidad ya está registrado en el sistema");

var validator = $("#TipoLocalidadForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		nombre:{
			required: true,
			tipolocalidadUnico: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});
function BorrarFormularioTipoLocalidad() {
    $("#TipoLocalidadForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonTipoLocalidadModal").click(function(event) {
	event.preventDefault();
	if ($('#TipoLocalidadForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').fadeIn();	
	var formData = $("#TipoLocalidadForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoLocalidad').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalTipoLocalidad').modal("hide");
			tipos_localidad_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Localidad Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#TipoLocalidadForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalTipoLocalidad').modal('show');
	}

	$('#modalTipoLocalidad').on('hide.bs.modal', function(){
		$("#TipoLocalidadForm").validate().resetForm();
		document.getElementById("TipoLocalidadForm").reset();
		window.location.hash = '#';
	});

	$('#modalTipoLocalidad').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 