$(document).ready(function() {

	$(document).on("keypress", 'form', function (e) {
		var code = e.keyCode || e.which;
		if (code == 13) {
			e.preventDefault();
			return false;
		}
	});
});

/*function ComprobarDatos() {
    var serie = $("#seriee ").val();
	var inicio = $("#inicioe").val();
	var fin = $("#fine").val();
	var serie_id = $("#serie_id").val();

    $.ajax({
        type: "GET",
        async: false,
        url: APP_URL+"/series/rangoDisponible-edit",
        data: {"serie" : serie, "inicio" : inicio, "fin" : fin, "serie_id" : serie_id}, 
        dataType: "json",
        success: function(result) {
            if (result == true){
                $("input[name='inicio'] ").after("<label class='error'>El rango ingresado es menor al de la ultima resolución</label>");
				$('#ButtonSerieModalUpdate').attr("disabled", true);
            }
            else{
                $('#ButtonSerieModalUpdate').attr("disabled", false);
                $(".error").remove();
            }
        }
    });
}

$("#inicioe").focusout(function () {
    ComprobarDatos();
});*/


$.validator.addMethod("rangoUnicoEdit", function(value, element) {
	var valid = false;
	var serie = $("#seriee ").val();
	var inicio = $("#inicioe").val();
	var fin = $("#fine").val();
	var serie_id = $("#serie_id").val();

	$.ajax({
		type: "GET",
		async: false,
		url: APP_URL+"/series/rangoDisponible-edit",
		data: {"serie" : serie, "inicio" : inicio, "fin" : fin, "serie_id" : serie_id}, 
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El rango ingresado es menor al de la última resolución");

$.validator.addMethod("finMayorEdit", function(value, element) {

	var valid = false;
	var inicio = $("#inicioe").val();
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

var validator = $("#SerieUpdateForm").validate({
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
			rangoUnicoEdit: true
		},
		fin:{
			required : true,
			finMayorEdit: true
		},
		fecha_resolucion:{
			required: true
		},
		fecha_vencimiento:{
			required: true
		},

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
		},
	}
});

$('#modalUpdateSerie').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var serie = button.data('serie');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='serie']").val(serie);
	modal.find(".modal-body input[name='fecha_vencimiento']").val(button.data('fecha_vencimiento'));
	modal.find(".modal-body input[name='fecha_resolucion']").val(button.data('fecha_resolucion'));
	modal.find(".modal-body input[name='inicio']").val(button.data('inicio'));
	modal.find(".modal-body input[name='fin']").val(button.data('fin'));
	modal.find(".modal-body input[name='resolucion']").val(button.data('resolucion'));
 }); 

function BorrarFormularioUpdate() {
    $("#SerieUpdateForm :input").each(function () {
		$(this).val('');
		$('#ButtonSerieModalUpdate').attr("disabled", false);
	});
};

$("#ButtonSerieModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#SerieUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#SerieUpdateForm").serialize();
	var id = $("input[name='id']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenSerieEdit').val()},
		url: APP_URL+"/series/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateSerie').modal("hide");
			series_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Serie Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			alert('Ocurrio un problema, Contacte al Administrador!');
		}
		
	});
}

if(window.location.hash === '#edit')
{
	$('#modalUpdateSerie').modal('show');
}

$('#modalUpdateSerie').on('hide.bs.modal', function(){
	$("#SerieUpdateForm").validate().resetForm();
	document.getElementById("SerieUpdateForm").reset();
	window.location.hash = '#';
});

$('#modalUpdateSerie').on('shown.bs.modal', function(){
	window.location.hash = '#edit';

}); 
	   



