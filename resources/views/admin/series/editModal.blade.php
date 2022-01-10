<!-- Modal -->
<div class="modal fade" id="modalUpdateSerie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <form method="POST" id="SerieUpdateForm">
            {{ method_field('put') }}
    
          <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Editar Serie</h4>
                </div>
                <div class="modal-body">
                 
                  <div class="row">
                    <div class="col-sm-6 form-group ">
                      {!! Form::label("resolucion","Resolución:") !!}
                      {!! Form::text( "resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Resolución:' ,'id'=>'resolucione' ]) !!}
                      
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label("serie","Serie:") !!}
                      {!! Form::text( "serie" , null , ['class' => 'form-control' , 'placeholder' => 'Serie:' ,'id'=>'seriee' ]) !!}
                    </div>
                    
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-6">
                      {!! Form::label("fecha_resolucion","Fecha Resolución:") !!}
                      {!! Form::date( "fecha_resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Resolución','id'=>'fechare' ]) !!}
                    </div>
                    
                    <div class="col-sm-6">
                      {!! Form::label("fecha_vencimiento","Fecha de Vencimiento:") !!}
                      {!! Form::date( "fecha_vencimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Vencimiento','id'=>'fechave' ]) !!}
                    </div>
                    
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-sm-6">
                      {!! Form::label("inicio","Número Inicio:") !!}
                      {!! Form::number( "inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Número Inicio', 'id' => 'inicio', 'id'=>'inicioe' ]) !!}
                    </div>
                    <div class="col-sm-6">
                      {!! Form::label("fin","Número Fin:") !!}
                      {!! Form::number( "fin" , null , ['class' => 'form-control' , 'placeholder' => 'Número Fin', 'id'=>'fine' ]) !!}
                    </div>
                  </div>
                  <br>
    
                  <input type="hidden" name="_token" id="tokenSerieEdit" value="{{ csrf_token() }}">
                  <input type="hidden" name="id" id="serie_id">
                  
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                  <button type="submit" class="btn btn-primary" id="ButtonSerieModalUpdate" >Actualizar</button>
                </div>
              </div>
            </div>
      </form>
  </div>