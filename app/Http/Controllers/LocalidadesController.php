<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoLocalidad;
use App\Localidad;
use App\OrdenMaestro;
use Validator;

use App\Events\ActualizacionBitacora;

class LocalidadesController extends Controller
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
         $tipos_localidad = TipoLocalidad::where('estado', 1)->get();
         return view ("admin.localidades.index", compact('tipos_localidad'));
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
        $localidades = Localidad::where('tipo_localidad_id', $data['tipo_localidad_id'] )->get();

        $localidad = new Localidad;
        $localidad->nombre = $data['nombre'];
        $localidad->user_id = Auth::user()->id;
        $localidad->tipo_localidad_id = $data['tipo_localidad_id'];

        $tipo_localidad = TipoLocalidad::where('id', $data['tipo_localidad_id'])->first();
        $posicion = $tipo_localidad->columnas * $tipo_localidad->filas -1;

        
        for($i = 0; $i <= $tipo_localidad->columnas * $tipo_localidad->filas -1; $i++)
        {
            $ocupada = $localidades->where('posicion', $posicion)->first();
            if($ocupada !=null)
            {
                $posicion-=1;
            }else{
                $localidad->posicion = $posicion;
                break;
            }
        }
        
        $localidad->save();                       

        event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Creación','',$localidad,'localidades'));

        return Response::json(['success' => 'Éxito']);
    }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = Localidad::where("nombre",$dato)
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
 
     public function nombreDisponibleEdit()
     {
         $dato = Input::get("nombre");
         $id = Input::get('id');
 
         $query = Localidad::where("nombre",$dato)
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
     public function update(Localidad $localidad, Request $request)
     {
        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'tipo_localidad_id' => $request->tipo_localidad_id
        );
        $json = json_encode($nuevos_datos);
 
         event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Edición',$localidad, $json,'localidades'));
         $localidad->nombre = $request->nombre;
         $localidad->tipo_localidad_id = $request->tipo_localidad_id;
         $localidad->save();
 
         return Response::json(['success' => 'Éxito']);
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

    public function bloquear(Localidad $localidad, Request $request)
    {
        $localidad->ocupada = 1;
        $localidad->save();
        event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Bloquear','','','localidades'));

        return back();
    }

    public function liberar(Localidad $localidad, Request $request)
    {
        $localidad->ocupada = 0;
        $localidad->save();
        event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Liberar','','','localidades'));

        return Response::json(['success' => 'ok']);
    }

    public function liberarSeguro(Localidad $localidad, Request $request)
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
            $localidad->ocupada = 0;
            $localidad->save();

            $orden_maestro = OrdenMaestro::where('localidad_id', $localidad->id)->where('estado_id', 1)->first();
            $orden_maestro->estado_id = 4;
            $orden_maestro->save();
            event(new ActualizacionBitacora($localidad->id, Auth::user()->id,'Liberar','','','localidades'));

            return Response::json(['success' => 'ok']);
        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }
    }

    public function cargarMesaCambioOrden()
	{
        $tipo_localidad = Input::get("tipo_localidad");

        $result = Localidad::where('tipo_localidad_id', $tipo_localidad)->where('estado', 1)
        ->where('ocupada', 0)->get();

		return Response::json( $result );		
    }
}
