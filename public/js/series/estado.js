var validator = $("#AsignaForm").validate({
	ignore: [],
	onkeyup:false,
	onclick: false,
	//onfocusout: false,
	rules: {
		estado:{
			required: true
		}

	},
	messages: {
		estado: {
			required: "Por favor, Seleccione un estado"
		}
	}
});
function cargarSelectEstado(){
	$('#estado').empty();
	$("#estado").append('<option value="" selected>Seleccione Estado</option>');
			var estado_id = $("#estado_id").val();
			$.ajax({
				type: "GET",
				url: APP_URL+"/series/cargarselect", 
				dataType: "json",
				success: function(data){
					$.each(data,function(key, registro) {
						if(registro.id == estado_id){
						$("#estado").append('<option value='+registro.id+' selected>'+registro.estado+'</option>');
						
						}else{
						$("#estado").append('<option value='+registro.id+'>'+registro.estado+'</option>');
						}		
					});
			
				},
				error: function(data) {
					alert('error');
				}
				});		

		}


$('#modalEstado').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var estado_id = button.data('estado_id');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='estado_id']").val(estado_id);

	cargarSelectEstado();

 }); 

function BorrarAsignar() {
	$('#usuarios_id').val('');
	$('#usuarios_id').change();
};

$("#btnAsignaModal").click(function(event) {
	event.preventDefault();
	if ($('#AsignaForm').valid()) {
		asignarModal();
	} else {
		validator.focusInvalid();
	}
});

function asignarModal(button) {
	$('.loader').fadeIn();
	var formData = $("#AsignaForm").serialize();
	var id = $("#idestado").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenUserEdit').val()},
		url: APP_URL+"/series/"+id+"/cambiarestado",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalEstado').modal("hide");
			series_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
						alertify.success('Serie Actualizada Éxitosamente!');
						
            cargarSelectEstado();
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
      alert('Ocurrio un problema, Contacte al administrador!')
		}
		
	});
}


    
    cargarSelectEstado();

if(window.location.hash === '#asignar')
	{
		$('#modalEstado').modal('show');
	}

	$('#modalEstado').on('hide.bs.modal', function(){
		$("#AsignaForm").validate().resetForm();
		document.getElementById("AsignaForm").reset();
		window.location.hash = '#';

	});

	$('#modalEstado').on('shown.bs.modal', function(){
		window.location.hash = '#asignar';

	}); 
