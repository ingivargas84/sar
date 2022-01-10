<!-- Modal -->
<div class="modal fade" id="modalUpdateTipoLocalidad" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="TipoLocalidadUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Tipo de Localidad</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-4 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre Tipo de Localidad:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre Tipo de Localidad" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="columnas">Columnas</label>
                      <input type="number" name="columnas" placeholder="Ingrese número de columnas" class="form-control">
                    </div>

                    <div class="form-group col-sm-4">
                      <label for="filas">Filas</label>
                      <input type="number" name="filas" placeholder="Ingrese numero de Filas" class="form-control">
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenTipoLocalidadEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonTipoLocalidadModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
          </div>