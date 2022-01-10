<!-- Modal -->
<div class="modal fade" id="modalCategoriaInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'CategoriaInsumoForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Categoria</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Nombre de Categoria:</label>
                  <input type="text" name="nombre" placeholder="Ingrese Nombre de Categoria" class="form-control" value="{{old('nombre')}}">
                  {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenCategoriaInsumo" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonCategoriaInsumoModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>

@push('scripts')
  <script>

  $.validator.addMethod("nombreUnico", function(value, element) {
    var valid = false;
    $.ajax({
      type: "GET",
      async: false,
      url: "{{route('categorias_insumos.nombreDisponible')}}",
      data: "nombre=" + value,
      dataType: "json",
      success: function(msg) {
        valid = !msg;
      }
    });
    return valid;
  }, "El nombre de la categoria ya está registrado en el sistema");

  function saveModal(button) {
  $('.loader').fadeIn();	
	var formData = $("#CategoriaInsumoForm").serialize();
	$.ajax({
		type: "POST",
		headers: {'X-CSRF-TOKEN': $('#tokenCategoriaInsumo').val()},
		url: "{{route('categorias_insumos.save')}}",
		data: formData,
		dataType: "json",
		success: function(data) {
      $('.loader').fadeOut(225);
			$('#modalCategoriaInsumo').modal("hide");
			categorias_insumos_table.ajax.reload();
			alertify.set('notifier','position', 'top-center');
			alertify.success('Categoria de Insumo Creada con Éxito!!');
			
		},
		error: function(errors) {
      $('.loader').fadeOut(225);
			var errors = JSON.parse(errors.responseText);
			if (errors.nombre != null) {
				$("#CategoriaInsumoForm input[name='nombre'] ").after("<label class='error' id='ErrorNombre'>"+errors.nombre+"</label>");
			}
			else{
				$("#ErrorNombre").remove();
			}
		}
		
	});
}

  </script>
@endpush