@extends('admin.layoutmeseros')

@section('navbar-header')
<a href="#" class="navbar-brand"><b>{{$nombre_destino}}</b></a>
@endsection

@section('header')
@endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>


<div class="row">

    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
              <h3 class="box-title">En Espera</h3>
                  <div class="box-tools pull-right">
                      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                      </button>
                  </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_espera">
                {{--<div class="box box-default tarjeta">
                    <div class="box-body">
                        <div class="col-sm-5 text-left"><p>Waro</p></div>
                    </div>
                </div>
                <div class="tarjeta">Element</div>--}}

                @foreach ($productos_espera as $detalle)
                  <div class="box" data-id="{{$detalle->id}}">
                    <div class="box-body">
                      <div class="col-sm-4">
                          <strong>{{$detalle->nombre_producto}}</strong>
                      </div>
                      <div class="col-sm-4">
                        <label for="">Cantidad:  </label>  
                        {{$detalle->cantidad}}
                      </div>
                      <div class="col-sm-4">
                        <label for="">Mesa:  </label>  
                        {{$detalle->mesa}}
                      </div>
                      <div class="col-sm-12">
                          {{$detalle->comentario}}
                      </div>                        
                        
                    </div>
                  </div>                    
                @endforeach
                  
            </div>

            
        </div>               
    </div>

    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">En Preparación</h3>                    
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_preparacion">
                {{--<div class="box box-success">
                    <div class="box-body">
                        
                    </div>
                </div>--}}

                @foreach ($productos_preparacion as $detalle)
                  <div class="box" data-id="{{$detalle->id}}">
                    <div class="box-body">
                      <div class="col-sm-4">
                          <strong>{{$detalle->nombre_producto}}</strong>
                      </div>
                      <div class="col-sm-4">
                        <label for="">Cantidad:  </label>  
                        {{$detalle->cantidad}}
                      </div>
                      <div class="col-sm-4">
                        <label for="">Mesa:  </label>  
                        {{$detalle->mesa}}
                      </div>
                      <div class="col-sm-12">
                          {{$detalle->comentario}}
                      </div>                        
                        
                    </div>
                  </div>                    
                @endforeach

            </div>
        </div>               
    </div>

    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                    <h3 class="box-title">Preparado</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_preparado">
                {{--<div class="box">                       
                    <div class="box-body">
                        <div class="box-tools pull-right">
                        </div> 
                        Aqui hay algo
                    </div>
                </div>--}}

                {{--<div class="box box-default">
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-danger btn-xs">X</i>
                            </button>
                        </div>                       
                    <div class="box-body">

                        <div class="col-sm-5 text-left">
                            <p>Aqui es la descripcion</p>
                        </div>
                        <div class="col-sm-7 text-center" style="display:flex">
                            <button class="btn btn-danger">-</button>
                            <input type="number" class="form-control" disabled value="125">
                            <button class="btn btn-success center">+</button>                  
                        </div>
                        
                        <div class="col-sm-12 text-right">
                            <b>Subtotal</b> <label for="">125</label>
                        </div>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" name="comentario">
                        </div>
                        
                    </div>
                </div>--}}
                

                @foreach ($productos_preparados as $detalle)
                  <div class="box" data-id="{{$detalle->id}}">
                    <div class="box-body">
                      <div class="col-sm-4">
                          <strong>{{$detalle->nombre_producto}}</strong>
                      </div>
                      <div class="col-sm-4">
                        <label for="">Cantidad:  </label>  
                        {{$detalle->cantidad}}
                      </div>
                      <div class="col-sm-4">
                        <label for="">Mesa:  </label>  
                        {{$detalle->mesa}}
                      </div>
                      <div class="col-sm-12">
                          {{$detalle->comentario}}
                      </div>                       
                          
                    </div>
                  </div>                    
                @endforeach

            </div>               
        </div>
    </div>
    
</div>


{{--<div class="text-right m-t-15">
    <a class='btn btn-primary form-button' href="{{ route('ordenes.index') }}">Regresar</a>
</div>--}}

@endsection


@push('styles')
 <style>
 </style>
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
  </script>
  <script src="{{asset('js/ordenes_cocina/index.js')}}"></script>

@endpush