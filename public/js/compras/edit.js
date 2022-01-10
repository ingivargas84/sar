
var validator = $("#CompraUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		serie:{
			required: true
		},
		numero_doc:{
			required: true
		}

	},
	messages: {
		serie: {
			required: "Por favor, ingrese serie"
		},
		numero_doc: {
			required: "Por favor, ingrese número de documento"
		}
	}
});

var id;

$('#modalUpdateCompra').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	id = button.data('id');
	var serie = button.data('serie');
	var numero_doc = button.data('numero_doc');
	var fecha_factura = button.data('fecha_factura');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='serie']").val(serie);
	modal.find(".modal-body input[name='numero_doc']").val(numero_doc);
	modal.find(".modal-body input[name='fecha_factura']").val(fecha_factura);

 }); 

function BorrarFormularioUpdate() {
    $("#CompraUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCompraModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#CompraUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#CompraUpdateForm").serialize();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenCompraEdit').val()},
		url: APP_URL+"/compras/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateCompra').modal("hide");
			compras_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Compra Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			alert('Contacte al Administrador!!')
			/*var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#CompraUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}*/
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateCompra').modal('show');
	}

	$('#modalUpdateCompra').on('hide.bs.modal', function(){
		window.location.hash = '#';
		$("label.error").remove();
		BorrarFormularioUpdate();
	});

	$('#modalUpdateCompra').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

	}); 



