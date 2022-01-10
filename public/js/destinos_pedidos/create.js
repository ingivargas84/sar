$.validator.addMethod("destinoUnico", function(value, element) {
	var valid = false;
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/destinoDisponible",
		data: "destino=" + value,
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El destino ya está registrado en el sistema");

var validator = $("#DestinoForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		destino:{
			required: true,
			destinoUnico: true
		}

	},
	messages: {
		destino: {
			required: "Por favor, ingrese destino"
		}
	}
});
function BorrarFormularioDestino() {
    $("#DestinoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonDestinoModal").click(function(event) {
	event.preventDefault();
	if ($('#DestinoForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {	
	var formData = $("#DestinoForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$('.loader').fadeIn();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenDestino').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225)
			$('#modalDestino').modal("hide");
			destinos_pedidos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Destino Creado con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225)
			var errors = JSON.parse(errors.responseText);
			if (errors.destino != null) {
				$("#DestinoForm input[name='destino'] ").after("<label class='error' id='ErrorDestino'>"+errors.destino+"</label>");
			}
			else{
				$("#ErrorDestino").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalDestino').modal('show');
	}

	$('#modalDestino').on('hide.bs.modal', function(){
		$("#DestinoForm").validate().resetForm();
		document.getElementById("DestinoForm").reset();
		window.location.hash = '#';
	});

	$('#modalDestino').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 