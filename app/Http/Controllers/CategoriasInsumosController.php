<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\CategoriaInsumo;
use Validator;

use App\Events\ActualizacionBitacora;

class CategoriasInsumosController extends Controller
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
         return view ("admin.categorias_insumos.index");
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
 
         $categoria_insumo = new CategoriaInsumo;
         $categoria_insumo->nombre = $data['nombre'];
         $categoria_insumo->user_id = Auth::user()->id;
         $categoria_insumo->save();                       
 
         event(new ActualizacionBitacora($categoria_insumo->id, Auth::user()->id,'Creación','',$categoria_insumo,'categorias_insumos'));
 
         return Response::json(['success' => 'Éxito']);
     }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = CategoriaInsumo::where("nombre",$dato)
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
 
         $query = CategoriaInsumo::where("nombre",$dato)
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
     public function update(Request $request)
     {
        $respuesta = $request->all();
        //dd($respuesta, $categoria_insumo);
 
        $categoria_insumo = CategoriaInsumo::where('id', $request->id)->first();
         event(new ActualizacionBitacora($categoria_insumo->id, Auth::user()->id,'Edición',$categoria_insumo->nombre, $respuesta['nombre'],'categorias_insumos'));
         $categoria_insumo->nombre = $request->nombre;
         $categoria_insumo->save();
 
         return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Request $request)
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
             $categoria_insumo = CategoriaInsumo::where('id',$request->id)->first();
             $categoria_insumo->estado = 0;
             $categoria_insumo->save();
             event(new ActualizacionBitacora($categoria_insumo->id, Auth::user()->id,'Inactivación','','','categorias_insumos'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
 
        
         
     }
     
     public function getJson(Request $params)
     { 
         $api_Result['data'] = CategoriaInsumo::where('estado', 1)->with('user')->get();
 
         return Response::json( $api_Result );
     }
}
