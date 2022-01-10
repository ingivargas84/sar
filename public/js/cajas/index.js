var cajas_table = $('#cajas-table').DataTable({
    //"ajax": "/cajas/getJson",
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
        "width" : "15%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    
    {
        "title": "Caja",
        "data": "nombre",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Usuario que lo creó",
        "data": "user.name",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Fecha creación",
        "data": "created_at",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Estado",
        "data": "apertura",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            if(data == 1) {
                return ('Abierta');
            }           
            else {
                return ('Cerrada');
            }
        },
    },
    
          
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "25%",
        "render": function(data, type, full, meta) {
        var rol_user = $("input[name='rol_user']").val();
            if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){

                if(full.apertura == 1){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-left col-lg-3'>" + 
                    "<a href='#' class='edit-caja' data-toggle='modal' data-target='#modalUpdateCaja' data-id='"+full.id+"' data-nombre='"+full.nombre+"' >" + 
                    "<i class='fa fa-btn fa-edit' title='Editar Caja'></i>" + 
                    "</a>" + "</div>" + 
                    "<div class='float-right col-lg-3'>" + 
                    "<a href='#' class='remove-caja'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
                    "<i class='fa fa-thumbs-down' title='Desactivar Caja'></i>" + 
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-3'>" + 
                    "<a href='#' class='cierre-caja btn-danger btn-xs' data-toggle='modal' data-target='#modalCierre' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-power-off' title='Cerrar Caja'></i>" + 
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-3'>" + 
                    "<a href="+APP_URL+"/cajas/movimiento/"+full.id+" class='detalle-movimiento'>" + 
                    "<i class='fa fa-desktop' title='Detalle de Movimiento'></i>" + 
                    "</a>" + "</div>";

                }else{
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-left col-lg-3'>" + 
                    "<a href='#' class='edit-caja' data-toggle='modal' data-target='#modalUpdateCaja' data-id='"+full.id+"' data-nombre='"+full.nombre+"' >" + 
                    "<i class='fa fa-btn fa-edit' title='Editar Caja'></i>" + 
                    "</a>" + "</div>" + 
                    "<div class='float-right col-lg-3'>" + 
                    "<a href='#' class='remove-caja'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
                    "<i class='fa fa-thumbs-down' title='Desactivar Caja'></i>" + 
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-3'>" + 
                    "<a href='#' class='apertura-caja btn-success btn-xs' data-toggle='modal' data-target='#modalApertura' data-id='"+full.id+"' >" + 
                    "<i class='fa fa-power-off' title='Aperturar Caja'></i>" + 
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-3'>" + 
                    "<a href="+APP_URL+"/cajas/movimiento/"+full.id+" class='detalle-movimiento'>" + 
                    "<i class='fa fa-desktop' title='Detalle de Movimiento'></i>" + 
                    "</a>" + "</div>";
                }
                
            }
            else{
                return "<div id='" + full.id + "' class='text-center'>" + 
                "<div class='float-left col-lg-6'>" + 
                "<a href='#' class='edit-caja' data-toggle='modal' data-target='#modalUpdateCaja' data-id='"+full.id+"' data-nombre='"+full.nombre+"' >" + 
                "<i class='fa fa-btn fa-edit' title='Editar Caja'></i>" + 
                "</a>" + "</div>" + 
                "<div class='float-right col-lg-6'>" + 
                "<a href='#' class='remove-caja'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
                "<i class='fa fa-thumbs-down' title='Desactivar Caja'></i>" + 
                "</a>" + "</div>";  
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
