var compras_cajas_table = $('#compras_cajas-table').DataTable({
    //"ajax": "/compras_cajas/getJson",
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
        "data": "caja.nombre",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    {
        "title": "Descripción",
        "data": "descripcion",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 
    {
        "title": "Total",
        "data": "total",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },  

    {
        "title": "Usuario que compro",
        "data": "user.name",
        "width" : "20%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Fecha",
        "data": "created_at",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
          
    /*{
        "title": "Acciones",
        "orderable": false,
        "width" : "20%",
        "render": function(data, type, full, meta) {

        return "<div id='" + full.id + "' class='text-center'>" + 
        "<div class='float-left col-lg-6'>" + 
        "<a href='#' class='edit-puesto' data-toggle='modal' data-target='#modalUpdatePuesto' data-id='"+full.id+"' data-nombre='"+full.nombre+"' >" + 
        "<i class='fa fa-btn fa-edit' title='Editar Puesto'></i>" + 
        "</a>" + "</div>" + 
        "<div class='float-right col-lg-6'>" + 
        "<a href='#' class='remove-puesto'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
        "<i class='fa fa-thumbs-down' title='Desactivar Puesto'></i>" + 
        "</a>" + "</div>";          
            
        },
        "responsivePriority": 5
    }*/
]

});