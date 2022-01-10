$(document).ready(function() {
	$('.loader').removeClass('is-active');
});
var validator = $("#CompraDetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		insumo_id:{
			required: true
		},
		cantidad:{
			required: true
		},
		precio:{
			required: true
		}

	},
	messages: {
		insumo_id: {
			required: "Por favor, seleccione insumo"
		},
		cantidad: {
			required: "Por favor, ingrese cantidad",
			min: "El valor ingresado debe ser mayor o igual a 1"
		},
		precio: {
			required: "Por favor, ingrese precio",
			min: "El valor ingresado debe ser mayor o igual a 0"
		}
	}
});

$('body').on('click', 'a.editar-detalle', function(e) {
	e.preventDefault();
	$('.loader').addClass("is-active");
	$('.loader').fadeIn();
	//var id = $(this).parent().parent().attr("id");
});

$('#modalUpdateCompraDetalle').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
    var insumo_id = button.data('insumo_id');
    var unidad_medida_id = button.data('unidad_medida_id');
	var cantidad = button.data('cantidad');
	var precio = button.data('precio');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='cantidad']").val(cantidad);
	modal.find(".modal-body input[name='precio']").val(precio);
    //modal.find(".modal-body select[name='unidad_medida_id']").val(unidad_medida_id);
	//console.log(unidad_medida_id);
	var compra_id = $('#compra').text();
	cargarSelectInsumo(insumo_id, compra_id);

 });

function BorrarFormularioUpdate() {
    $("#CompraDetalleUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCompraDetalleModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#CompraDetalleUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#CompraDetalleUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var compra_id = $('#receta').text();
	//var urlActual =  $("input[name='urlActual']").val();
	//var urlNueva = urlActual.replace("/"+compra_id, "");
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenCompraDetalleEdit').val()},
		url: APP_URL+"/compras/detalle/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateCompraDetalle').modal("hide");
			comprasdetalle_table.ajax.reload();
			$("#total_nuevo").empty();
			$("#total_nuevo").text(data.total_nuevo.toFixed(2));
			alertify.set('notifier','position', 'top-center');
			alertify.success('Detalle Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			alert('Ocurrio un error, Contacte al Administrador!')
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateCompraDetalle').modal('show');
	}

	$('#modalUpdateCompraDetalle').on('hide.bs.modal', function(){
		$("#CompraDetalleUpdateForm").validate().resetForm();
		document.getElementById("CompraDetalleUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateCompraDetalle').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

	}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




