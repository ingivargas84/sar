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
}, "El nombre de localidad ya está registrado en el sistema");

var validator = $("#LocalidadForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		},
		tipo_localidad_id:{
			required: true
		},


	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		tipo_localidad_id: {
			required: "Por favor, seleccione tipo de localidad"
		}
	}
});
function BorrarFormularioLocalidad() {
    $("#LocalidadForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonLocalidadModal").click(function(event) {
	event.preventDefault();
	if ($('#LocalidadForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').fadeIn();	
	var formData = $("#LocalidadForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenLocalidad').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalLocalidad').modal("hide");
			localidades_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Localidad Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#LocalidadForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalLocalidad').modal('show');
	}

	$('#modalLocalidad').on('hide.bs.modal', function(){
		$("#LocalidadForm").validate().resetForm();
		document.getElementById("LocalidadForm").reset();
		window.location.hash = '#';
	});

	$('#modalLocalidad').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 