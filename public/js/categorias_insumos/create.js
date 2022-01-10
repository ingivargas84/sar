var validator = $("#CategoriaInsumoForm").validate({
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
function BorrarFormularioCategoriaInsumo() {
    $("#CategoriaInsumoForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCategoriaInsumoModal").click(function(event) {
	event.preventDefault();
	if ($('#CategoriaInsumoForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});



if(window.location.hash === '#create')
	{
		$('#modalCategoriaInsumo').modal('show');
	}

	$('#modalCategoriaInsumo').on('hide.bs.modal', function(){
		$("#CategoriaInsumoForm").validate().resetForm();
		document.getElementById("CategoriaInsumoForm").reset();
		window.location.hash = '#';
	});

	$('#modalCategoriaInsumo').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 