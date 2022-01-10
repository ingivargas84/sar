var validator = $("#CajaUpdateForm").validate({
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

$('#modalUpdateCaja').on('shown.bs.modal', function(event){
	var button = $(event.relatedTarget);
	var id = button.data('id');
	var nombre = button.data('nombre');
	
	var modal = $(this);
	modal.find(".modal-body input[name='id']").val(id);
	modal.find(".modal-body input[name='nombre']").val(nombre);

 }); 

function BorrarFormularioUpdate() {
    $("#CajaUpdateForm :input").each(function () {
        $(this).val('');
	});
};

$("#ButtonCajaModalUpdate").click(function(event) {
	event.preventDefault();
	if ($('#CajaUpdateForm').valid()) {
		updateModal();
	} else {
		validator.focusInvalid();
	}
});


if(window.location.hash === '#edit')
	{
		$('#modalUpdateCaja').modal('show');
	}

	$('#modalUpdateCaja').on('hide.bs.modal', function(){
		$("#CajaUpdateForm").validate().resetForm();
		document.getElementById("CajaUpdateForm").reset();
		window.location.hash = '#';
	});

	$('#modalUpdateCaja').on('shown.bs.modal', function(){
		window.location.hash = '#edit';

	}); 
	   

/*$(".edit-user").click(function(){
	alert($(".edit-user").attr("data-id"));
	console.log('si');

});*/




