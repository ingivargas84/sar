@extends('admin.layoutmeseros')

@section('header')
    
@endsection

@section('content')
@include('admin.users.confirmarAccionModal')
<input type="hidden" value="{{$orden_maestro->id}}" name="orden_maestro_id">
<input type="hidden" value="0" name="cuenta_id">

<div class="row" id="row_especial">
    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                    <div class="col-sm-3">
                        <h3 class="box-title">Cuentas</h3>
                    </div>
                    <div class="col-sm-8">
                        <button type="button" class="btn btn-success btn-sm" onclick="agregarCuenta()">Agregar Cuenta</button>
                    </div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_cuenta">
                    {{--<div class="box box-default">
                        <div class="box-body" data-cuenta_id="${data.orden.id}">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-danger btn-xs" data-orden_id='${data.orden.id}' data-target='#modalConfirmarAccion' data-toggle='modal' data-id='' >X</button>
                                </div>
                            <div class="col-sm-5 text-left"><p>Cuenta # ${data.orden.id}</p></div>
                        </div>
                    </div>--}}
            </div>
        </div>               
    </div>


    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <div class="col-sm-3">
                    <h3 class="box-title">Carta</h3>
                </div>
                <div class="col-sm-8">
                    <select name="categoria_id" id="categoria_id" class="form-control input-sm" >
                        {{--<option value="" selected disabled>Seleccione Categoria</option>--}}
                        <option value="todo" selected>Todo</option>
                        @foreach ($categorias as $categoria)
                            <option value="{{$categoria->id}}">{{$categoria->nombre}}</option>
                        @endforeach
                    </select>
                </div>
                    
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_carta">
                {{--<div class="box box-success">
                    <div class="box-body">
                        
                    </div>
                </div>--}}
            </div>
        </div>               
    </div>

    <div class="col-sm-4" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <div class="col-sm-5">
                    <h3 class="box-title">Pedido</h3>
                </div>

                <div class="col-sm-2">
                    <label for="" class="box-title">Total</label>
                </div>
                                    
                <div class="col-sm-4">
                    <input type="number" disabled class="form-control input-sm" value="{{number_format(0, 2)}}" name="total">
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_pedido">
            </div>               
        </div>
    </div>
    
</div>
    <div class="text-right m-t-15">
        <a class="btn btn-default form-button text-right" href="{{ route('ordenes.index') }}" >Regresar</a>
        {{--<button class="btn btn-primary form-button text-right" id="ButtonOrdenUpdate">Actualizar</button>--}}
    </div>   
    
<div class="loader loader-bar is-active"></div>

@stop


@push('styles')
    <style>
        .box-primary-cuenta{
            background-color: #9aefa7 !important;
        }
    </style>
@endpush


@push('scripts')

<script>

</script>

<script src="{{asset('js/ordenes/edit.js')}}"></script>
@endpush