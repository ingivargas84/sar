<!-- Modal -->
<div class="modal fade" id="modalCambiarOrden" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  {!! Form::open( array( 'id' => 'CambiarOrdenForm' ) ) !!}

    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Cambiar Orden de Mesa</h4>
          </div>
          <div class="modal-body">

            <div class="row">
              <div class="form-group col-sm-12 {{ $errors->has('mesa_id') ? 'has-error': '' }}">
                <label for="mesa_id">Mesas:</label>
                <select class="form-control" name="mesa_id" id="mesa_id">
                  {{--<option value="">Seleccione Mesa</option>
                      @foreach($mesas as $mesa)
                          <option value="{{ $mesa->id }}">{{ $mesa->nombre }}</option>
                      @endforeach--}}
                </select>
              </div>
            </div>
            <br>
            <input type="hidden" name="_token" id="tokenCambiarOrden" value="{{ csrf_token() }}">
            <input type="hidden" name="mesa_inicio">
            <input type="hidden" name="tipo_localidad" value="{{$tipo_localidad->id}}">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="ButtonCambiarOrdenModal" >Cambiar</button>
          </div>
        </div>
      </div>
  {!! Form::close() !!}
</div>