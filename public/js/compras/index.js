var compras_table = $('#compras-table').DataTable({
    //"ajax": "/compras/getJson",
    "responsive": true,
    "processing": true,
    "info": true,
    "showNEntries": true,
    "dom": 'Bfrtip',

    lengthMenu: [
        [ 10, 25, 50, -1 ],
        [ '10 filas', '25 filas', '50 filas', 'Mostrar todo' ]
    ],

    "buttons": [
    'pageLength',
    'excelHtml5',
    'csvHtml5'
    ],

    "paging": true,
    "language": {
        "sdecimal":        ".",
        "sthousands":      ",",
        "sProcessing":     "Procesando...",
        "sLengthMenu":     "Mostrar _MENU_ registros",
        "sZeroRecords":    "No se encontraron resultados",
        "sEmptyTable":     "Ningún dato disponible en esta tabla",
        "sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix":    "",
        "sSearch":         "Buscar:",
        "sUrl":            "",
        "sInfoThousands":  ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst":    "Primero",
            "sLast":     "Último",
            "sNext":     "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
    },
    "order": [0, 'desc'],

    "columns": [ {
        "title": "No.",
        "data": "id",
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Serie",
        "data": "serie",
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
    {
        "title": "Número Doc.",
        "data": "numero_doc",
        "width" : "10%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    {
        "title": "Proveedor",
        "data": "proveedor.nombre_comercial",
        "width" : "20%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "compra_estado.nombre",
        "width" : "15%",
        "responsivePriority": 5,
        "render": function( data, type, full, meta ) {
            return (data);            
        },
    }, 

    {
        "title": "Total",
        "data": "total",
        "width" : "15%",
        "responsivePriority": 6,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },      
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {
        if(full.compra_estado_id == 1){
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='"+APP_URL+"/compras/detalle/"+full.id+"' class='detalle-compra'>" + 
            "<i class='fa fa-btn fa-desktop' title='Detalle Compra'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-left col-lg-4'>" + 
            "<a href='#' class='editar-compra' data-toggle='modal' data-target='#modalUpdateCompra' data-id='"+full.id+"' data-serie='"+full.serie+"' data-numero_doc='"+full.numero_doc+"' data-fecha_factura='"+full.fecha_factura+"' >" + 
            "<i class='fa fa-btn fa-edit' title='Editar Compra'></i>" + 
            "</a>" + "</div>" + 
            "<div class='float-right col-lg-4'>" + 
            "<a href='#' class='remove-compra'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
            "<i class='fa fa-thumbs-down' title='Anular Compra'></i>" + 
            "</a>" + "</div>"; 
        }else{
            return "<div id='" + full.id + "' class='text-center'>" + 
            "<div class='float-left col-lg-12'>" + 
            "<a href='"+APP_URL+"/compras/detalle/"+full.id+"' class='detalle-compra'>" + 
            "<i class='fa fa-btn fa-desktop' title='Editar Compra'></i>" + 
            "</a>" + "</div>" ;
        }
                 
            
        },
        "responsivePriority": 5
    }]

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
    var id = $("#idConfirmacion").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: APP_URL+"/compras/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			compras_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('La Compra se Anulo Correctamente!!');
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