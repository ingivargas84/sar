
//funcion para agregar detalle
$('body').on('click', '#btnDetalle', function(e) {

    var detalle = new Object();
    var cantidad = $("input[name='cantidad'] ").val();
    var precio = $("input[name='precio'] ").val();
    var id = $("#insumo_id").val(); 
    var subtotal = cantidad * precio;

    if (cantidad != "" && id != "" && precio != "" && id != 0 && id != null)
    {
        if(cantidad >= 1 && precio >= 0){
            console.log(id);
            $("input[name='subtotal'] ").val(subtotal);
            detalle.cantidad = $("input[name='cantidad'] ").val();
            detalle.cantidad_medida = $("input[name='cantidad_medida'] ").val();
            detalle.precio = $("input[name='precio'] ").val();
            detalle.subtotal_compra = $("input[name='subtotal'] ").val();
            detalle.insumo_id  = $("#insumo_id").val();
            //detalle.codigobarra = $("input[name='codigobarra'] ").val();
            detalle.nombre = $("#insumo_id").find("option:selected").text();
            detalle.nombre_medida = $("#unidad_medida_id").find("option:selected").text();
            var total2 = $("input[name='total'] ").val();
            if (total2 != "") {
                var total2 =parseFloat(total2);
                var subtotal = parseFloat(subtotal);
                var total = total2 + subtotal;
                var total3 = $("input[name='total'] ").val(total);
            }
            else {
                var subtotal = parseFloat(subtotal);
                var total3 = $("input[name='total'] ").val(subtotal);
            }

            db.links.push(detalle);
            $("#insumo_id").val("");
            $("#insumo_id").change();
            $("#unidad_medida_id").val("");
            $("#unidad_medida_id").change();
            $("input[name='nombre'] ").val("");
            $("input[name='precio'] ").val("");
            $("input[name='cantidad'] ").val("");
            $("input[name='cantidad_medida'] ").val("");
            //var cantidad = $("input[name='cantidad'] ").val();
            //var subtotal = cantidad * precio;
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
        else{
            alert("cantidad debe ser mayor o igual a 1,  precio debe ser mayor o igual a 0")
        }
        
    }
    else 
    {
        alert("Verifique que el nombre del insumo, la cantidad o precio no esten vacios");
    }
    
});

var query = "Select I.id, I.nombre FROM insumos I WHERE I.estado = 1";

cargarSelectInsumo(query);

  //Funcion para llenar GRID
  (function() {

    var db = {
    
        loadData: function(filter) {
            return $.grep(this.links, function(link) {
                return (!filter.name || link.name.indexOf(filter.name) > -1)
                && (!filter.url || link.url.indexOf(filter.url) > -1);
            });
        },
    
        insertItem: function(insertingLink) {
            this.links.push(insertingLink);
            console.log(insertingLink);
        },
    
        updateItem: function(updatingLink) {

            var subtotal_nuevo = updatingLink.cantidad * updatingLink.precio;
    
            var total2 = $("input[name='total'] ").val();
            total2 =parseFloat(total2);

            var subtotal = updatingLink.subtotal_compra;
            subtotal = parseFloat(subtotal);
          
            console.log("El subtotal de la linea actual es "+subtotal);
            var total = total2 - subtotal + (subtotal_nuevo);
            $("input[name='total'] ").val(total);
            updatingLink.subtotal_compra = subtotal_nuevo;
            console.log("Subtotal Nuevo " +updatingLink.subtotal_compra);
            console.log("Nuevo total: "+ total);
        },
    
        deleteItem: function(deletingLink) {
            var linkIndex = $.inArray(deletingLink, this.links);
            var total2 = $("input[name='total'] ").val();
            var total2 =parseFloat(total2);
            var subtotal = parseFloat(deletingLink.subtotal_compra);
            var total = total2 - subtotal;
            var total3 = $("input[name='total'] ").val(total);
            this.links.splice(linkIndex, 1);
    
            var query = "SELECT I.id, I.nombre FROM insumos I WHERE I.estado = 1 ";
            var consulta ="";
            
            db.links.forEach(function(valor, indice, array){
                consulta += "AND I.id !="+ valor.insumo_id + " ";
            });
            var insumos = query + consulta;
    
            cargarSelectInsumo(insumos);
        }
    
    };
    window.db = db;
    db.links = [];
    
    //Funcion para guardar detalle
    function saveDetalle(button) {
        $('.loader').fadeIn();
        var proveedor_id = $("#proveedor_id").val();
        var serie = $("input[name='serie']").val();
        var numero_doc = $("input[name='numero_doc']").val();
        var total = $("input[name='total']").val();
        var fecha_factura = $("input[name='fecha_factura']").val();

        if ( proveedor_id != ''  && serie != "" && numero_doc != "" && fecha_factura != "") 
        {
            var formData = {proveedor_id : proveedor_id, serie: serie, numero_doc: numero_doc, total: total, fecha_factura: fecha_factura}
                var Datos = {'formData': formData, 'detalle': db.links}; 
                $.ajax({ 
                    type: "POST",
                    url: APP_URL+"/compras/save",
                    data: Datos,
                    dataType: "json",
                    success: function(data) {
                        $('.loader').fadeOut(225);
                        if (data.success == "ok") {
                            window.location = APP_URL+"/compras"
                        }
                    },
                    error: function() {
                        $('.loader').fadeOut(225);
                        alert("Ocurrio un error Contacte al Administrador!");
                    }
                });
            }
            else
            {
                alert ('Verifique que los datos de la compra esten ingresados');
            }
    
        }
    
        $("#ButtonCompra").click(function(event) {
            saveDetalle();
        });
    
    
        //$(document).ready(function () {
    
            $("#detalle-grid").jsGrid({
                width: "",
                filtering: false,
                editing: true,
                sorting: true,
                paging: true,
                autoload: true,
                inserting: false,
                pageSize: 20,
                pagerFormat: "Pages: {prev} {pages} {next} | {pageIndex} of {pageCount} |",
                pageNextText: '>',
                pagePrevText: '<',
                deleteConfirm: "Esta seguro de borrar el insumo",
                controller: db,
                fields: [
                { title: "Insumo", name: "nombre", type: "text", editing: false},
                { title: "Codigo", name: "insumo_id", type: "text", visible:false},
                { title: "Cantidad Medida", name: "cantidad_medida", type: "text", visible:false},
                { title: "Unidad de Medida", name: "nombre_medida", type: "text", editing: false},
                { title: "Cantidad", name: "cantidad", type: "number" },
                { title: "Precio", name: "precio", type: "number"},
                { title: "Subtotal", name: "subtotal_compra", type: "number", editing: false},                
                { type: "control" }
                ],
                onItemInserting: function (args) {
                },
                onItemUpdating: function (object) {                 
                    if (object.item.cantidad <= 0){
                        object.cancel = true;
                        alert('Cantidad debe ser igual o mayor a 0');
                    }
                    if (object.item.precio <= 0){
                        //restore();
                        object.cancel = true;
                        alert('Precio debe ser igual o mayor a 0');
                    }
                },
                onRefreshed : function () {
                    $('tbody').children('.jsgrid-insert-row').children('td').children('input').first().focus();
                }
            });
        //});
    }());
