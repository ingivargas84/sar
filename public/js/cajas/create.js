var validator = $("#CajaForm").validate({
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
function BorrarFormularioCaja() {
    $("#CajaForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCajaModal").click(function(event) {
	event.preventDefault();
	if ($('#CajaForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});


if(window.location.hash === '#create')
	{
		$('#modalCaja').modal('show');
	}

	$('#modalCaja').on('hide.bs.modal', function(){
		$("#CajaForm").validate().resetForm();
		document.getElementById("CajaForm").reset();
		window.location.hash = '#';
		//$("label.error").remove();
		//BorrarFormularioCaja();
	});

	$('#modalCaja').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 