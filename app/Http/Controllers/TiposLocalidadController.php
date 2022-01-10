<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoLocalidad;
use Validator;
use DB;

use App\Events\ActualizacionBitacora;
use App\Localidad;

class TiposLocalidadController extends Controller
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
         return view ("admin.tipos_localidad.index");
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {       
         $data = $request->all();
 
         $tipolocalidad = new TipoLocalidad;
         $tipolocalidad->nombre = $data['nombre'];
         $tipolocalidad->columnas = $data['columnas'];
         $tipolocalidad->filas = $data['filas'];
         $tipolocalidad->user_id = Auth::user()->id;
         $tipolocalidad->save();                       
 
         event(new ActualizacionBitacora($tipolocalidad->id, Auth::user()->id,'Creación','',$tipolocalidad,'tipos_localidad'));
 
         return Response::json(['success' => 'Éxito']);
     }
 
     public function tipolocalidadDisponible()
     {
         $dato = Input::get("nombre");
         $query = TipoLocalidad::where("nombre",$dato)
                         ->where('estado', 1)->get();
         $contador = count($query);
         if ($contador == 0)
         {
             return 'false';
         }
         else
         {
             return 'true';
         }
     }
 
     public function tipolocalidadDisponibleEdit()
     {
         $dato = Input::get("nombre");
         $id = Input::get('id');
 
         $query = TipoLocalidad::where("nombre",$dato)
                         ->where('estado', 1)
                         ->where('id','!=', $id)->get();
         $contador = count($query);
 
         if ($contador == 0)
         {
             return 'false';
         }
         else
         {
             return 'true';
         }
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(TipoLocalidad $tipolocalidad, Request $request)
     {
         $tipolocalidadA = $tipolocalidad;
        $respuesta = $request->all();
 
         event(new ActualizacionBitacora($tipolocalidad->id, Auth::user()->id,'Edición',$tipolocalidad->nombre, $tipolocalidadA,'tipos_localidad'));
         $tipolocalidad->nombre = $request->nombre;
         $tipolocalidad->columnas = $request->columnas;
         $tipolocalidad->filas = $request->filas;
         $tipolocalidad->save();
 
         return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(TipoLocalidad $tipolocalidad, Request $request)
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
             $tipolocalidad->estado = 0;
             $tipolocalidad->save();
             event(new ActualizacionBitacora($tipolocalidad->id, Auth::user()->id,'Inactivación','','','tipos_localidad'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
         
     }
     
     public function getJson(Request $params)
     { 
         $api_Result['data'] = TipoLocalidad::where('estado', 1)->with('user')->get();
 
         return Response::json( $api_Result );
     }

    public function cargarSelect()
	{

        $result = DB::table('tipos_localidad')
        ->select('tipos_localidad.id','tipos_localidad.nombre')->get();

		return Response::json( $result );		
    }

    public function mapa(TipoLocalidad $tipo_localidad)
	{
        $localidades = Localidad::where('tipo_localidad_id', $tipo_localidad->id)->where('estado', 1)->get();

        return view ("admin.tipos_localidad.mapa", compact('tipo_localidad', 'localidades'));
    }

    public function mapaUpdate(Request $request)
    {
        $todo_request = $request->all();

        $posiciones = $todo_request['posiciones'];
        foreach($posiciones as $posicion)
        {
            $mesa = Localidad::where('id', $posicion['mesa_id'])->first();
            $mesaA = $mesa;
            $mesa->posicion =  $posicion['posicion'];
            $mesa->save();
            
            event(new ActualizacionBitacora($mesa->id, Auth::user()->id,'Edición',$mesaA, $mesa,'localidades'));
        }

        return Response::json(['success' => 'Éxito']);
    }


    public function mapaOrden(TipoLocalidad $tipo_localidad)
	{
        $localidades = Localidad::where('tipo_localidad_id', $tipo_localidad->id)->where('estado', 1)->get();

        return view ("admin.tipos_localidad.mapa_orden", compact('tipo_localidad', 'localidades'));
    }
}
