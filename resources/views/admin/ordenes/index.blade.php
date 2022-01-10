@extends('admin.layoutmeseros')

@section('header')
<section class="content-header">
    <h1>
      Listado de Tipos de Localidad
    </h1>
    <div class="text-right">
       <a class="btn btn-primary" href="{{route('ordenes.indexOrdenes')}}" >
        <i class="fa fa-clipboard-list"></i> Listado de Ordenes del Día
      </a>
    </div>
    
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>

@forelse ($tipos_localidad as $tipo)
  <div class="col-sm-2" data-tipo_id="{{$tipo->id}}">
      {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
      <div class='box'>
        <div class='box-body'>
          <div class='box-tools pull-right'>
            <button type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-id='{{$tipo->id}}' data-target='#modalConfirmarAccion'>X</button>
          </div>
          <a href="{{route('tipos_localidad.mapaOrden', $tipo->id)}}"><h4>{{$tipo->nombre}}</h4></a> 
        </div>
      </div>
  </div>
@empty
<div class="container text-center">
  <h2>No hay tipos de localidad para mostrar</h2>   
</div>              
@endforelse

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
  </script>
  <script src="{{asset('js/ordenes/index.js')}}"></script>

@endpush