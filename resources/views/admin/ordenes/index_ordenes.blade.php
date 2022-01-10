@extends('admin.layoutmeseros')

@section('header')
<section class="content-header">
    <h1>
      Listado de Ordenes del Día
    </h1>
    {{--<div class="text-right">
       <a class="btn btn-primary" href="{{route('ordenes.new')}}" >
        <i class="fa fa-plus"></i>Agregar Orden
      </a>
    </div>--}}
    
  </section>

  @endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>

@forelse ($ordenes_maestro as $orden)
  <div class="col-sm-2" data-orden_maestro_id="{{$orden->id}}">
      {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
      <div class='box'>
        <div class='box-body'>
          <div class='box-tools pull-right'>
            <button type='button' class='btn btn-danger btn-xs' data-toggle='modal' data-id='{{$orden->id}}' data-target='#modalConfirmarAccion'>X</button>
          </div>
          <a href="{{route('ordenes_maestro.edit', $orden->id)}}"><span style="color:green">Orden# {{$orden->id}}</span><h4>{{$orden->localidad->nombre}}</h4></a> 
        </div>
      </div>
  </div>
@empty
<div class="container text-center">
  <h2>No hay ordenes para mostrar</h2>   
</div>              
@endforelse


<div class="text-right m-t-15">
    <a class='btn btn-primary form-button' href="{{ route('ordenes.index') }}">Regresar</a>
</div>

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
    });
  </script>
  <script src="{{asset('js/ordenes/index_ordenes.js')}}"></script>

@endpush