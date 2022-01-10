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

class OrdenesController extends Controller
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
        /*$now = Carbon::now();
        $now = Carbon::parse($now)->format('Y-m-d');
        $ordenes_maestro = OrdenMaestro::with('localidad')->whereDate('created_at', $now)->get();*/
        $tipos_localidad = TipoLocalidad::where('estado', 1)->get();
        return view ("admin.ordenes.index", compact('tipos_localidad'));
    }

    public function indexOrdenes()
    {
        $now = Carbon::now();
        $now = Carbon::parse($now)->format('Y-m-d');
        $ordenes_maestro = OrdenMaestro::with('localidad')->whereDate('created_at', $now)->get();
        $tipos_localidad = TipoLocalidad::where('estado', 1)->get();
        return view ("admin.ordenes.index_ordenes", compact('tipos_localidad', 'ordenes_maestro'));
    }

    public function create()
    {
        $mesas = Localidad::where('estado', 1)->where('tipo_localidad_id', 1)->where('ocupada', 0)->get();

        $categorias = CategoriaMenu::all();
        return view ("admin.ordenes.create", compact('categorias', 'mesas'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {    
        try{
			DB::beginTransaction();

            $todo_request = $request->all();
            $orden = Orden::where('id', $todo_request['cuenta_id'])->first();
            $ordenA = $orden;
            $orden->total = $todo_request['total'];
            $orden->estado_id = 1;
            $orden->user_id = Auth::user()->id;
            $orden->save();

            //Actualizando Mesa
            $orden_maestro = OrdenMaestro::where('id', $orden->orden_maestro_id)->first();
            $orden_maestro->localidad_id = $todo_request['mesas'][0]['id'];
            $orden_maestro->save();
            
            //Guarda Detalle
            $Detalles = $todo_request['productos'];
            foreach($Detalles as $detalle) {

                if(empty($detalle['detalle_id']) ){
                    $detalle['producto_id'] = $detalle['id'];
                    $detalle['cantidad'] = $detalle["cantidad"];
                    $detalle['precio'] = $detalle["precio"];
                    $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                    $detalle['comentario'] = $detalle["comentario"] ;

                    //$detallemovimiento = MovimientoInsumo::create($detalle);
                    //$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                    $orden->ordenes_detalles()->create($detalle);
                    event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Creación Detalle','',$orden,'ordenes'));
                }else{
                    $orden_detalle = OrdenDetalle::where('id', $detalle['detalle_id'])->first();
                    
                    $detalle['cantidad'] = $detalle["cantidad"];
                    $detalle['precio'] = $detalle["precio"];
                    $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                    $detalle['comentario'] = $detalle["comentario"] ;

                    //$detallemovimiento = MovimientoInsumo::create($detalle);
                    //$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                    $orden_detalle->update($detalle);
                    event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Edición Detalle',$ordenA,$orden,'ordenes'));
                }
                
            }
            
        DB::commit();	
		return Response::json(['success' => 'ok', 'total' => $orden->total]);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
    }

    public function storeCuenta(Request $request)
    {    
        try{
			DB::beginTransaction();

            $todo_request = $request->all();
            $orden = new Orden();
            $orden->total = 0;
            $orden->estado_id = 1;
            $orden->orden_maestro_id = $todo_request['orden_maestro_id'];
            $orden->user_id = Auth::user()->id;
            $orden->save();
            event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Creación','',$orden,'ordenes'));

		DB::commit();
		return Response::json(['success' => 'ok', 'orden' => $orden]);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Orden $orden, Request $request)
    {
        try{
			DB::beginTransaction();

            $todo_request = $request->all();
            $ordenA = $orden;
            $orden->total = $todo_request['total'];
            $orden->estado_id = 1;
            $orden->user_id = Auth::user()->id;
            $orden->save();

            //Guarda Detalle
            $Detalles = $todo_request['productos'];
            foreach($Detalles as $detalle) {

                if(empty($detalle['detalle_id']) ){
                    $detalle['producto_id'] = $detalle['id'];
                    $detalle['cantidad'] = $detalle["cantidad"];
                    $detalle['precio'] = $detalle["precio"];
                    $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                    $detalle['comentario'] = $detalle["comentario"] ;

                    //$detallemovimiento = MovimientoInsumo::create($detalle);
                    //$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                    $orden->ordenes_detalles()->create($detalle);
                    event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Creación Detalle','',$orden,'ordenes'));
                }else{
                    $orden_detalle = OrdenDetalle::where('id', $detalle['detalle_id'])->first();
                    
                    $detalle['cantidad'] = $detalle["cantidad"];
                    $detalle['precio'] = $detalle["precio"];
                    $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                    $detalle['comentario'] = $detalle["comentario"] ;

                    //$detallemovimiento = MovimientoInsumo::create($detalle);
                    //$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                    $orden_detalle->update($detalle);
                    event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Edición Detalle',$ordenA,$orden,'ordenes'));
                }
                

                //event(new ActualizacionBitacora($compra_maestro->id, Auth::user()->id,'Creación','',$compra_maestro,'compras'));	
                
            }

		DB::commit();
		return Response::json(['success' => 'ok']);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
    }

    public function destroyDetalle(Request $request)
    {
        $password_usuario = Auth::user()->password;

        $data = $request->all();

        $errors = Validator::make($data,[
            'password_actual' => ['required'],
        ]);

        if($errors->fails())
        {
            return  Response::json($errors->errors(), 422);
        }

        if(password_verify($data['password_actual'],$password_usuario))
        {
            if($request->id !="" ){
                $ordendetalle = OrdenDetalle::where('id', $request->id)->first();
                $orden = Orden::where('id', $ordendetalle->orden_id)->first();
                $orden->total = $orden->total - $ordendetalle->subtotal;
                $orden->save();

                $ordendetalle->delete();

                event(new ActualizacionBitacora($ordendetalle->id, Auth::user()->id,'Eliminación','','','ordenes_detalles'));

                return Response::json(['success' => 'Éxito']);

            }elseif($request->orden_id !=''){
                $orden = Orden::where('id', $request->orden_id)->first();
                $orden->delete();
                event(new ActualizacionBitacora($orden->id, Auth::user()->id,'Eliminación','','','ordenes'));
                return Response::json(['success' => 'ÉxitoOrden']);
            }
            else{
                return Response::json(['success' => 'Éxito']);
            }

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }

    public function destroyProducto(Request $request)
    {
        $ordendetalle = OrdenDetalle::where('id', $request->id)->first();
        $orden = Orden::where('id', $ordendetalle->orden_id)->first();
        $orden->total = $orden->total - $ordendetalle->subtotal;
        $orden->save();

        $ordendetalle->delete();

        event(new ActualizacionBitacora($ordendetalle->id, Auth::user()->id,'Eliminación','','','ordenes_detalles'));

        return Response::json(['success' => 'Éxito']);
    }

    public function MenosCantidad(Request $request)
    {
        $password_usuario = Auth::user()->password;

        $data = $request->all();

        $errors = Validator::make($data,[
            'password_actual' => ['required'],
        ]);

        if($errors->fails())
        {
            return  Response::json($errors->errors(), 422);
        }

        if(password_verify($data['password_actual'],$password_usuario))
        {

            return Response::json(['success' => 'Éxito']);
        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }
    
    /*public function getJson(Request $params)
    {

        $api_Result['data'] = Localidad::where('estado', 1)->with(['user', 'tipo_localidad'])->get();

        return Response::json( $api_Result );
    }*/

    public function getJsonDetalle(Request $request, Orden $orden)
    {
        $query = "SELECT OD.id as detalle_id, OD.orden_id, OD.producto_id as id, OD.cantidad, OD.precio, OD.subtotal, IF(OD.comentario is null,'',OD.comentario) as comentario, P.nombre as nombre_producto 
        from ordenes_detalles OD 
        INNER JOIN productos P on P.id = OD.producto_id
        where OD.orden_id = ".$orden->id. " ";

        $result = DB::select($query);
        $api_Result['data'] = $result;
        $api_Result['total'] = $orden->total;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $api_Result );
    }

}
