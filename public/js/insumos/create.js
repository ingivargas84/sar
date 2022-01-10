var validator = $("#InsumoForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre:{
			required: true,
			nombreUnico: true
		},
		unidad_id:{
			required: true
		},
		categoria_insumo_id:{
			required: true
		},
		medida_id:{
			required: true
		},
		cantidad_medida:{
			required: true
		},
		stock_minimo:{
			required: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		},
		unidad_id:{
			required: "Por favor, seleccione unidad"
		},
		categoria_insumo_id:{
			required: "Por favor, seleccione categoria"
		},
		medida_id:{
			required: "Por favor, seleccione medida"
		},
		cantidad_medida:{
			required: "Por favor, ingrese cantidad por medida"
		},
		stock_minimo:{
			required: "Por favor, ingrese stock minimo"
		}
	}
});


$("#ButtonInsumo").click(function(event) {
	if ($('#InsumoForm').valid()) {
		$('.loader').addClass("is-active");
	} else {
		validator.focusInvalid();
	}
});

$("input[name='stock_minimo']").on('keyup', function(){
	//var value = $(this).val().length;
	//console.log(value);
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