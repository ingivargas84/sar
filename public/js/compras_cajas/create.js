var validator = $("#CompraCajaForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
	//onfocusout: false,
	
	rules: {
		caja_id:{
			required: true,
		},
		documento:{
			required: true,
		},
		numero_doc:{
			required: true,
		},
		descripcion:{
			required: true,
		},
		total:{
			required: true,
		}

	},
	messages: {
		caja_id: {
			required: "Por favor, seleccione caja"
		},
		documento: {
			required: "Por favor, ingrese documento"
		},
		numero_doc: {
			required: "Por favor, ingrese número de documento"
		},
		descripcion: {
			required: "Por favor, ingrese descripción"
		},
		total: {
			required: "Por favor, ingrese total",
			min: "El valor ingresado debe ser mayor o igual a 0"
		}
	}
});
function BorrarFormularioCompraCaja() {
    $("#CompraCajaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCompraCajaModal").click(function(event) {
	event.preventDefault();
	if ($('#CompraCajaForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {
	$('.loader').fadeIn();	
	var formData = $("#CompraCajaForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCompraCaja').val()},
		url: APP_URL+"/compras_cajas/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalCompraCaja').modal("hide");
			compras_cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Compra registrada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			/*var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#CompraCajaForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}*/
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalCompraCaja').modal('show');
	}

	$('#modalCompraCaja').on('hide.bs.modal', function(){
		$("#CompraCajaForm").validate().resetForm();
		document.getElementById("CompraCajaForm").reset();
		window.location.hash = '#';
	});

	$('#modalCompraCaja').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 