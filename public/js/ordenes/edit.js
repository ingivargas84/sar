
    $( document ).ready(function() {
        $('.loader').fadeOut(225);
    });

    var productos = [];
    var orden_maestro_id = $("input[name='orden_maestro_id']").val();
    var cuentas = [];
    
    function recargarCuenta(orden_maestro_id, cuentas)
    {
        $.ajax({ 
            type: "GET",
            async: false,
            url: APP_URL+"/ordenes_maestro/"+orden_maestro_id+"/getJson",
            dataType: "json",
            success: function(data1) {
                cuentas = data1.data;       
                $('#body_cuenta').empty();
                $.each(cuentas,function(key, registro) {                              
                    $("#body_cuenta").append(`
                    <a href='#' onclick='seleccionarCuenta(${registro.cuenta_id})'><div class="box box-default box-cuenta" data-cuenta_id="${registro.cuenta_id}">
                        <div class="box-body">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-danger btn-xs" data-orden_id='${registro.cuenta_id}' data-target='#modalConfirmarAccion' data-toggle='modal' data-id='' >X</button>
                                </div>
                            Cuenta # ${registro.cuenta_id}
                        </div>
                    </div></a>`);
                });
    
                if (cuentas != ""){
                    var primerCuenta = cuentas[0].cuenta_id;
                    seleccionarCuenta(primerCuenta);
                }
            },
            error: function() {
                alert("Ocurrio un error Contacte al Administrador!");
            }
        });
    }

    recargarCuenta(orden_maestro_id, cuentas);

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
                    $("#body_pedido").append(`<div class="box box-default"><div class="box-tools pull-right"><button type="button" class="btn btn-danger btn-xs" data-pedido_id='${registro.id}' onclick="borrarPedido(${registro.id}, ${registro.detalle_id})">X</button></div>
                    <div class="box-body" data-pedido_id="${registro.id}"><div class="col-sm-5 text-left"><p>${registro.nombre_producto} Q  ${registro.precio}</p></div><div class="col-sm-7 text-center" style="display:flex">
                    <button class="btn btn-danger btn-menos" onclick="disminuirCantidad(${registro.id}, ${registro.precio})">-</button><input data-id_cantidad="${registro.id}" type="number" class="form-control" disabled value="${registro.cantidad}">
                    <button class="btn btn-success btn-mas" onclick="aumentarCantidad(${registro.id}, ${registro.precio})">+</button></div>
                    <div class="col-sm-12 text-right"><b>Subtotal  Q.</b><label data-id_subtotal="${registro.id}">${parseFloat(registro.precio * registro.cantidad)}</label></div>
                    <div class="col-sm-12"><input type="text" class="form-control" name="comentario" data-comentario="${registro.id}"  value="${registro.comentario}" onfocusout="agregarComentario(${registro.id})"></div></div></div>`);
    
                });
                $("input[name='total']").val(data1.total);
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

                        seleccionarCuenta(data.orden.id);
                    }
                },
                error: function() {
                    //$('.loader').fadeOut(225);
                    alert("Ocurrio un error Contacte al Administrador!");
                }
            });

    }

//Cargar la carta con los productos
function cargarCarta(categoria, cuenta){
	$('#body_carta').empty();
    $.ajax({
    type: "GET",
    url: APP_URL+"/productos/cargar", 
    dataType: "json",
    data: {'categoria':categoria, 'cuenta': cuenta},
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
    var cuenta = $("input[name='cuenta_id']").val();
    cargarCarta(categoria_id, cuenta);
});

if(cuentas == "" && $("input[name='cuenta_id']").val() == 0){
    var categoriaActual = $("#categoria_id").val();
    cargarCarta(categoriaActual, 0);
}

function seleccionarCuenta(id){
    $('.box-cuenta').removeClass('box-default');
    $('.box-cuenta').removeClass('box-success');
    $('.box-cuenta').removeClass('box-primary-cuenta');
    $('*[data-cuenta_id="'+id+'"]').addClass('box-success');
    $('*[data-cuenta_id="'+id+'"]').addClass('box-primary-cuenta');
    $("input[name='cuenta_id']").val(id);

    productos = recargarDetalle(id, productos);

    var categoria = $("#categoria_id").val();
    cargarCarta(categoria, id);
    console.log(categoria, id);
}
function borrarCuenta(id)
{    
    $('*[data-cuenta_id="'+id+'"]').remove();
    $("input[name='cuenta_id']").val(0);
}

//Acciones relacionadas con los productos
function borrarPedido(id, detalle_id)
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
    $("input[name='total']").val(totalNuevo);


    //Borrar pedido
    var indice = productos.findIndex(buscar);
    productos.splice(indice, 1);
    $('*[data-pedido_id="'+id+'"]').parent().remove();

    if(detalle_id != 0){

        $.ajax({
            type: "DELETE",
            headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
            url: APP_URL+"/ordenes/producto/delete",
            data: {'id':detalle_id},
            dataType: "json",
            success: function(data) {
                //alertify.set('notifier','position', 'top-center');
                //alertify.success('El Detalle se elimino Correctamente!!');
                var categoria = $("#categoria_id").val();
                var cuenta = $("input[name='cuenta_id']").val();
                cargarCarta(categoria, cuenta);
            },
            error: function(errors) {
                $('.loader').fadeOut(225);
            }
        });
    }

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
            $("input[name='total']").val(totalNuevo);       
    
    
            //$("#body_pedido").append(`<div class='box'><div class='box-body'> <div class='box-tools pull-right'> <button type='button' class='btn btn-danger btn-xs' onclick='borrarMesa(${id})'>X</button></div> ${nombre_producto} Q  ${precio} </div></div>`);
            $("#body_pedido").append(`<div class="box box-default"><div class="box-tools pull-right"><button type="button" class="btn btn-danger btn-xs" data-pedido_id='${id}' onclick="borrarPedido(${id}, ${0})" >X</button></div>
            <div class="box-body" data-pedido_id="${id}"><div class="col-sm-5 text-left"><p>${nombre_producto} Q  ${precio}</p></div><div class="col-sm-7 text-center" style="display:flex">
            <button class="btn btn-danger btn-menos" onclick="disminuirCantidad(${id}, ${precio})" >-</button><input data-id_cantidad="${id}" type="number" class="form-control" disabled value="${1}">
            <button class="btn btn-success btn-mas" onclick="aumentarCantidad(${id}, ${precio})">+</button></div>
            <div class="col-sm-12 text-right"><b>Subtotal  Q.</b><label data-id_subtotal="${id}">${parseFloat(precio)* 1}</label></div>
            <div class="col-sm-12"><input type="text" class="form-control" name="comentario" data-comentario="${id}" onfocusout="agregarComentario(${id})"></div></div></div>`);
            
            updateDetalle("AgregarProducto");
        }    
    }    
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
    updateDetalle();
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
    $("input[name='total']").val(totalNuevo);


    //Actualizar  array
    productos.map(function(dato){
        if(dato.id == id){
          dato.cantidad = cantidad;
          dato.subtotal = subtotal;
        }
        return dato;
    });

    updateDetalle();
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
        $("input[name='total']").val(totalNuevo);


        //Actualizar cantidad array
        productos.map(function(dato){
            if(dato.id == id){
              dato.cantidad = cantidad;
              dato.subtotal = subtotal;
            }
            return dato;
        });
        updateDetalle();
    } 
    
}

//Funcion para guardar detalle
    function updateDetalle(accion) {
        var total = $("input[name='total']").val();
        var cuenta_id = $("input[name='cuenta_id']").val();
        
        if ( productos.length > 0 && cuenta_id > 0) 
        {
            $("*.btn-menos").attr('disabled', true);
            $("*.btn-mas").attr('disabled', true);
            //$('.loader').fadeIn(40);
            var Datos = {'productos': productos, 'total': total, 'cuenta_id': cuenta_id }; 
                $.ajax({ 
                    type: "PUT",
                    url: APP_URL+"/ordenes/"+cuenta_id+"/update",
                    data: Datos,
                    dataType: "json",
                    success: function(data) {
                        //$('.loader').fadeOut(80);
                        if (data.success == "ok") {
                            productos = recargarDetalle(cuenta_id, productos);
                            //window.location = APP_URL+"/ordenes"
                            //alertify.set('notifier','position', 'top-center');
                            //alertify.success('La Cuenta se guardo Correctamente!!');
                            if(accion == "AgregarProducto"){
                                var categoria = $("#categoria_id").val();
                                var cuenta = $("input[name='cuenta_id']").val();
                                cargarCarta(categoria, cuenta);
                            }
                            $("*.btn-menos").attr('disabled', false);
                            $("*.btn-mas").attr('disabled', false);
                        }
                    },
                    error: function() {
                        $("*.btn-menos").attr('disabled', false);
                        $("*.btn-mas").attr('disabled', false);
                        //$('.loader').fadeOut(40);
                        alert("Ocurrio un error Contacte al Administrador!");
                    }
                });
            }
            else
            {
                alert ('Por favor, seleccione un producto del menú');
            }
    }

    $("#ButtonOrdenUpdate").click(function(event) {
        updateDetalle();
    });


//Confirmar Contraseña para borrar
$("#btnConfirmarAccion").click(function(event) {
    event.preventDefault();
	if ($('#ConfirmarAccionForm').valid()) {
        var precio = $("input[name='precio_cuenta']").val();
        if(precio == ''){
            confirmarAccion();
        }else{
            //confirmarDisminuir();
        }
		
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
                recargarCuenta(orden_maestro_id, cuentas);
                if($("input[name='cuenta_id']").val() == 0){
                    var categoriaActual = $("#categoria_id").val();
                    cargarCarta(categoriaActual, 0);
                }
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

/*function confirmarDisminuir(button) {
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var precio = $("input[name='precio_cuenta']").val();

    $.ajax({
        type: "POST",
        headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
        url: APP_URL+"/ordenes/detalle/menos",
        data: formData,
        dataType: "json",
        success: function(data) {
            disminuirCantidad(id, precio);
            $('.loader').fadeOut(225);
            $('#modalConfirmarAccion').modal("hide");   
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
}*/


