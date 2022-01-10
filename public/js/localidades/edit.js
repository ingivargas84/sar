$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var urlActual =  $("input[name='urlActual']").val();
	var id = $("input[name='id']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/nombreDisponibleEdit",
		data: {"nombre" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El nombre de localidad ya está registrado en el sistema");

var validator = $("#LocalidadUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		},
		tipo_localidad_id:{
			required: true
		},


	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		tipo_localidad_id: {
			required: "Por favor, seleccione tipo de localidad"
		}
	}
});

$('#modalUpdateLocalidad').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var tipo_id = button.data('tipo_id');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);
	modal.find(".modal-body input[name='tipo_id']").val(tipo_id);

	cargarSelectTipoLocalidad();

 }); 


function BorrarFormularioUpdate() {
    $("#LocalidadUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonLocalidadModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#LocalidadUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#LocalidadUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenLocalidadEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateLocalidad').modal("hide");
			localidades_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Localidad Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#LocalidadUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateLocalidad').modal('show');
	}

	$('#modalUpdateLocalidad').on('hide.bs.modal', function(){
		$("#LocalidadUpdateForm").validate().resetForm();
		document.getElementById("LocalidadUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateLocalidad').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

}); 
	
/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




