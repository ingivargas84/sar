$.validator.addMethod("destinoUnico", function(value, element) {
	var valid = false;
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "GET",
		async: false,
		url: urlActual+"/destinoDisponibleEdit",
		data: {"destino" : value, "id" : id},
		dataType: "json",
		success: function(msg) {
			valid = !msg;
		}
	});
	return valid;
}, "El destino ya está registrado en el sistema");

var validator = $("#DestinoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		destino:{
			required: true,
			destinoUnico : true
		}

	},
	messages: {
		destino: {
			required: "Por favor, ingrese destino"
		}
	}
});

$('#modalUpdateDestino').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var destino = button.data('destino');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='destino']").val(destino);

 }); 

function BorrarFormularioUpdate() {
    $("#DestinoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonDestinoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#DestinoUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#DestinoUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenDestinoEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225)
			$('#modalUpdateDestino').modal("hide");
			destinos_pedidos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Destino Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225)
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#DestinoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

	if(window.location.hash === '#edit')
	{
		$('#modalUpdateDestino').modal('show');
	}

	$('#modalUpdateDestino').on('hide.bs.modal', function(){
		$("#DestinoUpdateForm").validate().resetForm();
		document.getElementById("DestinoUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateDestino').on('shown.bs.modal', function(){
			window.location.hash = '#edit';

	}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




