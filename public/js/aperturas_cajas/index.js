var aperturas_cajas_table = $('#aperturas_cajas-table').DataTable({
    //"ajax": "/aperturas_cajas/getJson",
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
        "title": "Estado",
        "data": "estado",
        "visible": false,
        "width" : "5%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);
        },
    }, 
    
    {
        "title": "Caja",
        "data": "nombre",
        "width" : "20%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data); },
    }, 

    {
        "title": "Usuario aperturo",
        "data": "user_aperturo",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cajero",
        "data": "cajero",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha Apertura",
        "data": "fecha_apertura",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Fecha Cierre",
        "data": "fecha_cierre",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Monto Apertura",
        "data": "monto",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },

    {
        "title": "Monto Cierre",
        "data": "efectivo",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },

    {
        "title": "Faltante",
        "data": "faltante",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
    },

    {
        "title": "Sobrante",
        "data": "sobrante",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return ("Q." + parseFloat(Math.round(data * 100) / 100).toFixed(2));
        },
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
],
'rowCallback': function(row, data, index){
    if(data.estado == 1){ 
        $(row).css('background-color', '#CEF6CE'); 
    }else{
        $(row).css('background-color', '#F6CECE'); 
    }
}

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
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var urlActual =  $("input[name='urlActual']").val();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: urlActual+"/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");
			aperturas_cajas_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Puesto se Desactivó Correctamente!!');
		},
		error: function(errors) {
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