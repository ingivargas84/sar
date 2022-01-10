$.validator.addMethod("nombreUnicoTipoPago", function(value, element) {
	var valid = false;
	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/tipos_pago/nombreDisponible",
		data: "nombre=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre del tipo de pago ya está registrado en el sistema");

var validator = $("#TipoPagoForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnicoTipoPago: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});
function BorrarFormularioTipoPago() {
    $("#TipoPagoForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoPagoModal").click(function(event) {
	event.preventDefault();
	if ($('#TipoPagoForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').fadeIn();	
	var formData = $("#TipoPagoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoPago').val()},
		url: APP_URL+"/tipos_pago/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalTipoPago').modal("hide");
			tipos_pago_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Pago Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			/*var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#TipoPagoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}*/
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalTipoPago').modal('show');
	}

	$('#modalTipoPago').on('hide.bs.modal', function(){
		$("#TipoPagoForm").validate().resetForm();
		document.getElementById("TipoPagoForm").reset();
		window.location.hash = '#';
		BorrarFormularioTipoPago();
	});

	$('#modalTipoPago').on('shown.bs.modal', function(){
		$("input[name='nombre']").focus();
		window.location.hash = '#create';

	}); 