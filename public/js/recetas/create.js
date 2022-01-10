//funcion para agregar detalle
$('body').on('click', '#btnDetalle', function(e) {

    var detalle = new Object();
    var cantidad = $("input[name='cantidad'] ").val();
    //var precio_compra = $("input[name='precio_compra'] ").val();
    var id = $("#insumo_id").val(); 
    //var subtotal = cantidad * precio_compra;

    if (cantidad != "" && id != "")
    {
        //$("input[name='subtotal'] ").val(subtotal);
        detalle.cantidad = $("input[name='cantidad'] ").val();
        //detalle.precio_compra = $("input[name='precio_compra'] ").val();
        //detalle.subtotal_compra = $("input[name='subtotal'] ").val();
        detalle.insumo_id  = $("#insumo_id").val();
        //detalle.codigobarra = $("input[name='codigobarra'] ").val();
        detalle.nombre = $("#insumo_id").find("option:selected").text();
        detalle.nombre_medida = $("#unidad_medida_id").find("option:selected").text();
        /*var total2 = $("input[name='total'] ").val();
        if (total2 != "") {
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(subtotal);
            var total = total2 + subtotal;
            var total3 = $("input[name='total'] ").val(total);
        }
        else {
            var subtotal = parseFloat(subtotal);
            var total3 = $("input[name='total'] ").val(subtotal);
        }*/

        db.links.push(detalle);
		$("#insumo_id").val("");
        $("#insumo_id").change();
        $("#unidad_medida_id").val("");
		$("#unidad_medida_id").change();
        //$("input[name='codigobarra'] ").val("");
        $("input[name='nombre'] ").val("");
        //$("input[name='precio_compra'] ").val("");
        $("input[name='cantidad'] ").val([""]);
        var cantidad = $("input[name='cantidad'] ").val();
        //var subtotal = cantidad * precio_compra;
        //$("input[name='subtotal'] ").val(subtotal);
        $("#detalle-grid .jsgrid-search-button").trigger("click");
        //console.log(detalle.insumo_id);
        //console.log(db.links);

        var query = "SELECT I.id, I.nombre FROM insumos I WHERE I.estado = 1 ";
        var consulta ="";
        
        db.links.forEach(function(valor, indice, array){
            consulta += "AND I.id !="+ valor.insumo_id + " ";
        });
        var insumos = query + consulta;

        cargarSelectInsumo(insumos);
    }
    else 
    {
        alert("Verifique que el nombre del insumo, la cantidad no esten vacios");
    }
    
});

var query = "Select I.id, I.nombre FROM insumos I WHERE I.estado = 1";

cargarSelectInsumo(query);

