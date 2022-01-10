<!-- Modal -->
<div class="modal fade" id="modalUpdateUnidadMedida" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="UnidadMedidaUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar UnidadMedida</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-6 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre de Unidad de Medida:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre de UnidadMedida" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>
                    <div class="form-group col-sm-6 {{ $errors->has('abreviatura') ? 'has-error': '' }}">
                      <label for="abreviatura">Abreviatura:</label>
                      <input type="text" name="abreviatura" placeholder="Abreviatura" class="form-control" value="{{old('abreviatura')}}">
                      {!! $errors->first('abreviatura', '<span class="help-block">:message</span>') !!}
                    </div>

                  </div>
                  <br>
                  <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('descripcion') ? 'has-error': '' }}">
                      <label for="descripcion">Descripción:</label>
                      <input type="text" name="descripcion" placeholder="Descripción" class="form-control" value="{{old('descripcion')}}">
                      {!! $errors->first('descripcion', '<span class="help-block">:message</span>') !!}
                    </div>
                  </div>
    
                  <input type="hidden" name="_token" id="tokenUnidadMedidaEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonUnidadMedidaModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
          </div>