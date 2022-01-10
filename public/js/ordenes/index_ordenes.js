//Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
		confirmarAccion();
	} else {
		validator.focusInvalid();
	}
});


function confirmarAccion(button) {	
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    $('.loader').fadeIn();
	$.ajax({
		type: "DELETE",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: APP_URL+"/ordenes_maestro/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
            $('*[data-orden_maestro_id="'+id+'"]').remove();
            BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");   
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Orden se elimino Correctamente!!');
		},
		error: function(errors) {
            $('.loader').fadeOut(225);
            if(errors.responseText !=""){
                var errors = JSON.parse(errors.responseText);
                if (errors.password_actual != null) {
                    $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
                }
                else{
                    $("#ErrorPassword_actual").remove();
                }
            }
            
		}
		
	});
}