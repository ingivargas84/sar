  $( function() {
    $( "#body_espera, #body_preparacion, #body_preparado" ).sortable({
      connectWith: "#body_espera, #body_preparacion, #body_preparado",
      update: function(){
        //var ordenElementos = $(this).sortable("toArray").toString(); 
        //var espera = $("#body_espera").sortable('toArray', {attribute: "data-id"});
        var espera = $("#body_espera").sortable('toArray', {attribute: "data-id"});
        var preparacion = $("#body_preparacion").sortable('toArray', {attribute: "data-id"} );
        var preparado = $("#body_preparado").sortable('toArray', {attribute: "data-id"});
        
        $.ajax({ 
            type: "POST",
            url: APP_URL+"/ordenes_cocina/actualizar_estado",
            data: {'espera': espera, 'preparacion': preparacion, 'preparado': preparado},
            dataType: "json",
            success: function(data) {
                //$('.loader').fadeOut(225);
              //alertify.set('notifier','position', 'top-center');
              //alertify.success('Actualizado correctamente!!');
            },
            error: function() {
                //$('.loader').fadeOut(225);
                alert("Ocurrio un error Contacte al Administrador!");
            }
        });
        //console.log(ordenElementos);
      },
    }).disableSelection();
  } );