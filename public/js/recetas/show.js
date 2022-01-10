//var receta = $('#receta').text();
var recetasdetalle_table = $('#recetasdetalle-table').DataTable({
    //"ajax": "/recetasdetalle/"+receta+"/getJson",
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
        "width" : "10%",
        "responsivePriority": 1,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
    
    {
        "title": "Insumo",
        "data": "nombre",
        "width" : "15%",
        "responsivePriority": 2,
        "render": function( data, type, full, meta ) {
            return (data);},
    },

    {
        "title": "Cantidad",
        "data": "cantidad",
        "width" : "15%",
        "responsivePriority": 3,
        "render": function( data, type, full, meta ) {
            return (data);},
    }, 

    {
        "title": "Unidad de Medida",
        "data": "unidad_medida",
        "width" : "15%",
        "responsivePriority": 4,
        "render": function( data, type, full, meta ) {
            return (data);},
    },
         
    {
        "title": "Acciones",
        "orderable": false,
        "width" : "25%",
        "render": function(data, type, full, meta) {

        return "<div id='" + full.id + "' class='text-center'>" + 
        "<div class='float-left col-lg-6'>" + 
        "<a href='#' class='editar-detalle' data-toggle='modal' data-target='#modalUpdateRecetaDetalle' data-id='"+full.id+"' data-insumo_id='"+full.insumo_id+"' data-cantidad='"+full.cantidad+"' data-unidad_medida_id='"+full.unidad_medida_id+"'>" + 
        "<i class='fa fa-btn fa-edit' title='Editar Detalle'></i>" + 
        "</a>" + "</div>"+
        "<div class='float-right col-lg-6'>" + 
        "<a href='#' class='remove-receta-detalle'"+ "data-method='delete'  data-toggle='modal' data-id='"+full.id+"' data-target='#modalConfirmarAccion' >" + 
        "<i class='fa fa-trash' title='Eliminar Detalle de Receta'></i>" + 
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
    $('.loader').fadeIn();	
    var formData = $("#ConfirmarAccionForm").serialize();
    var id = $("#idConfirmacion").val();
    var receta_id = $('#receta').text();
	var urlActual =  $("input[name='urlActual']").val();
	var urlNueva = urlActual.replace("/"+receta_id, "");
  $.ajax({
    type: "POST",
    headers: {'X-CSRF-TOKEN': $('#tokenReset').val()},
    url: urlNueva+"/"+id +"/delete",
    data: formData,
    dataType: "json",
    success: function(data) {
      $('.loader').fadeOut(225);
      $('#modalConfirmarAccion').modal("hide");
      recetasdetalle_table.ajax.reload();      
      alertify.set('notifier','position', 'top-center');
      alertify.success('El Detalle se elimino Correctamente!!');
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


