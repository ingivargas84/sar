<!-- Modal -->
<div class="modal fade" id="modalUpdateRecetaDetalle" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form method="POST" id="RecetaDetalleUpdateForm">
      {{ method_field('put') }}

    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Detalle</h4>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="form-group col-sm-6">
                <label for="insumo_id">Insumo:</label>
                <select class="form-control" name="insumo_id" id="insumo_id">
                </select>
              </div>
    
              <div class="form-group col-sm-6">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" placeholder="Cantidad" class="form-control">
              </div>
    
              {{--<div class="form-group col-sm-4">
                <label for="unidad_medida_id">Unidad de Medida:</label>
                <select class="form-control" name="unidad_medida_id" id="unidad_medida_id" disabled>
                  <option value="">Selecciona Unidad de Medida</option>
                      @foreach($unidades as $medida)
                          <option value="{{ $medida->id }}">{{ $medida->nombre }}</option>
                      @endforeach
                </select>
              </div>--}}
            </div>
            <br>

            <input type="hidden" name="_token" id="tokenRecetaDetalleEdit" value="{{ csrf_token() }}">
            <input type="hidden" name="id">
            
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="ButtonRecetaDetalleModalUpdate" >Actualizar</button>
          </div>
        </div>
      </div>
    </form>
</div>


@push('scripts')
  <script>
  function cargarSelectInsumo(insumo_id, receta_id){
	$('#insumo_id').empty();
	//$("#insumo_id").append('<option value="" selected>Seleccione Insumo</option>');
	$.ajax({
		type: "GET",
		url: "{{route('insumos.cargar2')}}", 
		dataType: "json",
		data: {'insumo_id' : insumo_id, 'receta_id': receta_id},
		success: function(data){
      $('.loader').fadeOut(225);
		  $.each(data,function(key, registro) {
			  if(registro.id == insumo_id){
				$("#insumo_id").append('<option value='+registro.id+' selected>'+registro.nombre+'</option>');
				
			  }else{
				$("#insumo_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
			  }	
		  });
		},
		error: function(data) {
			$('.loader').fadeOut(225);
		  	alert('error');
		}
	  });
    }
  </script>
@endpush