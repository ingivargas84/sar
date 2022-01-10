@extends('admin.layoutadmin')

@section('header')
  <section class="content-header">
    <h1>
      Detalle de Compra
    </h1>
    <ol class="breadcrumb">
      <li><a href="{{route('dashboard')}}"><i class="fa fa-home"></i> Inicio</a></li>
      <li><a href="{{route('compras.index')}}"><i class="fa fa-list"></i> Compras</a></li>
      <li class="active">Detalle</li>
    </ol>
  </section>

@endsection

@section('content')
@include('admin.compras.editModalDetalle')
@include('admin.users.confirmarAccionModal')
<div class="loader loader-bar is-active"></div>
<div class="box">
    <div class="box-header">
      <div class="row"> <h4>
        <div class="col-sm-3">
          <label for="">Proveedor:  </label>&nbsp;{{$compra->proveedor->nombre_comercial}}
        </div>
        <div class="col-sm-3">
          <label for=""> Fecha de Factura:  </label>&nbsp;{{Carbon\Carbon::parse($compra->fecha_compra)->format('d-m-Y')}}
        </div>
        <div class="col-sm-3">
          <label for=""> Total:  </label>&nbsp;Q <span id="total_nuevo">{{number_format($compra->total, 2)}}</span> 
        </div></h4>
      </div>
      
    </div>
    <!-- /.box-header -->
    <div class="box-body">
        <div id="compra" style="display: none">{{ $compra->id }}</div>
        {{--<input type="hidden" name="rol_user" value="{{auth()->user()->roles[0]->name}}">--}}
        <table id="comprasdetalle-table" class="table table-striped table-bordered no-margin-bottom dt-responsive nowrap" width="100%">            
        </table>
        <input type="hidden" name="urlActual" value="{{url()->current()}}">
    </div>
    <!-- /.box-body -->
  </div>
  <!-- /.box --> 

@endsection


@push('styles')
 
 
@endpush

@push('scripts')
  <script>
    $(document).ready(function() {
      $('.loader').fadeOut(225);
      comprasdetalle_table.ajax.url("{{route('compras.getJsonDetalle', $compra->id)}}").load();
    });
    
  </script>
  <script src="{{asset('js/compras/show.js')}}"></script>
  <script src="{{asset('js/compras/editDetalle.js')}}"></script>
@endpush