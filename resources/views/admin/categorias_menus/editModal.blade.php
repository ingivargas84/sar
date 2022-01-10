<!-- Modal -->
<div class="modal fade" id="modalUpdateCategoriaMenu" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="CategoriaMenuUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Categoria de Menú</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre Categoria de Menú:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenCategoriaMenuEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonCategoriaMenuModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
        </form>
          </div>