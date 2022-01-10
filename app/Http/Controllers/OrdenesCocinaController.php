<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoLocalidad;
use App\Orden;
use Validator;
use DB;

use App\Events\ActualizacionBitacora;
use App\CategoriaMenu;
use App\Localidad;
use App\OrdenDetalle;
use App\OrdenMaestro;

class OrdenesCocinaController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $now = Carbon::now();
        $now = Carbon::parse($now)->format('Y-m-d');
        //$ordenes_maestro = OrdenMaestro::with('localidad')->whereDate('created_at', $now)->get();

        $destino = auth()->user()->roles[0]->destino_id;
        $nombre_destino = auth()->user()->roles[0]->name;

        if($destino){
            $productos_preparacion = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('P.destino_pedido_id', $destino)->where('OD.estado_id', 2)->whereDate('OD.created_at', $now)->get();

            $productos_espera = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('P.destino_pedido_id', $destino)->where('OD.estado_id', 1)->whereDate('OD.created_at', $now)->get();


            $productos_preparados = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('P.destino_pedido_id', $destino)->where('OD.estado_id', 3)->whereDate('OD.created_at', $now)->get();

        }else{
            $productos_preparacion = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('OD.estado_id', 2)->whereDate('OD.created_at', $now)->get();

            $productos_espera = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('OD.estado_id', 1)->whereDate('OD.created_at', $now)->get();


            $productos_preparados = DB::table('ordenes_detalles as OD')
            ->select('OD.id','OD.estado_id', 'OD.cantidad', 'OD.comentario', 'P.nombre as nombre_producto', 'P.id as producto_id', 'OD.created_at', 'L.nombre as mesa')
            ->Join('productos as P','P.id','=','OD.producto_id')
            ->Join('ordenes as O','O.id','=','OD.orden_id')
            ->Join('ordenes_maestro as OM','OM.id','=','O.orden_maestro_id')
            ->Join('localidades as L','L.id','=','OM.localidad_id')
            ->where('OD.estado_id', 3)->whereDate('OD.created_at', $now)->get();
        }
        


        return view ("admin.ordenes_cocina.index", compact('productos_preparacion', 'productos_espera', 'productos_preparados', 'nombre_destino'));
    }

    public function actualizarEstado(Request $request)
    {
        $datos = $request->all();

        if(!empty($datos['espera']))
        {
            foreach($datos['espera'] as $dato){
                $detalle = OrdenDetalle::where('id', $dato)->first();
                $detalle->update(['estado_id' => 1]);
            }
        }

        if(!empty($datos['preparacion']))
        {
            foreach($datos['preparacion'] as $dato){
                $detalle = OrdenDetalle::where('id', $dato)->first();
                $detalle->update(['estado_id' => 2]);
            }
        }

        if(!empty($datos['preparado']))
        {
            foreach($datos['preparado'] as $dato){
                $detalle = OrdenDetalle::where('id', $dato)->first();
                $detalle->update(['estado_id' => 3]);
            }
        }

        return Response::json(['result' => 'ok']);
    }
}
