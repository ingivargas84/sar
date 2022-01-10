<!-- Modal -->
<div class="modal fade" id="modalUpdateLocalidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="LocalidadUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Localidad</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre Localidad:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group col-sm-6 {{ $errors->has('tipo_localidad_id') ? 'has-error': '' }}">
                      <label for="tipo_localidad_id">Tipo de Localidad:</label>
                      <select class="form-control select2" name="tipo_localidad_id" id="tipo_localidad_id">
                      </select>
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenLocalidadEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  <input type="hidden" name="tipo_id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonLocalidadModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
</div>

@push('scripts')
    <script>
    function cargarSelectTipoLocalidad(){
    $('#tipo_localidad_id').empty();
    $("#tipo_localidad_id").append('<option value="" selected>Seleccione Tipo de Localidad</option>');
    var tipo_id = $("input[name='tipo_id']").val();
    $.ajax({
      type: "GET",
      url: "{{route('tipos_localidad.cargar')}}", 
      dataType: "json",
      success: function(data){
        $.each(data,function(key, registro) {
          if(registro.id == tipo_id){
          $("#tipo_localidad_id").append('<option value='+registro.id+' selected>'+registro.nombre+'</option>');
          
          }else{
          $("#tipo_localidad_id").append('<option value='+registro.id+'>'+registro.nombre+'</option>');
          }	
          
        });
    
      },
      error: function(data) {
        alert('error');
      }
      });
    }
    </script>
@endpush