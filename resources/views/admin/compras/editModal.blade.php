<!-- Modal -->
<div class="modal fade" id="modalUpdateCompra" role="dialog" aria-labelledby="myModalLabel">
  <form method="POST" id="CompraUpdateForm">
      {{ method_field('put') }}

    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Detalle</h4>
          </div>
          <div class="modal-body">
            <div class="row">

              <div class="col-sm-4">
                <label>Fecha de Factura</label>    
                <input name="fecha_factura" type="date" class="form-control" id="datepickerF">
              </div>
   
              <div class="form-group col-sm-4">
                <label for="serie">Serie</label>
                <input type="text" name="serie" placeholder="Serie" class="form-control">
              </div>

              <div class="form-group col-sm-4">
                <label for="numero_doc">Número de Documento</label>
                <input type="text" name="numero_doc" placeholder="Número de Documento" class="form-control">
              </div>
    
            </div>
            <br>

            <input type="hidden" name="_token" id="tokenCompraEdit" value="{{ csrf_token() }}">
            <input type="hidden" name="id" id="compra_id">
            
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="ButtonCompraModalUpdate" >Actualizar</button>
          </div>
        </div>
      </div>
    </form>
</div>


@push('scripts')
  <script>
    /*$('#datepickerF').datepicker({
      autoclose: true,
      format: 'dd-mm-yyyy'
    });*/
  </script>
@endpush