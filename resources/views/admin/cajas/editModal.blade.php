<!-- Modal -->
<div class="modal fade" id="modalUpdateCaja" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <form method="POST" id="CajaUpdateForm">
      {{ method_field('put') }}

    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Editar Caja</h4>
          </div>
          <div class="modal-body">
            <div class="row">

              <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                <label for="nombre">Nombre Caja:</label>
                <input type="text" name="nombre" placeholder="Ingrese Nombre" class="form-control" value="{{old('nombre')}}">
                {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
              </div>

            </div>
            <br>

            <input type="hidden" name="_token" id="tokenCajaEdit" value="{{ csrf_token() }}">
            <input type="hidden" name="id">
            
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            <button type="submit" class="btn btn-primary" id="ButtonCajaModalUpdate" >Actualizar</button>
          </div>
        </div>
      </div>
  </form>
</div>

@push('scripts')
  <script>

    $.validator.addMethod("nombreUnicoEdit", function(value, element) {
      var valid = false;
      var id = $("input[name='id']").val();
      $.ajax({
        type: "GET",
        async: false,
        url: "{{route('cajas.nombreDisponibleEdit')}}",
        data: {"nombre" : value, "id" : id},
        dataType: "json",
        success: function(msg) {
          valid = !msg;
        }
      });
      return valid;
    }, "El nombre de la caja ya está registrado en el sistema");

    function updateModal(button) {
      $('.loader').fadeIn();
      var formData = $("#CajaUpdateForm").serialize();
      //var id = $("input[name='id']").val();
      $.ajax({
        type: "PUT",
        headers: {'X-CSRF-TOKEN': $('#tokenCajaEdit').val()},
        url: "{{route('cajas.update')}}",
        data: formData,
        dataType: "json",
        success: function(data) {
          $('.loader').fadeOut(225);
          $('#modalUpdateCaja').modal("hide");
          cajas_table.ajax.reload();
          alertify.set('notifier','position', 'top-center');
          alertify.success('Caja Editada con Éxito!!');
        },
        error: function(errors) {
          $('.loader').fadeOut(225);
          var errors = JSON.parse(errors.responseText);
          if (errors.email != null) {
            $("#CajaUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
          }
          else{
            $("#ErrorNombreedit").remove();
          }
        }
        
      });
    }

  </script>
@endpush