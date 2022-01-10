$.validator.addMethod("tipolocalidadUnico", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/tipolocalidadDisponibleEdit",
		data: {"nombre" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre del tipo de localidad ya está registrado en el sistema");

var validator = $("#TipoLocalidadUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			tipolocalidadUnico : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});

$('#modalUpdateTipoLocalidad').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var columnas = button.data('columnas');
	var filas = button.data('filas');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);
	modal.find(".modal-body input[name='columnas']").val(columnas);
	modal.find(".modal-body input[name='filas']").val(filas);

 }); 

function BorrarFormularioUpdate() {
    $("#TipoLocalidadUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoLocalidadModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#TipoLocalidadUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#TipoLocalidadUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoLocalidadEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateTipoLocalidad').modal("hide");
			tipos_localidad_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Localidad Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#TipoLocalidadUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateTipoLocalidad').modal('show');
	}

	$('#modalUpdateTipoLocalidad').on('hide.bs.modal', function(){
		$("#TipoLocalidadUpdateForm").validate().resetForm();
		document.getElementById("TipoLocalidadUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateTipoLocalidad').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

}); 


/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




