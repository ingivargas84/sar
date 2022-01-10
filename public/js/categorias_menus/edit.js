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
}, "El nombre de la categoria ya está registrado en el sistema");

var validator = $("#CategoriaMenuUpdateForm").validate({
	ignore: [],
	onkeyup:false,
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

$('#modalUpdateCategoriaMenu').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#CategoriaMenuUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCategoriaMenuModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#CategoriaMenuUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});

function updateModal(button) {
	$('.loader').fadeIn();
	var formData = $("#CategoriaMenuUpdateForm").serialize();
	var id = $("input[name='id']").val();
	var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "PUT",
		headers: {'X-CSRF-TOKEN': $('#tokenCategoriaMenuEdit').val()},
		url: urlActual+"/"+id +"/update",
		data: formData,
		dataType: "json",
		success: function(data) {
			$('.loader').fadeOut(225);
			$('#modalUpdateCategoriaMenu').modal("hide");
			categorias_menus_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Categoria de Menú Editada con Éxito!!');
		},
		error: function(errors) {
			$('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.email != null) {
				$("#CategoriaMenuUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
			}
			else{
				$("#ErrorNombreedit").remove();
			}
		}
		
	});
}

if(window.location.hash === '#edit')
	{
		$('#modalUpdateCategoriaMenu').modal('show');
	}

	$('#modalUpdateCategoriaMenu').on('hide.bs.modal', function(){
		$("#CategoriaMenuUpdateForm").validate().resetForm();
		document.getElementById("CategoriaMenuUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateCategoriaMenu').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




