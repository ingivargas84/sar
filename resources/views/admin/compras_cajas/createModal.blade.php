<!-- Modal -->
<div class="modal fade" id="modalCompraCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'CompraCajaForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Compra</h4>
            </div>
            <div class="modal-body">

              <div class="row">
                <div class="form-group col-sm-6">
                    <label for="caja_id">Caja:</label>
                    <select class="form-control" name="caja_id">
                      <option value="" selected disabled>Seleccione Caja</option>
                          @foreach($cajas as $caja)
                              <option value="{{ $caja->id }}">{{ $caja->nombre }}</option>
                          @endforeach
                    </select>
                </div>
                <div class="form-group col-sm-6">
                  <label for="documento">Documento</label>
                  <input type="text" name="documento" placeholder="Documento" class="form-control" value="{{old('documento')}}">
                </div>
              </div>

              <div class="row">
                <div class="form-group col-sm-6">
                  <label for="numero_doc">Número de Documento</label>
                  <input type="text" name="numero_doc" placeholder="Documento" class="form-control" value="{{old('numero_doc')}}">
                </div>
                <div class="form-group col-sm-6">
                  <label for="total">Total</label>
                  <input type="number" name="total" placeholder="Total" class="form-control" value="{{old('total')}}" min="0">
                </div>
              </div>
              <div class="row">
                <div class="form-group col-sm-12">
                  <label for="descripcion">Descripción</label>
                  <input type="text" name="descripcion" placeholder="Descripción" class="form-control" value="{{old('descripcion')}}">
                </div>
              </div>
              <br>
              <input type="hidden" name="_token" id="tokenCompraCaja" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonCompraCajaModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
</div>