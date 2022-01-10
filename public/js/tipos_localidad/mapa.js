var columnas  = $("input[name='numero_columnas']").val();
$(".contenedor").css("grid-template-columns", "repeat("+columnas+", 1fr)");

/*$(window).resize(function(){     

  if ($('header').width() <= 640 ){

    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 6.4rem)");  
  }
  else if($('header').width() > 640 && $('header').width() <= 1024){
    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 11.5rem)");  
  }
  else if($('header').width() > 1024){
    $(".contenedor").css("grid-template-columns", "repeat("+columnas+", 15.5rem)");
  }

});*/


var dragSrcEl = null;

function handleDragStart(e) {
  // Target (this) element is the source node.
  this.style.opacity = '0.4';

  dragSrcEl = this;

  e.dataTransfer.effectAllowed = 'move';
  e.dataTransfer.setData('text/html', this.innerHTML);
}

function handleDragOver(e) {
  if (e.preventDefault) {
    e.preventDefault(); // Necessary. Allows us to drop.
  }

  e.dataTransfer.dropEffect = 'move';  // See the section on the DataTransfer object.
  return false;
}

function handleDragEnter(e) {
  // this / e.target is the current hover target.
  this.classList.add('over');
}

function handleDragLeave(e) {
  this.classList.remove('over');  // this / e.target is previous target element.
}


function handleDrop(e) {
  // this/e.target is current target element.

  if (e.stopPropagation) {
    e.stopPropagation(); // Stops some browsers from redirecting.
  }

  // Don't do anything if dropping the same column we're dragging.
  if (dragSrcEl != this) {
    // Set the source column's HTML to the HTML of the columnwe dropped on.
    dragSrcEl.innerHTML = this.innerHTML;
    this.innerHTML = e.dataTransfer.getData('text/html');
  }

  return false;
}

function handleDragEnd(e) {
  // this/e.target is the source node.
  this.style.opacity = '1';
  [].forEach.call(cols, function (col) {
    col.classList.remove('over');
  });
}

var cols = document.querySelectorAll('#contenedor_id .columna');

[].forEach.call(cols, function(col) {
  col.addEventListener('dragstart', handleDragStart, false);
  col.addEventListener('dragenter', handleDragEnter, false)
  col.addEventListener('dragover', handleDragOver, false);
  col.addEventListener('dragleave', handleDragLeave, false);
  col.addEventListener('drop', handleDrop, false);
  col.addEventListener('dragend', handleDragEnd, false);
});

var posiciones = [];

$("#btnMapaUpdate").click(function(event){
  event.preventDefault();
    $(".columna").each(function(){
      var posicion = $(this).data("id");
      var mesa_id = $(this).children(".small-box").data("mesa_id");

      if(mesa_id != undefined)
      {
        var posicionDetalle = new Object();
        posicionDetalle.mesa_id = mesa_id;
        posicionDetalle.posicion = posicion;
        posiciones.push(posicionDetalle);  
      }

    });
    $('.loader').fadeIn();
      $.ajax({ 
          type: "POST",
          url: APP_URL+"/tipos_localidad/mapa/update",
          data: {posiciones},
          dataType: "json",
          success: function(data) {
              $('.loader').fadeOut(225);
            alertify.set('notifier','position', 'top-center');
            alertify.success('Actualizado correctamente!!');
          },
          error: function() {
              $('.loader').fadeOut(225);
              alert("Ocurrio un error Contacte al Administrador!");
          }
      });
  });