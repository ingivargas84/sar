<!-- Modal -->
<div class="modal fade" id="modalTipoPago" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'TipoPagoForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Tipo de Pago</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                  <label for="nombre">Nombre de Tipo de Pago:</label>
                  <input type="text" name="nombre" placeholder="Ingrese Nombre de Tipo de Pago" class="form-control" value="{{old('nombre')}}">
                  {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenTipoPago" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonTipoPagoModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
</div>