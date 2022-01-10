var series_table = $('#series-table').DataTable({
    "ajax": APP_URL+"/series/getJson",

    "dom": 'Bfrtip',
    "buttons": [
    {
        extend: 'pdfHtml5',
        exportOptions: {
            columns: [ 0, 1, 2, 3, 4, 5,6]
        }
    },
    'excelHtml5',
    'csvHtml5'
    ],
    "paging": true,
    "language": {
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
    "order": [0, 'asc'],
    "columns": [
    {
        "title": "No.",
        "data": "id",
        "width" : "3%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },  
    {
        "title": "Resolución",
        "data": "resolucion",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data); },
    }, 
    {
        "title": "Serie",
        "data": "serie",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data); },
    },
    {
        "title": "Fecha Resolución",
        "data": "fecha_resolucion",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data); },
    },

    {
        "title": "Fecha Vecimiento",
        "data": "fecha_vencimiento",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data); },
    },
    {
        "title": "Usuario que creó",
        "data": "usuario_crea",
        "width" : "10%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
    {
        "title": "Fecha Creación",
        "data": "fecha",
        "width" : "10%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },       
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "15%",
        "render": function(data, type, full, meta) {
            var rol_user = $("input[name='rol_user']").val();
            if(rol_user == 'Super-Administrador' || rol_user == 'Administrador'){
                if (full.estado_id==5) {
                    return "<div class='float-right col-lg-4'>" + 
                    "<a href='#' class='asignar-user' data-toggle='modal' data-target='#modalEstado' data-id='"+full.id+"' data-estado_id='"+full.estado_id+"'>" + 
                    "<i class='fas fa-sign-out-alt' title='Cambiar Estado'></i>" + 
                    "</a>" + "</div>"; 
                } else if(full.estado_id==1){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-left col-lg-4'>" + 
                    "<a href='#' class='edit-series' data-toggle='modal' data-target='#modalUpdateSerie' data-id='"+full.id+"' data-serie='"+full.serie+"' data-resolucion='"+full.resolucion+"' data-fecha_resolucion='"+full.fecha_resolucion+"' data-fecha_vencimiento='"+full.fecha_vencimiento+"' data-inicio='"+full.inicio+"'  data-fin='"+full.fin+"' >" + 
                    "<i class='fa fa-btn fa-edit' title='Editar Serie'></i>" + 
                    "</a>" + "</div>" + 
                    "<div class='float-right col-lg-4'>" + 
                    "<a href='#' class='remove-series'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
                    "<i class='fa fa-thumbs-down' title='Desactivar Serie'></i>" + 
                    "</a>" + "</div>"+
                    "<div class='float-right col-lg-4'>" + 
                    "<a href='#' class='asignar-user' data-toggle='modal' data-target='#modalEstado' data-id='"+full.id+"' data-estado_id='"+full.estado_id+"'>" + 
                    "<i class='fas fa-sign-out-alt' title='Cambiar Estado'></i>" + 
                    "</a>" + "</div>";        
                }
                else{
                    return "<div class='float-right col-lg-4'>" + 
                    "<a href='#' class='asignar-user' data-toggle='modal' data-target='#modalEstado' data-id='"+full.id+"' data-estado_id='"+full.estado_id+"'>" + 
                    "<i class='fas fa-sign-out-alt' title='Cambiar Estado'></i>" + 
                    "</a>" + "</div>"; 
                }
               
            }
            else{
                if(full.estado_id==1){
                    return "<div id='" + full.id + "' class='text-center'>" + 
                    "<div class='float-left col-lg-6'>" + 
                    "<a href='#' class='edit-series' data-toggle='modal' data-target='#modalUpdateSerie' data-id='"+full.id+"' data-serie='"+full.serie+"' data-resolucion='"+full.resolucion+"' data-fecha_resolucion='"+full.fecha_resolucion+"' data-fecha_vencimiento='"+full.fecha_vencimiento+"' data-inicio='"+full.inicio+"'  data-fin='"+full.fin+"' >" + 
                    "<i class='fa fa-btn fa-edit' title='Editar Serie'></i>" + 
                    "</a>" + "</div>" + 
                    "<div class='float-right col-lg-6'>" + 
                    "<a href='#' class='remove-series'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' "+  ">" + 
                    "<i class='fa fa-thumbs-down' title='Desactivar Serie'></i>" + 
                    "</a>" + "</div>";        
                
                } else {
                    return "<div class='text-center col-lg-12'>" + 
                    "<i class='fab fa-expeditedssl' title='"+full.estado +"'></i>" + "</div>"
            }  }   
            
        },
        "responsivePriority": 2
    }]
});
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
		url: APP_URL+"/series/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
			$('#modalConfirmarAccion').modal("hide");
			series_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('La serie se Desactivó Correctamente!!');
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