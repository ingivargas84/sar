<!-- Modal -->
<div class="modal fade" id="modalCierre" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'CierreForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header modal-header-danger">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Cierre de Caja</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="monto">Monto de Apertura</label>
                  <input type="number" name="monto" placeholder="" class="form-control" disabled>
                </div>
                <div class="form-group col-sm-6">
                  <label for="monto_cierre">Monto de Cierre</label>
                  <input type="number" name="monto_cierre" placeholder="" class="form-control" disabled>
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="nombre">Cajero</label>
                  <input type="text" name="nombre_cajero" placeholder="" class="form-control" disabled>
                </div>

                <div class="form-group col-sm-6">
                  <label for="efectivo">Efectivo real</label>
                  <input type="number" name="efectivo" placeholder="Ingrese efectivo real" class="form-control" value="0" min="0">
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="faltante">Faltante</label>
                  <input type="number" name="faltante" placeholder="0.00" class="form-control" disabled>
                </div>
                <div class="form-group col-sm-6">
                  <label for="sobrante">Sobrante</label>
                  <input type="number" name="sobrante" placeholder="0.00" class="form-control" disabled>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="password_admin_cierre">Confirme contraseña</label>
                  <input type="password" name="password_admin_cierre" placeholder="Ingrese Nombre de Puesto" class="form-control" value="{{old('password_admin_cierre')}}">
                </div>
              </div>
              <input type="hidden" name="_token" id="tokenCierre" value="{{ csrf_token() }}">
              <input type="hidden" name="caja_id">
              <input type="hidden" name="apertura_id">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Salir</button>
              <button type="submit" class="btn btn-primary" id="ButtonCierreModal" >Cerrar Caja</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
</div>