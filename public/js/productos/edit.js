var validator = $("#ProductoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre:{
			required: true,
			nombreUnicoEdit: true
		},
		categoria_menu_id:{
			required: true
		},
		precio:{
			required:  true,
			min: 0
		},
		destino_pedido_id:{
			required:  true,
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		categoria_menu_id:{
			required: "Por favor, seleccione categoria"
		},
		precio: {
			required: "Por favor, ingrese precio",
			min: "El valor ingresado debe ser igual o mayor a 0"
		},
		destino_pedido_id:{
			required:  "Por favor, seleccione destino"
		}
	}
});


$("#ButtonProductoUpdate").click(function(event) {
	if ($('#ProductoUpdateForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});

$("input[name='stock_minimo']").on('keyup', function(){
	cantidad_medida = $("input[name='cantidad_medida']").val();
	stock_minimo = $("input[name='stock_minimo']").val();
	total_stock = cantidad_medida * stock_minimo;
	$("input[name='total_stock']").val(total_stock);
}).keyup();

$("input[name='cantidad_medida']").on('focusout', function(){
	cantidad_medida = $("input[name='cantidad_medida']").val();
	stock_minimo = $("input[name='stock_minimo']").val();
	total_stock = cantidad_medida * stock_minimo;
	$("input[name='total_stock']").val(total_stock);
});




