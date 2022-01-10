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
}, "El nombre de la categoria ya está registrado en el sistema");

var validator = $("#CategoriaMenuForm").validate({
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
function BorrarFormularioCategoriaMenu() {
    $("#CategoriaMenuForm :input").each(function () {
        $(this).val('');
	});
	$('#roles').val('');
	$('#roles').change();
};

$("#ButtonCategoriaMenuModal").click(function(event) {
	event.preventDefault();
	if ($('#CategoriaMenuForm').valid()) {
		saveModal();
	} else {
		validator.focusInvalid();
	}
});

function saveModal(button) {	
	$('.loader').fadeIn();
	var formData = $("#CategoriaMenuForm").serialize();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCategoriaMenu').val()},
		url: urlActual+"/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalCategoriaMenu').modal("hide");
			categorias_menus_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Categoria de Menú Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#CategoriaMenuForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

if(window.location.hash === '#create')
	{
		$('#modalCategoriaMenu').modal('show');
	}

	$('#modalCategoriaMenu').on('hide.bs.modal', function(){
		$("#CategoriaMenuForm").validate().resetForm();
		document.getElementById("CategoriaMenuForm").reset();
		window.location.hash = '#';
	});

	$('#modalCategoriaMenu').on('shown.bs.modal', function(){
		window.location.hash = '#create';

	}); 