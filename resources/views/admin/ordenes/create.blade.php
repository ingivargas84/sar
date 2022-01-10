@extends('admin.layoutmeseros')

@section('header')
    
@endsection

@section('content')
@include('admin.users.confirmarAccionModal')

<div class="row" id="row_especial">
    <input type="hidden" value="0" name="orden_maestro_id">
    <input type="hidden" value="0" name="cuenta_id">
    <div class="col-sm-3" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                    <div class="col-sm-3">
                        <h3 class="box-title">Mesas</h3>
                    </div>
                    <div class="col-sm-8">
                        <select name="mesa_id" id="mesa_id" class="form-control input-sm" >
                            <option value="" selected>Seleccione Mesa</option>
                            @foreach ($mesas as $mesa)
                                <option value="{{$mesa->id}}">{{$mesa->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                    </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_mesa">
                {{--<div class="box">
                    <div class="box-body">
                        <h4>Mesa 1</h4>
                    </div>
                </div>--}}
            </div>
        </div>               
    </div>


    <div class="col-sm-3" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
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

    <div class="col-sm-3" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <div class="col-sm-3">
                    <h3 class="box-title">Carta</h3>
                </div>
                <div class="col-sm-8">
                    <select name="categoria_id" id="categoria_id" class="form-control input-sm" >
                        <option value="" selected disabled>Seleccione Categoria</option>
                        <option value="todo">Todo</option>
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

    <div class="col-sm-3" style="border-right: white 1px solid; padding-left: 2px; padding-right: 2px">
        <div class="box box-primary box-solid">
            <div class="box-header with-border">
                <div class="col-sm-5">
                    <h3 class="box-title">Pedido</h3>
                </div>

                <div class="col-sm-2">
                    <label for="" class="box-title">Total</label>
                </div>
                                    
                <div class="col-sm-4">
                    <input type="number" disabled class="form-control input-sm" value="0" name="total">
                </div>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                </div>
            </div>
            <div class="box-body" style="background-color: #ecf0f5" id="body_pedido">
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


            </div>               
        </div>
    </div>
    
</div>
    <div class="text-right m-t-15">
        <a class="btn btn-default form-button text-right" href="{{ route('ordenes.index') }}" >Regresar</a>
        <button class="btn btn-primary form-button text-right" id="ButtonOrden">Guardar</button>
    </div>
    
    
<div class="loader loader-bar"></div>

@stop


@push('styles')

@endpush


@push('scripts')

<script>

</script>

<script src="{{asset('js/ordenes/create.js')}}"></script>
@endpush