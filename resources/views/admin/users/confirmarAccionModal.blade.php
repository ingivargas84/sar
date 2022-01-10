<!-- Modal -->
<div class="modal fade" id="modalConfirmarAccion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <form method="POST" id="ConfirmarAccionForm">
        {{--{{ method_field('put') }}--}}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Confirme sus credenciales</h4>
            </div>
            <div class="modal-body">

                <div class="row">
                    <div class="form-group col-sm-12 {{ $errors->has('password_actual') ? 'has-error': '' }}">
                        <label for="password_actual">Contraseña:</label>
                        <input name="password_actual" class="form-control" type="password" placeholder="Ingresa contraseña">
                    </div>
                </div>

              <input type="hidden" name="_token" id="tokenConfirmarAccion" value="{{ csrf_token() }}">
              <input type="hidden" name="id" id="idConfirmacion">
              <input type="hidden" name="pedido_id">
              <input type="hidden" name="orden_id">
              <input type="hidden" name="precio_cuenta">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="btnConfirmarAccion" >Borrar</button>
            </div>
          </div>
        </div>
    </form>
</div>

@push('scripts')
   <script>

    if(window.location.hash === '#confirmar')
    {
        $('#modalConfirmarAccion').modal('show');
    }

    $('#modalConfirmarAccion').on('hide.bs.modal', function(){
        $("#ConfirmarAccionForm").validate().resetForm();
		document.getElementById("ConfirmarAccionForm").reset();
        window.location.hash = '#';

    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(){
        window.location.hash = '#confirmar';

    });
       
       
    var validator = $("#ConfirmarAccionForm").validate({
        ignore: [],
        onkeyup:false,
        onclick: false,
        //onfocusout: false,
        rules: {
            password_actual: {
                required: true
            }

        },
        messages: {
            password_actual: {
                required: "Por favor, ingrese contraseña"
            }
        }
    });

    $('#modalConfirmarAccion').on('shown.bs.modal', function(event){
        var button = $(event.relatedTarget);
        var id = button.data('id');
        var pedido_id = button.data('pedido_id');
        var orden_id = button.data('orden_id');
        var precio = button.data('precio');
        
        var modal = $(this);
        modal.find(".modal-body input[name='id']").val(id);
        modal.find(".modal-body input[name='pedido_id']").val(pedido_id);
        modal.find(".modal-body input[name='orden_id']").val(orden_id);
        modal.find(".modal-body input[name='precio_cuenta']").val(precio);

    });

    function BorrarFormularioConfirmar() {
        $("#ConfirmarAccionForm :input").each(function () {
            $(this).val('');
        });
    };


    </script>
@endpush