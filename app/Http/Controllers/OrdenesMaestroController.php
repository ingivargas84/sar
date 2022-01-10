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

class OrdenesMaestroController extends Controller
{
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {    
        $data = $request->all();
        try{
			DB::beginTransaction();
            $orden_maestro = new OrdenMaestro();
            $orden_maestro->localidad_id = $data['id'];
            $orden_maestro->estado_id = 1;
            $orden_maestro->save();
            $orden_maestro->localidad()->update(['ocupada' => 1]);

        DB::commit();
        event(new ActualizacionBitacora($orden_maestro->id, Auth::user()->id,'Creación','',$orden_maestro,'ordenes_maestro'));
		return Response::json(['success' => 'ok', 'orden_maestro_id' => $orden_maestro->id]);
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
    public function edit(OrdenMaestro $orden_maestro)
    {
        $mesas = Localidad::where('estado', 1)->where('tipo_localidad_id', 1)->where('ocupada', 0)->get();
        $categorias = CategoriaMenu::all();
        return view ("admin.ordenes.edit", compact('categorias', 'mesas', 'orden_maestro'));
    }

    public function getJson(Request $request, OrdenMaestro $orden_maestro)
    {
        $query = "SELECT OM.localidad_id, O.id as cuenta_id, O.total FROM ordenes O
        INNER JOIN ordenes_maestro OM on OM.id = O.orden_maestro_id where OM.id = ".$orden_maestro->id. " ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $api_Result );
    }

    public function getMesas(Request $request, OrdenMaestro $orden_maestro)
    {
        $query = "SELECT OM.localidad_id as mesa_id, OM.localidad_id as id, L.nombre FROM ordenes_maestro OM 
        INNER JOIN localidades L on L.id = OM.localidad_id
        WHERE OM.id = ".$orden_maestro->id. " ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $api_Result );
    }

    public function ordenActual(Request $request)
    {
        $query = "SELECT * FROM ordenes_maestro OM where OM.localidad_id = ".$request->id. " AND OM.estado_id=1 limit 1";

        $result = DB::select($query);
        //$api_Result['data'] = $result;

        //$api_Result['data'] = OrdenDetalle::where('orden_id' , $orden->id)->get();

        return Response::json( $result );
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(OrdenMaestro $orden_maestro, Request $request)
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
            $orden_maestro->localidad()->update(['ocupada' => 0]);
            $orden_maestro->delete();
            event(new ActualizacionBitacora($orden_maestro->id, Auth::user()->id,'Eliminacion','','','ordenes_maestro'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }
        
    }

    public function cambiarMesa(Request $request)
    {   
        $mesa_inicio = Localidad::where('id', $request->mesa_inicio)->first();
        $mesa_inicio->ocupada = 0;
        $mesa_inicio->save();

        $mesa_destino = Localidad::where('id', $request->mesa_destino)->first();
        $mesa_destino->ocupada = 1;
        $mesa_destino->save();

        $orden_maestro = $mesa_inicio->ordenes_maestro()->where('estado_id', 1)->first();
        $orden_maestroA = $orden_maestro;
        $orden_maestro->localidad_id = $mesa_destino->id;
        $orden_maestro->save();

        event(new ActualizacionBitacora($orden_maestro->id, Auth::user()->id,'Cambio Mesa',$orden_maestroA,$orden_maestro,'ordenes_maestro'));

        return Response::json(['success' => 'ok']);
    }
}
