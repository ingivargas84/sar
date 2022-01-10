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
}, "El nombre del tipo de pago ya está registrado en el sistema");

var validator = $("#TipoPagoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		nombre:{
			required: true,
			nombreUnicoEdit : true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});

$('#modalUpdateTipoPago').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#TipoPagoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonTipoPagoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#TipoPagoUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#TipoPagoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenTipoPagoEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateTipoPago').modal("hide");
			tipos_pago_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Tipo de Pago Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			/*var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#TipoPagoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}*/
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateTipoPago').modal('show');
	}

	$('#modalUpdateTipoPago').on('hide.bs.modal', function(){
		$("#TipoPagoUpdateForm").validate().resetForm();
		document.getElementById("TipoPagoUpdateForm").reset();
		window.location.hash = '#';
		BorrarFormularioUpdate();
	});

	$('#modalUpdateTipoPago').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

});


