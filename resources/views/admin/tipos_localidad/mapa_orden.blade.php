@extends('admin.layoutmeseros')

@section('header')
  <section class="content-header">
  </section>

@endsection

@section('content')
@include('admin.users.confirmarAccionModal')
@include('admin.tipos_localidad.cambiarOrden')
<div class="loader loader-bar is-active"></div>
  <input type="hidden" name="numero_columnas" value="{{$tipo_localidad->columnas}}">
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}

      <div class="testimonial-group container-fluid">
        <div id="contenedor_id" class="contenedor">        
        @for($i= 0; $i <= $tipo_localidad->filas * $tipo_localidad->columnas -1; $i++)

        @php
          $mesa = $localidades->where('posicion', $i)->first();
        @endphp  
        
          @if($mesa != null )
            
              <div class="columna" data-id="{{$i}}">
                
                @if($mesa->ocupada == 1)
                  @php
                    $orden_maestro = App\OrdenMaestro::where('localidad_id', $mesa->id)->where('estado_id', 1)->first();
                  @endphp
                
                @if($orden_maestro)
                  <div class="small-box bg-red" style="margin-bottom:0px;" data-mesa_id="{{$mesa->id}}">
                    <button class="btn btn-danger btn-xs liberar" data-target='#modalConfirmarAccion' data-id="{{$mesa->id}}"><span class="fa fa-lock-open" data-toggle="tooltip" data-placement="top" title="Liberar"></span></button>  
                    <a class="btn btn-danger btn-xs" data-toggle="modal" data-target='#modalCambiarOrden' data-id="{{$mesa->id}}"><span class="fa fa-exchange-alt" data-toggle="tooltip" data-placement="top" title="Cambiar pedido"></span></a>
                      <a href="#" onclick="nuevaOrden({{$mesa->id}},{{$mesa->ocupada}} )" class="link-personal">
                        <div class="inner">
                          <center>
                            <h3>{{$mesa->nombre}}</h3>
                              <img src="{{asset('images/mesa.svg')}}" id="img_mesa">
                          </center>
                        </div>
                      </a>
                  </div>
                @else
                  <div class="small-box bg-yellow" style="margin-bottom:0px;" data-mesa_id="{{$mesa->id}}">
                    <button class="btn btn-warning btn-xs liberar" data-target='#modalConfirmarAccion' data-id="{{$mesa->id}}"><span class="fa fa-lock-open" data-toggle="tooltip" data-placement="top" title="Liberar"></span></button>  
                      <a href="#" onclick="nuevaOrden({{$mesa->id}},{{$mesa->ocupada}} )" class="link-personal">
                        <div class="inner">
                          <center>
                            <h3>{{$mesa->nombre}}</h3>
                              <img src="{{asset('images/mesa.svg')}}" id="img_mesa">
                          </center>
                        </div>
                      </a>
                  </div>
                @endif
                
                @else
                <div class="small-box bg-green" style="margin-bottom:0px;" data-mesa_id="{{$mesa->id}}">
                  <a href="{{route('localidades.bloquear', $mesa->id)}}" class="btn btn-success btn-xs" data-toggle="tooltip" data-placement="top" title="Bloquear"><span class="fa fa-lock"></span></a>

                    <a href="#" onclick="nuevaOrden({{$mesa->id}},{{$mesa->ocupada}} )" class="link-personal">
                      <div class="inner">
                        <center>
                          <h3>{{$mesa->nombre}}</h3>
                            <img src="{{asset('images/mesa.svg')}}" id="img_mesa">
                        </center>
                      </div>
                    </a>
                </div>
                @endif
              </div>
            

          @else
            <div class="columna" data-id="{{$i}}" >
            </div>             
          
          @endif
        @endfor
               
        </div>
      </div>
      <br>
      <div class="text-right m-t-15">
          <a class='btn btn-primary form-button' href="{{ route('ordenes.index') }}">Regresar</a>
      </div>
 
@endsection


@push('styles')
<style>
  .link-personal{
    color:white;
  }
  .link-personal:hover{
    color:#feffe6;
  }
.contenedor {
    display: grid;
    max-width: 100%;
    padding-bottom: 1.5rem;
    /*justify-content: center;*/
  }
   
  .contenedor > div {
    justify-self:center;
    align-self: center;
  }

  /*.contenedor > div:hover{
    border: 2px dashed #000;
  }*/

/*Scroll horizontal*/
.testimonial-group > .contenedor {
  overflow-x: auto;
  white-space: nowrap;
}
.testimonial-group > .contenedor > .columna {
  display: inline-block;
  float: none;
}

/*::-webkit-scrollbar {
    -webkit-appearance: none;
}
/*::-webkit-scrollbar:vertical {
    width: 12px;
}*/
/*::-webkit-scrollbar:horizontal {
    height: 1.5rem;
}
::-webkit-scrollbar-thumb {
    background-color: rgba(0, 0, 0, .5);
    border-radius: 10px;
    border: 2px solid #ffffff;
}
::-webkit-scrollbar-track {
    border-radius: 10px;
    background-color: #ffffff;
}*/


@media screen and (max-width:640px) {
  .columna{
    width:6.2rem; 
    height:5.8rem
  }
  .small-box{
    width:6rem; 
    height:5.4rem
  }
  #img_mesa{
    width:1.5rem;
  }
  .small-box h3{
    font-size: 1rem !important;
    margin-bottom: 0.1rem !important;
  }
  .container-fluid{
    padding: 0.3rem !important;
  }
}
@media screen and (max-width:1024px) and (min-width:640px) {
  .columna{
    width:9.5rem; 
    height:7.7rem
  }
  .small-box{
    width:9rem; 
    height:7.2rem
  }
  #img_mesa{
    width:3rem;
  }
  .small-box h3{
    font-size: 1.5rem !important;
    margin-bottom: 0.5rem !important;
  }
  .container-fluid{
    padding: 0.3rem !important;
  }
}
@media screen and (min-width:1024px) {
  .columna{
    width:10rem; 
    height:8.8rem
  }
  .small-box{
    width:9.5rem; 
    height:8.5rem
  }
  #img_mesa{
    width:4rem;
  }
  .small-box h3{
    font-size: 2rem !important;
    margin-bottom: 0.5rem !important;
  }
  .container-fluid{
    padding: 0.3rem !important;
  }
}
</style> 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
  </script>
  <script src="{{asset('js/tipos_localidad/mapa_orden.js')}}"></script>
  
@endpush