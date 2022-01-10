<!-- Modal -->
<div class="modal fade" id="modalEstado" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form method="POST" id="AsignaForm">
      {{--{{ method_field('put') }}--}}

    <div class="modal-dialog" role="document">
          <div class="modal-content">

            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Cambio de estado de Serie</h4>
            </div>

            <div class="modal-body">

              <div class="row">     
                <div class="form-group col-sm-12 {{ $errors->has('usuarios') ? 'has-error': '' }}">
                  <label for="estado">Estado:</label>
                  <select class="form-control" name="estado" title="Seleccione" id="estado">
                  </select>
                  {!! $errors->first('usuarios', '<span class="help-block">:message</span>') !!}
                </div>
              </div>

              <input type="hidden" name="_token" id="tokenAsignar" value="{{ csrf_token() }}">
              <input type="hidden" name="id" id="idestado">
              <input type="hidden" name="estado_id" id="estado_id">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnAsignaModal" >Asignar</button>
            </div>
          </div>
    </div>
  </form>
</div>
