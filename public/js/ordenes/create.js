//Cargar la carta con los productos
function cargarCarta(categoria){
	$('#body_carta').empty();
        $.ajax({
            type: "GET",
            url: APP_URL+"/productos/cargar", 
            dataType: "json",
            data: "categoria=" + categoria,
            success: function(data){
                $.each(data,function(key, registro) {                    
                    $("#body_carta").append(`<a href="#" onclick="agregarProducto(${registro.id}, ${registro.precio}, '${registro.nombre}')">
                    <div class='box'><div class='box-body' data-precio='${registro.precio}' 
                    data-producto_id='${registro.id}'>  ${registro.nombre} Q  ${registro.precio}</div></div></a>`);

                });
        
            },
            error: function(data) {
                alert('error');
            }
            });		
}

$('#categoria_id').on('change',function(){
    var categoria_id = $('#categoria_id').val();
    cargarCarta(categoria_id);
});

//Seleccionar las mesas
$('#mesa_id').on('change',function(){
    var orden_maestro_id = $("input[name='orden_maestro_id']").val();
    var mesa_id = $('#mesa_id').val();
    var nombre = $("#mesa_id").find("option:selected").text();
    var mesasDetalle = new Object();
    if(mesa_id == ""){

    }else{
        function buscar(valor){
            return valor.id == mesa_id;
        }
        var indice = mesas.findIndex(buscar);
        if(indice >= 0){
            alert('La Mesa ya se encuentra agregada');
        }else{
            if(mesas.length == 0 && orden_maestro_id == 0){
                mesasDetalle.id = mesa_id;
                //mesasDetalle.nombre = nombre;
                mesas.push(mesasDetalle);
                $.ajax({ 
                    type: "POST",
                    url: APP_URL+"/ordenes_maestro/save",
                    data: {mesas},
                    dataType: "json",
                    success: function(data) {
                        //$('.loader').fadeOut(225);
                        if (data.success == "ok") {
                            $("input[name='orden_maestro_id']").val(data.orden_maestro_id);
                            alertify.set('notifier','position', 'top-center');
                            alertify.success('Se añadio la Mesa!!');
                        }
                    },
                    error: function() {
                        //$('.loader').fadeOut(225);
                        alert("Ocurrio un error Contacte al Administrador!");
                    }
                });
            }else{
                mesasDetalle.id = mesa_id;
                //mesasDetalle.nombre = nombre;
                mesas.push(mesasDetalle);
            }

            $("#body_mesa").append("<div class='box'><div class='box-body' data-mesa_id='"+mesa_id+"'><div class='box-tools pull-right'>"+
            "<button type='button' class='btn btn-danger btn-xs' onclick='borrarMesa("+mesa_id+")'>X</button></div> "+nombre+"</div></div>");
           
        }        
        
    }
    
});

var mesas = [];
var productos = [];
var cuentas = [];

function recargarDetalle(cuenta_id, productos){
    $.ajax({ 
        type: "GET",
        async: false,
        url: APP_URL+"/ordenes/detalle/"+cuenta_id+"/getJson",
        dataType: "json",
        success: function(data1) {
            productos = data1.data;

            $("#body_pedido").empty();
    
            $.each(productos,function(key, registro) {                              
                $("#body_pedido").append(`<div class="box box-default"><div class="box-tools pull-right"><button type="button" class="btn btn-danger btn-xs" data-pedido_id='${registro.id}' data-target='#modalConfirmarAccion' data-toggle='modal' data-id='${registro.detalle_id}'>X</button></div>
                <div class="box-body" data-pedido_id="${registro.id}"><div class="col-sm-5 text-left"><p>${registro.nombre_producto} Q  ${registro.precio}</p></div><div class="col-sm-7 text-center" style="display:flex">
                <button class="btn btn-danger" onclick="disminuirCantidad(${registro.id}, ${registro.precio})">-</button><input data-id_cantidad="${registro.id}" type="number" class="form-control" disabled value="${registro.cantidad}">
                <button class="btn btn-success" onclick="aumentarCantidad(${registro.id}, ${registro.precio})">+</button></div>
                <div class="col-sm-12 text-right"><b>Subtotal  Q.</b><label data-id_subtotal="${registro.id}">${parseFloat(registro.precio * registro.cantidad)}</label></div>
                <div class="col-sm-12"><input type="text" class="form-control" name="comentario" data-comentario="${registro.id}"  value="${registro.comentario}" onfocusout="agregarComentario(${registro.id})"></div></div></div>`);

            });
            $("input[name='total']").val(data1.total);
            console.log(data1.total);
        },
        error: function() {
            alert("Ocurrio un error Contacte al Administrador!");
        }
    });

    return productos;
}

function limpiar(productos){
    productos = [];
    $("input[name='total']").val(0);
    $("#body_pedido").empty();

    return productos;
}

function agregarCuenta()
{
    var orden_maestro_id = $("input[name='orden_maestro_id']").val();

    if(mesas.length == 0){
        alert('Debe seleccionar una mesa primero');
    }else{
        $.ajax({ 
            type: "POST",
            url: APP_URL+"/ordenes/saveCuenta",
            data: {orden_maestro_id},
            dataType: "json",
            success: function(data) {
                //$('.loader').fadeOut(225);
                if (data.success == "ok") {
                    var cuenta = new Object();
                    cuenta.id = data.orden.id;
                    cuenta.total = data.orden.total;
                    cuentas.push(cuenta);            
                
                    $("#body_cuenta").append(`
                    <a href='#' onclick='seleccionarCuenta(${data.orden.id})'><div class="box box-default box-cuenta" data-cuenta_id="${data.orden.id}">
                        <div class="box-body">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-danger btn-xs" data-orden_id='${data.orden.id}' data-target='#modalConfirmarAccion' data-toggle='modal' data-id='' >X</button>
                                </div>
                            Cuenta # ${data.orden.id}
                        </div>
                    </div></a>`);
                    //alertify.set('notifier','position', 'top-center');
                    //alertify.success('Se creo una nueva cuenta');*/
                }
            },
            error: function() {
                //$('.loader').fadeOut(225);
                alert("Ocurrio un error Contacte al Administrador!");
            }
        });

    }
    
    console.log(cuentas);
}

function borrarMesa(id)
{    
    function buscar(valor){
        return valor.id == id;
    }
    var indice = mesas.findIndex(buscar);

    mesas.splice(indice, 1);
    $('*[data-mesa_id="'+id+'"]').parent().remove();
}

function seleccionarCuenta(id){
    $('.box-cuenta').removeClass('box-default');
    $('.box-cuenta').removeClass('box-primary');
    $('*[data-cuenta_id="'+id+'"]').addClass('box-primary');
    $("input[name='cuenta_id']").val(id);

    productos = recargarDetalle(id, productos);
}

function borrarCuenta(id)
{    
    $('*[data-cuenta_id="'+id+'"]').remove();
    $("input[name='cuenta_id']").val(0);
}

function borrarPedido(id)
{    
    function buscar(valor){
        return valor.id == id;
    }
    
    //Actualizar total
    var producto = productos.find(buscar);
    var subtotal_anterior = producto.subtotal;
    var total = $("input[name='total']").val();
    total = parseFloat(total);

    var totalNuevo = total - subtotal_anterior;
    $("input[name='total']").val(totalNuevo.toFixed(2));


    //Borrar pedido
    var indice = productos.findIndex(buscar);
    productos.splice(indice, 1);
    $('*[data-pedido_id="'+id+'"]').parent().remove();
}

function agregarProducto(id, precio, nombre_producto)
{
    var cuenta_id = $("input[name='cuenta_id']").val();
    if(cuenta_id == 0)
    {
        alert('Debe Seleccionar una cuenta primero')
    }else{
        function buscar(valor){
            return valor.id == id;
        }
        var indice = productos.findIndex(buscar);
    
        if(indice >=0){
            alert('El Producto ya se encuentra en la orden');
        }else{
            var ordenDetalle = new Object();
            ordenDetalle.id = id;
            ordenDetalle.precio = precio;
            ordenDetalle.nombre_producto = nombre_producto;
            ordenDetalle.cantidad =1;
            ordenDetalle.subtotal = ordenDetalle.cantidad * precio;
            ordenDetalle.comentario = "";
            productos.push(ordenDetalle);
    
            var subtotal = ordenDetalle.cantidad * precio;
            var total = $("input[name='total']").val();
            total = parseFloat(total);
    
            var totalNuevo = total + subtotal;
            $("input[name='total']").val(totalNuevo.toFixed(2));       
    
    
            //$("#body_pedido").append(`<div class='box'><div class='box-body'> <div class='box-tools pull-right'> <button type='button' class='btn btn-danger btn-xs' onclick='borrarMesa(${id})'>X</button></div> ${nombre_producto} Q  ${precio.toFixed(2)} </div></div>`);
            $("#body_pedido").append(`<div class="box box-default"><div class="box-tools pull-right"><button type="button" class="btn btn-danger btn-xs" data-pedido_id='${id}' data-target='#modalConfirmarAccion' data-toggle='modal' data-id='' >X</button></div>
            <div class="box-body" data-pedido_id="${id}"><div class="col-sm-5 text-left"><p>${nombre_producto} Q  ${precio.toFixed(2)}</p></div><div class="col-sm-7 text-center" style="display:flex">
            <button class="btn btn-danger" onclick="disminuirCantidad(${id}, ${precio})">-</button><input data-id_cantidad="${id}" type="number" class="form-control" disabled value="${1}">
            <button class="btn btn-success" onclick="aumentarCantidad(${id}, ${precio})">+</button></div>
            <div class="col-sm-12 text-right"><b>Subtotal  Q.</b><label data-id_subtotal="${id}">${parseFloat(precio)* 1}</label></div>
            <div class="col-sm-12"><input type="text" class="form-control" name="comentario" data-comentario="${id}" onfocusout="agregarComentario(${id})"></div></div></div>`); 
        }
    }
    console.log(productos);
}

function agregarComentario(id){
    var comentario = $("*[data-comentario='"+id+"']").val();
    //Actualizar  array
    productos.map(function(dato){
        if(dato.id == id){
          dato.comentario = comentario;
        }
        return dato;
    });
    console.log(productos);
}

function aumentarCantidad(id, precio){
    var cantidad= $("*[data-id_cantidad='"+id+"']").val();
    precio = parseFloat(precio);
    cantidad = parseFloat(cantidad);
   
    $("*[data-id_cantidad='"+id+"']").val(cantidad+=1);
    
    var subtotal = cantidad * precio;

    $("*[data-id_subtotal='"+id+"']").empty();
    $("*[data-id_subtotal='"+id+"']").text(subtotal);

    //Actualizar total

    function buscar(valor){
        return valor.id == id;
    }
    var producto = productos.find(buscar);

    var subtotal_anterior = producto.subtotal;
    var total = $("input[name='total']").val();
    total = parseFloat(total);

    var totalNuevo = total + subtotal - subtotal_anterior;
    $("input[name='total']").val(totalNuevo.toFixed(2));


    //Actualizar  array
    productos.map(function(dato){
        if(dato.id == id){
          dato.cantidad = cantidad;
          dato.subtotal = subtotal;
        }
        return dato;
    });

    console.log(productos);
}
function disminuirCantidad(id, precio){
    var cantidad= $("*[data-id_cantidad='"+id+"']").val();
    precio = parseFloat(precio);
    cantidad = parseFloat(cantidad);

    if (cantidad == 0){
        $("*[data-id_cantidad='"+id+"']").val(0);
        $("*[data-id_subtotal='"+id+"']").empty();
        $("*[data-id_subtotal='"+id+"']").text(0);

        //Actualizar cantidad en array
        productos.map(function(dato){
            if(dato.id == id){
              dato.cantidad = 0;
              dato.subtotal = 0;
            }
            return dato;
        });

    }else{
        $("*[data-id_cantidad='"+id+"']").val(cantidad-=1);
        var subtotal = cantidad * precio;        

        $("*[data-id_subtotal='"+id+"']").empty();
        $("*[data-id_subtotal='"+id+"']").text(subtotal);

        //Actualizar total
        function buscar(valor){
            return valor.id == id;
        }
        var producto = productos.find(buscar);
        var subtotal_anterior = producto.subtotal;

        var total = $("input[name='total']").val();
        total = parseFloat(total);

        var totalNuevo = total + subtotal - subtotal_anterior;
        $("input[name='total']").val(totalNuevo.toFixed(2));


        //Actualizar cantidad array
        productos.map(function(dato){
            if(dato.id == id){
              dato.cantidad = cantidad;
              dato.subtotal = subtotal;
            }
            return dato;
        });
    } 

    console.log(productos);
}

//Funcion para guardar detalle
    function saveDetalle(button) {
        var total = $("input[name='total']").val();
        var cuenta_id = $("input[name='cuenta_id']").val();
        //var mesasA = JSON.stringify(mesas)
    //$('.loader').fadeIn();
    if ( productos.length > 0 && mesas.length > 0 && cuenta_id > 0) 
    {
            var Datos = {'productos': productos, 'total': total, 'cuenta_id': cuenta_id, 'mesas': mesas}; 
            $.ajax({ 
                type: "POST",
                url: APP_URL+"/ordenes/save",
                data: Datos,
                dataType: "json",
                success: function(data) {
                    //$('.loader').fadeOut(225);
                    if (data.success == "ok") {
                        productos = recargarDetalle(cuenta_id, productos);
                        //window.location = APP_URL+"/ordenes"
                        alertify.set('notifier','position', 'top-center');
                        alertify.success('La Cuenta se guardo Correctamente!!');
                    }
                },
                error: function() {
                    //$('.loader').fadeOut(225);
                    alert("Ocurrio un error Contacte al Administrador!");
                }
            });
        }
        else
        {
            alert ('Por favor, seleccione un producto del menú y  una mesa');
        }

    }

    $("#ButtonOrden").click(function(event) {
        saveDetalle();
    });


    //Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
		confirmarAccion();
	} else {
		validator.focusInvalid();
	}
});


function confirmarAccion(button) {
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
    var detalle_id = $("#idConfirmacion").val();
    var pedido_id = $("input[name='pedido_id']").val();
    var orden_id = $("input[name='orden_id']").val();

    $.ajax({
        type: "DELETE",
        headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
        url: APP_URL+"/ordenes/detalle/delete",
        data: formData,
        dataType: "json",
        success: function(data) {
            if(data.success == 'ÉxitoOrden'){
                borrarCuenta(orden_id);
                limpiar(productos);
                $('.loader').fadeOut(225);
                $('#modalConfirmarAccion').modal("hide");   
                alertify.set('notifier','position', 'top-center');
                alertify.success('La Cuenta se elimino Correctamente!!');                
            }else{
                borrarPedido(pedido_id);
                $('.loader').fadeOut(225);
                $('#modalConfirmarAccion').modal("hide");   
                alertify.set('notifier','position', 'top-center');
                alertify.success('El Detalle se elimino Correctamente!!');
            }
            
        },
        error: function(errors) {
            $('.loader').fadeOut(225);
            if(errors.responseText !=""){
            var errors = JSON.parse(errors.responseText);
            if (errors.password_actual != null) {
                $("input[name='password_actual'] ").after("<label class='error' id='ErrorPassword_actual'>"+errors.password_actual+"</label>");
            }
            else{
                $("#ErrorPassword_actual").remove();
            }
            } 
        }
        
    });
}



