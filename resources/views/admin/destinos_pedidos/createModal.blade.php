<!-- Modal -->
<div class="modal fade" id="modalDestino" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'DestinoForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Destino</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('destino') ? 'has-error': '' }}">
                  <label for="destino">Nombre de Destino:</label>
                  <input type="text" name="destino" placeholder="Ingrese Nombre de Destino" class="form-control" value="{{old('destino')}}">
                  {!! $errors->first('destino', '<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenDestino" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonDestinoModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>