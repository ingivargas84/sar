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

class OrdenesController1 extends Controller
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
        $ordenes = Orden::with('localidades')->get();
        $tipos_localidad = TipoLocalidad::where('estado', 1)->get();
        return view ("admin.ordenes.index", compact('tipos_localidad', 'ordenes', 'localidades'));
    }

    public function create()
    {
        $mesas = Localidad::where('estado', 1)->where('tipo_localidad_id', 1)->get();

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
            $mesas = $todo_request['mesas'];
            $orden = new Orden();
            $orden->total = $todo_request['total'];
            $orden->estado_id = 1;
            $orden->user_id = Auth::user()->id;
            $orden->save();

            $mesas = array_flatten($mesas);
            $orden->localidades()->sync($mesas);

            /*foreach ($mesas as $mesa){
                $orden->localidades()->attach($mesa);
            }*/
            
            //Guarda Detalle

            $Detalles = $todo_request['productos'];
            foreach($Detalles as $detalle) {

                $detalle['producto_id'] = $detalle['id'];
                $detalle['cantidad'] = $detalle["cantidad"];
                $detalle['precio'] = $detalle["precio"];
                $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                $detalle['comentario'] = $detalle["comentario"] ;

                //$detallemovimiento = MovimientoInsumo::create($detalle);
				//$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                $orden->ordenes_detalles()->create($detalle);

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
    
    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit(Orden $orden)
    {
        $mesas = Localidad::where('estado', 1)->where('tipo_localidad_id', 1)->get();
        $categorias = CategoriaMenu::all();
        $detalles = OrdenDetalle::where('orden_id' , $orden->id)->get();
        return view ("admin.ordenes.edit", compact('categorias', 'mesas', 'orden', 'detalles'));
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
        /*$nuevos_datos = array(
            'nombre' => $request->nombre,
            'tipo_localidad_id' => $request->tipo_localidad_id
        );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Edición',$localidad, $json,'localidades'));
        $localidad->nombre = $request->nombre;
        $localidad->tipo_localidad_id = $request->tipo_localidad_id;
        $localidad->save();

        return Response::json(['success' => 'Éxito']);*/

        try{
			DB::beginTransaction();

            $todo_request = $request->all();
            $mesas = $todo_request['mesas'];
            $orden->total = $todo_request['total'];
            $orden->estado_id = 1;
            $orden->user_id = Auth::user()->id;
            $orden->save();

            foreach ($mesas as $key => $mesa){
                $mesas_detalle[$key] = $mesa['id'];
                //$orden->localidades()->attach($mesa);
            }
            $orden->localidades()->sync($mesas_detalle);
            
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
                }else{
                    $orden_detalle = OrdenDetalle::where('id', $detalle['detalle_id'])->first();
                    
                    $detalle['cantidad'] = $detalle["cantidad"];
                    $detalle['precio'] = $detalle["precio"];
                    $detalle['subtotal'] = $detalle["precio"]*$detalle["cantidad"] ;
                    $detalle['comentario'] = $detalle["comentario"] ;

                    //$detallemovimiento = MovimientoInsumo::create($detalle);
                    //$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                    $orden_detalle->update($detalle);
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

            }else{
                return Response::json(['success' => 'Éxito']);
            }

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Localidad $localidad, Request $request)
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
            $localidad->estado = 0;
            $localidad->save();
            event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Inactivación','','','localidades'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    
        
    }
    
    public function getJson(Request $params)
    {

        $api_Result['data'] = Localidad::where('estado', 1)->with(['user', 'tipo_localidad'])->get();

        return Response::json( $api_Result );
    }

    public function getJsonDetalle(Request $request, Orden $orden)
    {
        $query = "SELECT OD.id as detalle_id, OD.orden_id, OD.producto_id as id, OD.cantidad, OD.precio, OD.subtotal, IF(OD.comentario is null,'',OD.comentario) as comentario, P.nombre as nombre_producto 
        from ordenes_detalles OD 
        INNER JOIN productos P on P.id = OD.producto_id
        where OD.orden_id = ".$orden->id. " ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $api_Result );
    }

    public function getMesas(Request $request, Orden $orden)
    {
        $query = "SELECT LO.localidad_id as mesa_id, LO.localidad_id as id, L.nombre FROM localidad_orden LO 
        INNER JOIN localidades L on L.id = LO.localidad_id
        WHERE LO.orden_id = ".$orden->id. " ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $api_Result );
    }
}
