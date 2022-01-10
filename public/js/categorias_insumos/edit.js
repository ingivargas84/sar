var validator = $("#CategoriaInsumoUpdateForm").validate({
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

$('#modalUpdateCategoriaInsumo').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#CategoriaInsumoUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCategoriaInsumoModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#CategoriaInsumoUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});


if(window.location.hash === '#edit')
	{
		$('#modalUpdateCategoriaInsumo').modal('show');
	}

	$('#modalUpdateCategoriaInsumo').on('hide.bs.modal', function(){
		$("#CategoriaInsumoUpdateForm").validate().resetForm();
		document.getElementById("CategoriaInsumoUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateCategoriaInsumo').on('shown.bs.modal', function(){
		window.location.hash = '#edit';
    
}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




