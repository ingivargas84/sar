var puestos_table = $('#puestos-table').DataTable({
    //"ajax": "/puestos/getJson",
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
        "title": "Puesto",
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
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var urlActual =  $("input[name='urlActual']").val();
    $('.loader').fadeIn();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
		url: urlActual+"/" + id + "/delete",
		data: formData,
		dataType: "json",
		success: function(data) {
            $('.loader').fadeOut(225);
            BorrarFormularioConfirmar();
			$('#modalConfirmarAccion').modal("hide");
			puestos_table.ajax.reload();      
			alertify.set('notifier','position', 'top-center');
			alertify.success('El Puesto se Desactivó Correctamente!!');
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

//Desactivar Puesto
/*$(document).on('click', 'a.remove-puesto', function(e) {
    e.preventDefault(); // does not go through with the link.

    var $this = $(this);
    
    alertify.confirm('Desactivar Puesto', 'Esta seguro de desactivar el puesto', 
        function(){
            $.post({
                type: $this.data('method'),
                url: $this.attr('href')
            }).done(function (data) {
                puestos_table.ajax.reload();
                    alertify.set('notifier','position', 'top-center');
                    alertify.success('Puesto Desactivado con Éxito!!');
            }); 
         }
        , function(){
            alertify.set('notifier','position', 'top-center'); 
            alertify.error('Cancel')
        });   
});*/
