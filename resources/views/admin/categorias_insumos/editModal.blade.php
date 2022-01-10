<!-- Modal -->
<div class="modal fade" id="modalUpdateCategoriaInsumo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="CategoriaInsumoUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Categoria de Insumo</h4>
                </div>
                <div class="modal-body">
                  <div class="row">

                    <div class="form-group col-sm-12 {{ $errors->has('nombre') ? 'has-error': '' }}">
                      <label for="nombre">Nombre Categoria de Insumo:</label>
                      <input type="text" name="nombre" placeholder="Ingrese Nombre" class="form-control" value="{{old('nombre')}}">
                      {!! $errors->first('nombre', '<span class="help-block">:message</span>') !!}
                    </div>

                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenCategoriaInsumoEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonCategoriaInsumoModalUpdate" >Actualizar</button>
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
      url: "{{route('categorias_insumos.nombreDisponibleEdit')}}",
      data: {"nombre" : value, "id" : id},
      dataType: "json",
      success: function(msg) {
        valid = !msg;
      }
    });
    return valid;
  }, "El nombre de la categoria ya está registrado en el sistema");

  function updateModal(button) {
    $('.loader').fadeIn();	
    var formData = $("#CategoriaInsumoUpdateForm").serialize();
    //var id = $("input[name='id']").val();
    $.ajax({
      type: "PUT",
      headers: {'X-CSRF-TOKEN': $('#tokenCategoriaInsumoEdit').val()},
      url: "{{route('categorias_insumos.update')}}",
      data: formData,
      dataType: "json",
      success: function(data) {
        $('.loader').fadeOut(225);
        $('#modalUpdateCategoriaInsumo').modal("hide");
        categorias_insumos_table.ajax.reload();
        alertify.set('notifier','position', 'top-center');
        alertify.success('Categoria de Insumo Editada con Éxito!!');
      },
      error: function(errors) {
        $('.loader').fadeOut(225);
        var errors = JSON.parse(errors.responseText);
        if (errors.email != null) {
          $("#CategoriaInsumoUpdateForm input[name='email'] ").after("<label class='error' id='ErrorNombreedit'>"+errors.email+"</label>");
        }
        else{
          $("#ErrorNombreedit").remove();
        }
      }
      
    });
  }
  </script>
@endpush