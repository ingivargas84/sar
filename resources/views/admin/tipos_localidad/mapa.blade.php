@extends('admin.layoutadmin')

@section('header')
<section class="content-header">
    <h1>
      Mapa de Tipos de Localidad
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('tipos_localidad.index')}}"><i class="fa fa-warehouse"></i> Tipos Localidad</a></li>
      <li class="active">Mapa</li>
    </ol>
  </section>

  @endsection

@section('content')

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
            <div class="columna" draggable="true" data-id="{{$i}}">
              <div class="small-box bg-green" style="margin-bottom:0px" data-mesa_id="{{$mesa->id}}">
                <div class="inner">
                  <center>
                    <h3>{{$mesa->nombre}}</h3>
                    <img src="{{asset('images/mesa.svg')}}" draggable="false" id="img_mesa">
                  </center>
                </div>
              </div>   
            </div>

          @else
            <div class="columna" draggable="true" data-id="{{$i}}" >
            </div>             
          
          @endif
        @endfor
               
        </div>
      </div>

      <br>
      <div class="text-right m-t-15">
          <a class='btn btn-primary form-button' href="{{ route('tipos_localidad.index') }}">Regresar</a>
          <button class="btn btn-success form-button" id="btnMapaUpdate">Actualizar</button>
      </div>
      <br>
 
@endsection


@push('styles')
<style>
.contenedor {
    display: grid;
    max-width: 100%;
    padding-bottom: 1.5rem;
    /*justify-content: center;*/
  }
   
  .contenedor > div {
    justify-self:center;
    align-self: center;
    border: 1px dashed #c0c0c0;
  }

  .contenedor > div:hover{
    border: 2px dashed #000;
  }

/*Scroll horizontal*/
.testimonial-group > .contenedor {
  overflow-x: auto;
  white-space: nowrap;
}
.testimonial-group > .contenedor > .columna {
  display: inline-block;
  float: none;
}

::-webkit-scrollbar {
    -webkit-appearance: none;
}
/*::-webkit-scrollbar:vertical {
    width: 12px;
}*/
::-webkit-scrollbar:horizontal {
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
}


@media screen and (max-width:640px) {
  .columna{
    width:3.2rem; 
    height:3.2rem
  }
  .small-box{
    width:3rem; 
    height:3rem
  }
  #img_mesa{
    width:1.2rem;
  }
  .small-box h3{
    font-size: 0.7rem !important;
    margin-bottom: 0.1rem !important;
  }
  .small-box .inner{
    padding: 0.3rem !important;
  }
  .contenedor > div:hover{
    border: 1.2px dashed #000;
  }

  .container-fluid{
    padding: 0.5rem !important;
  }
}
@media screen and (max-width:1024px) and (min-width:640px) {
  .columna{
    width:5.8rem; 
    height:5rem
  }
  .small-box{
    width:5.5rem; 
    height:4.7rem
  }
  #img_mesa{
    width:2rem;
  }
  .small-box h3{
    font-size: 1rem !important;
    margin-bottom: 0.4rem !important;
  }
  .small-box .inner{
    padding: 0.5rem !important;
  }
}
@media screen and (min-width:1024px) {
  .columna{
    width:8.3rem; 
    height:7.4rem
  }
  .small-box{
    width:8rem; 
    height:7rem
  }
  #img_mesa{
    width:3.5rem;
  }
  .small-box h3{
    font-size: 1.7rem !important;
    margin-bottom: 0.7rem !important;
  }
  .small-box .inner{
    padding: 0.8rem !important;
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
  <script src="{{asset('js/tipos_localidad/mapa.js')}}"></script>
  <script src="{{asset('js/DragDropTouch.js')}}"></script>
  
@endpush