<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\UnidadMedida;
use Validator;

use App\Events\ActualizacionBitacora;

class UnidadesMedidaController extends Controller
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
         return view ("admin.unidades_medida.index");
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
 
         $unidad_medida = new UnidadMedida;
         $unidad_medida->nombre = $data['nombre'];
         $unidad_medida->abreviatura = $data['abreviatura'];
         $unidad_medida->descripcion = $data['descripcion'];
         $unidad_medida->user_id = Auth::user()->id;
         $unidad_medida->save();                       
 
         event(new ActualizacionBitacora($unidad_medida->id, Auth::user()->id,'Creación','',$unidad_medida,'unidades_medida'));
 
         return Response::json(['success' => 'Éxito']);
     }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = UnidadMedida::where("nombre",$dato)
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
 
         $query = UnidadMedida::where("nombre",$dato)
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
     public function update(UnidadMedida $unidad_medida, Request $request)
     {

        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'abreviatura' => $request->abreviatura,
            'descripcion' => $request->descripcion
        );
        $json = json_encode($nuevos_datos);
 
         event(new ActualizacionBitacora($unidad_medida->id, Auth::user()->id,'Edición',$unidad_medida, $json,'unidades_medida'));
         $unidad_medida->update($nuevos_datos);
 
         return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(UnidadMedida $unidad_medida, Request $request)
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
             $unidad_medida->estado = 0;
             $unidad_medida->save();
             event(new ActualizacionBitacora($unidad_medida->id, Auth::user()->id,'Inactivación','','','unidades_medida'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
 
        
         
     }
     
     public function getJson(Request $params)
     {
 
         $api_Result['data'] = UnidadMedida::where('estado', 1)->with('user')->get();
 
         return Response::json( $api_Result );
     }
}
