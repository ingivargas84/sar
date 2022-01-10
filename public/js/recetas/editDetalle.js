var validator = $("#RecetaDetalleUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		insumo_id:{
			required: true
		},
		cantidad:{
			required: true
		}

	},
	messages: {
		insumo_id: {
			required: "Por favor, seleccione insumo"
		},
		cantidad: {
			required: "Por favor, ingrese cantidad"
		}
	}
});

$('body').on('click', 'a.editar-detalle', function(e) {
	e.preventDefault();
	$('.loader').fadeIn();
	//var id = $(this).parent().parent().attr("id");
});

$('#modalUpdateRecetaDetalle').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
    var insumo_id = button.data('insumo_id');
    var unidad_medida_id = button.data('unidad_medida_id');
    var cantidad = button.data('cantidad');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
    modal.find(".modal-body input[name='cantidad']").val(cantidad);
    //modal.find(".modal-body select[name='unidad_medida_id']").val(unidad_medida_id);
	//console.log(unidad_medida_id);
	var receta_id = $('#receta').text();
	cargarSelectInsumo(insumo_id, receta_id);

 });

function BorrarFormularioUpdate() {
    $("#RecetaDetalleUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonRecetaDetalleModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#RecetaDetalleUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#RecetaDetalleUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var receta_id = $('#receta').text();
	var urlActual =  $("input[name='urlActual']").val();
	var urlNueva = urlActual.replace("/"+receta_id, "");
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenRecetaDetalleEdit').val()},
		url: urlNueva+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateRecetaDetalle').modal("hide");
			recetasdetalle_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Detalle Editado con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#RecetaDetalleUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
       {
         $('#modalUpdateRecetaDetalle').modal('show');
       }
    
       $('#modalUpdateRecetaDetalle').on('hide.bs.modal', function(){
			$("#RecetaDetalleUpdateForm").validate().resetForm();
			document.getElementById("RecetaDetalleUpdateForm").reset();
			window.location.hash = '#';
       });
    
       $('#modalUpdateRecetaDetalle').on('shown.bs.modal', function(){
          window.location.hash = '#edit';
    
	   }); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




