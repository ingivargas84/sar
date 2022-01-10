$.validator.addMethod("nombreUnico", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
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
}, "El nombre del puesto ya está registrado en el sistema");

var validator = $("#PuestoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnico : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});

$('#modalUpdatePuesto').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#PuestoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonPuestoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#PuestoUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	var formData = $("#PuestoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$('.loader').fadeIn();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenPuestoEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			BorrarFormularioUpdate();
			$('#modalUpdatePuesto').modal("hide");
			puestos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Puesto Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#PuestoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdatePuesto').modal('show');
	}

	$('#modalUpdatePuesto').on('hide.bs.modal', function(){
		$("#PuestoUpdateForm").validate().resetForm();
		document.getElementById("PuestoUpdateForm").reset();
		window.location.hash = '#';

	});

	$('#modalUpdatePuesto').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

	}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




