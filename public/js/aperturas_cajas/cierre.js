
var validator = $("#CierreForm").validate({
	ignore: [],
	onkeyup:false,
    onclick: false,
    //onfocusout: false,
	rules: {
		efectivo:{
			required: true
		},
		password_admin_cierre:{
			required: true
		}

	},
	messages: {
		efectivo: {
			required: "Por favor, ingrese efectivo",
			min: "El valor ingresado debe ser igual o mayor a 0"
		},
		password_admin_cierre: {
			required: "Por favor, ingrese contraseña"
		}
	}
});

function BorrarFormularioCierre() {
    $("#CierreForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCierreModal").click(function(event) {
	event.preventDefault();
	if ($('#CierreForm').valid()) {
		saveCierre();
	} else {
		validator.focusInvalid();
	}
});

var id;
$('#modalCierre').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	id = button.data('id');

	var modal = $(this);

	$.ajax({
		type: "GET",
		headers: {'X-CSRF-TOKEN': $('#tokenCierre').val()},
		url: APP_URL+"/aperturas_cajas/get",
		data: {'id':id},
		dataType: "json",
		success: function(data) {
			modal.find(".modal-body input[name='monto']").val(data.monto);
			modal.find(".modal-body input[name='monto_cierre']").val(data.monto_cierre);
			modal.find(".modal-body input[name='apertura_id']").val(data.id);
			modal.find(".modal-body input[name='nombre_cajero']").val(data.user_cajero.name);
			//$("#user_cajero_id option[value='"+data.user_cajero_id+"']").attr("selected", true);
		

			//sobrante o faltante
			modal.find(".modal-body input[name='efectivo']").on('keyup', function(){
				var efectivo = modal.find(".modal-body input[name='efectivo']").val();
				if(efectivo ==""){
					efectivo = 0;
				}
				efectivo = parseFloat(efectivo);
				var monto_cierre = data.monto_cierre;
				monto_cierre = parseFloat(monto_cierre);
				
				var diferencia = efectivo - monto_cierre;
				if(diferencia >= 0 ){
					modal.find(".modal-body input[name='sobrante']").val(diferencia);
					modal.find(".modal-body input[name='faltante']").val(0);
				}
				else{
					modal.find(".modal-body input[name='sobrante']").val(0);
					modal.find(".modal-body input[name='faltante']").val(diferencia);
				}
			}).keyup();
		},
		error: function(errors) {
			alert('Ocurrio un error, Contacte al administrador');
		}
		
	});

	modal.find(".modal-body input[name='caja_id']").val(id);
 }); 

function saveCierre(button) {
	$('.loader').fadeIn();
	var apertura_id = $("#modalCierre input[name='apertura_id']").val();
	var sobrante = $("#modalCierre input[name='sobrante']").val();
	var faltante = $("#modalCierre input[name='faltante']").val();
	var efectivo = $("#modalCierre input[name='efectivo']").val();
	var monto_cierre = $("#modalCierre input[name='monto_cierre']").val();
	var password_admin_cierre = $("#modalCierre input[name='password_admin_cierre']").val();

	var formData = {apertura_id : apertura_id, efectivo: efectivo, sobrante: sobrante, faltante: faltante, password_admin_cierre: password_admin_cierre, caja_id: id, monto_cierre:monto_cierre};	
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCierre').val()},
		url: APP_URL+"/aperturas_cajas/cierre",
		data: formData,
		dataType: "json",
		statusCode: {
			403: function (xhr) {
				$('.loader').fadeOut(225);
				alertify.set('notifier','position', 'top-center');
				alertify.error('El usuario no tiene permisos para realizar esta acción');
			}
		},
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalCierre').modal("hide");
			cajas_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Caja Cerrada con Éxito!!');
			cargarSelectUserApertura();
			
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.password_admin_cierre != null) {
				$("#CierreForm input[name='password_admin_cierre'] ").after("<label class='error' id='ErrorPasswordAdmin'>"+errors.password_admin_cierre+"</label>");
			}
			else{
				$("#ErrorPasswordAdmin").remove();
			}
		}
		
	});
}

if(window.location.hash === '#cierre')
	{
		$('#modalCierre').modal('show');
	}

	$('#modalCierre').on('hide.bs.modal', function(){
		$("#CierreForm").validate().resetForm();
		document.getElementById("CierreForm").reset();
		window.location.hash = '#';
		//BorrarFormularioCierre();
	});

	$('#modalCierre').on('shown.bs.modal', function(){
		window.location.hash = '#cierre';

	}); 