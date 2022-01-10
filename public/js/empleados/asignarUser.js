var validator = $("#AsignaForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		usuarios:{
			required: true
		}

	},
	messages: {
		usuarios: {
			required: "Por favor, Seleccione un usuario"
		}
	}
});

$('#modalAsignaUser').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var user_id = button.data('user_id');

	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='user_id']").val(user_id);

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
	var id = $("input[name='id']").val();
	var urlActual = $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenUserEdit').val()},
		url: urlActual+"/"+id+"/asignaruser",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			BorrarAsignar();
			$('#modalAsignaUser').modal("hide");
			empleados_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
            alertify.success('Usuario Asignado Éxitosamente!');
            cargarSelectUser();
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
            alert('Ocurrio un problema, Contacte al administrador!')
		}
		
	});
}

    
    cargarSelectUser();

if(window.location.hash === '#asignar')
       {
         $('#modalAsignaUser').modal('show');
       }
    
       $('#modalAsignaUser').on('hide.bs.modal', function(){
          window.location.hash = '#';
    
       });
    
       $('#modalAsignaUser').on('shown.bs.modal', function(){
          window.location.hash = '#asignar';
    
	   }); 
	   





