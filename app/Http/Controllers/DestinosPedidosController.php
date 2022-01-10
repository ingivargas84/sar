<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\DestinoPedido;
use Validator;
use Spatie\Permission\Models\Role;

use App\Events\ActualizacionBitacora;

class DestinosPedidosController extends Controller
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
         return view ("admin.destinos_pedidos.index");
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
 
         $destino = new DestinoPedido;
         $destino->destino = $data['destino'];
         $destino->user_id = Auth::user()->id;
         $destino->save();    
         
        Role::create(['name' => $data['destino'], 'destino_id' => $destino->id]);
 
         event(new ActualizacionBitacora($destino->id, Auth::user()->id,'Creación','',$destino,'destinos_pedidos'));
 
         return Response::json(['success' => 'Éxito']);
     }
 
     public function destinoDisponible()
     {
         $dato = Input::get("destino");
         $query = DestinoPedido::where("destino",$dato)
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
 
     public function destinoDisponibleEdit()
     {
         $dato = Input::get("destino");
         $id = Input::get('id');
 
         $query = DestinoPedido::where("destino",$dato)
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
     public function update(DestinoPedido $destino, Request $request)
     {
        $respuesta = $request->all();
 
         event(new ActualizacionBitacora($destino->id, Auth::user()->id,'Edición',$destino->destino, $respuesta['destino'],'destinos_pedidos'));
         $destino->destino = $request->destino;
         $destino->save();
         
        $rol = Role::where('destino_id', $destino->id)->first();
        $rol->name = $request->destino;
        $rol->save();

         return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(DestinoPedido $destino, Request $request)
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
             $destino->estado = 0;
             $destino->save();
             event(new ActualizacionBitacora($destino->id, Auth::user()->id,'Inactivación','','','destinos_pedidos'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
         
     }
     
     public function getJson(Request $params)
     { 
         $api_Result['data'] = DestinoPedido::where('estado', 1)->with('user')->get();
 
         return Response::json( $api_Result );
     }
}
