$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

$.validator.addMethod("rangoUnico", function(value, element) {
	var valid = false;
	var serie = $("input[name='serie'] ").val();
	var inicio = $("input[name='inicio'] ").val();
	var fin = $("input[name='fin']").val();

	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/series/rangoDisponible",
		data: {"serie" : serie, "inicio" : inicio, "fin" : fin}, 
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El rango ingresado es menor al de la última resolución");

$.validator.addMethod("finMayor", function(value, element) {
	var valid = false;
	var inicio = $("input[name='inicio'] ").val();
	inicio = parseInt(inicio);
	value = parseInt(value);

	if (value > inicio )
	{
		valid = true;
		return valid;
	}

	else{
		return valid;
	}
	
}, "El número ingresado debe ser mayor al de inicio");

$.validator.addMethod("regx", function(value, element, regexpr) {          
    return regexpr.test(value);
}, "No se pueden ingresar valores negativos");

var validator = $("#SerieForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		resolucion:{
			required: true,
			regx: /^([a-zA-Z0-9]*)$/

		},
		serie: {
			required : true
		},
		inicio:{
			required: true,
			rangoUnico: true
		},
		fin:{
			required : true,
			finMayor : true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		}

	},
	messages: {
		resolucion:{
			required: "Debe ingresar El Número de Resolución",
		},
		serie: {
			required : "Debe Ingresar La Serie"
		},
		inicio:{
			required: "Debe Ingresar un número de Inicio"
		},
		fin:{
			required : "Debe Ingresar un número de Fin"
		},
		fecha_resolucion:{
			required: "ingrese La Fecha de Autorizacion de Resolución"
		},
		fecha_vencimiento:{
			required: "Seleccione La Fecha de Vencimiento"
		}
	

	}
});
function BorrarFormularioSerie() {
    $("#SerieForm :input").each(function () {
        $(this).val('');
	});
};


$("#ButtonSerieModal").click(function(event) {
	event.preventDefault();
	if ($('#SerieForm').valid()) {
		saveContact();
	} else {
		validator.focusInvalid();
	}
});

function saveContact(button) {
	$('.loader').fadeIn();
	var formData = $("#SerieForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenSerie').val()},
		url: APP_URL+"/series/save",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalSerie').modal("hide");
			series_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Serie Creada con Éxito!!');
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			alert('Ocurrio un problema, Contacte al Administrador!');
		},
		always: function() {

		},
	
		
	});
}

if(window.location.hash === '#create')
{
	$('#modalSerie').modal('show');
}

$('#modalSerie').on('hide.bs.modal', function(){
	$("#SerieForm").validate().resetForm();
	document.getElementById("SerieForm").reset();
	window.location.hash = '#';
});

$('#modalSerie').on('shown.bs.modal', function(){
	window.location.hash = '#create';

}); 