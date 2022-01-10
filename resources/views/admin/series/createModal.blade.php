<!-- Modal -->
<div class="modal fade" id="modalSerie" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    {!! Form::open( array( 'id' => 'SerieForm' ) ) !!}

      <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title" id="myModalLabel">Agregar Serie de Factura</h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-sm-6 form-group ">
                  {!! Form::label("resolucion","Resolución:") !!}
                  {!! Form::text( "resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Resolución:' ]) !!}
                  
                </div>
                <div class="col-sm-6">
                  {!! Form::label("serie","Serie:") !!}
                  {!! Form::text( "serie" , null , ['class' => 'form-control' , 'placeholder' => 'Serie:' ]) !!}
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("fecha_resolucion","Fecha Resolución:") !!}
                  {!! Form::date( "fecha_resolucion" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha Resolución', 'id'=>'fecha_resolucion' ]) !!}
                </div>
                
                <div class="col-sm-6">
                  {!! Form::label("fecha_vencimiento","Fecha de Vencimiento:") !!}
                  {!! Form::date( "fecha_vencimiento" , null , ['class' => 'form-control' , 'placeholder' => 'Fecha de Vencimiento', 'id' =>'fecha_vencimiento']) !!}
                </div>
                
              </div>
              <br>
              <div class="row">
                <div class="col-sm-6">
                  {!! Form::label("inicio","Número Inicio:") !!}
                  {!! Form::number( "inicio" , null , ['class' => 'form-control' , 'placeholder' => 'Número Inicio', 'id' => 'inicio']) !!}
                </div>
                <div class="col-sm-6">
                  {!! Form::label("fin","Número Fin:") !!}
                  {!! Form::number( "fin" , null , ['class' => 'form-control' , 'placeholder' => 'Número Fin']) !!}
                </div>
              </div>
  
              <br>
              <input type="hidden" name="_token" id="tokenSerie" value="{{ csrf_token() }}">
              
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
              <button type="submit" class="btn btn-primary" id="ButtonSerieModal" >Agregar</button>
            </div>
          </div>
        </div>
    {!! Form::close() !!}
      </div>


