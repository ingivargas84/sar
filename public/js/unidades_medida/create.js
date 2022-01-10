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
}, "El nombre de la unidad de medida ya está registrado en el sistema");

var validator = $("#UnidadMedidaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		},
		abreviatura:{
			required: true
		},
		descripcion:{
			required: true,
			maxlength: 30
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		abreviatura: {
			required: "Por favor, ingrese abreviatura"
		},
		descripcion: {
			required: "Por favor, ingrese descripción",
			maxlength: "Por favor, no ingrese mas de 30 carácteres"

		}
	}
});
function BorrarFormularioUnidadMedida() {
    $("#UnidadMedidaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonUnidadMedidaModal").click(function(event) {
	event.preventDefault();
	if ($('#UnidadMedidaForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').fadeIn();	
	var formData = $("#UnidadMedidaForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenUnidadMedida').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUnidadMedida').modal("hide");
			unidades_medida_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Unidad de Medida Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#UnidadMedidaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalUnidadMedida').modal('show');
	}

	$('#modalUnidadMedida').on('hide.bs.modal', function(){
		$("#UnidadMedidaForm").validate().resetForm();
		document.getElementById("UnidadMedidaForm").reset();
		window.location.hash = '#';
	});

	$('#modalUnidadMedida').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 