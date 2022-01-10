var validator = $("#InsumoUpdateForm").validate({
	ignore: [],
	onkeyup:false,
	rules: {
		nombre:{
			required: true,
			nombreUnicoEdit: true
		}

	},
	messages: {
		nombre: {
			required: "Por favor, ingrese nombre"
		}
	}
});


$("#ButtonInsumoUpdate").click(function(event) {
	if ($('#InsumoUpdateForm').valid()) {
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




