$.validator.addMethod("nombreUnicoEdit", function(value, element) {
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

var validator = $("#UnidadMedidaUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnicoEdit : true
		},
		abreviatura:{
			required: true
		},
		descripcion:{
			required: true,
			maxlength: 30
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		abreviatura: {
			required: "Por favor, ingrese abreviatura"
		},
		descripcion: {
			required: "Por favor, ingrese descripción",
			maxlength: "Por favor, no ingrese mas de 30 carácteres"
		}
	}
});

$('#modalUpdateUnidadMedida').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	var abreviatura = button.data('abreviatura');
	var descripcion = button.data('descripcion');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);
	modal.find(".modal-body input[name='abreviatura']").val(abreviatura);
	modal.find(".modal-body input[name='descripcion']").val(descripcion);


 }); 

function BorrarFormularioUpdate() {
    $("#UnidadMedidaUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonUnidadMedidaModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#UnidadMedidaUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#UnidadMedidaUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenUnidadMedidaEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateUnidadMedida').modal("hide");
			unidades_medida_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Unidad de Medida Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#UnidadMedidaUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateUnidadMedida').modal('show');
	}

	$('#modalUpdateUnidadMedida').on('hide.bs.modal', function(){
		$("#UnidadMedidaUpdateForm").validate().resetForm();
		document.getElementById("UnidadMedidaUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateUnidadMedida').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

}); 
	   




