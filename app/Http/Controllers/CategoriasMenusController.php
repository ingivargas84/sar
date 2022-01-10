<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\CategoriaMenu;
use Validator;

use App\Events\ActualizacionBitacora;

class CategoriasMenusController extends Controller
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
         return view ("admin.categorias_menus.index");
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
 
         $categoria_menu = new CategoriaMenu;
         $categoria_menu->nombre = $data['nombre'];
         $categoria_menu->user_id = Auth::user()->id;
         $categoria_menu->save();                       
 
         event(new ActualizacionBitacora($categoria_menu->id, Auth::user()->id,'Creación','',$categoria_menu,'categorias_menus'));
 
         return Response::json(['success' => 'Éxito']);
     }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = CategoriaMenu::where("nombre",$dato)
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
 
         $query = CategoriaMenu::where("nombre",$dato)
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
     public function update(CategoriaMenu $categoria_menu, Request $request)
     {
        $respuesta = $request->all();
        //dd($respuesta, $categoria_menu);
 
         event(new ActualizacionBitacora($categoria_menu->id, Auth::user()->id,'Edición',$categoria_menu->nombre, $respuesta['nombre'],'categorias_menus'));
         $categoria_menu->nombre = $request->nombre;
         $categoria_menu->save();
 
         return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(CategoriaMenu $categoria_menu, Request $request)
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
             $categoria_menu->estado = 0;
             $categoria_menu->save();
             event(new ActualizacionBitacora($categoria_menu->id, Auth::user()->id,'Inactivación','','','categorias_menus'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          } 
     }
     
     public function getJson(Request $params)
     { 
         $api_Result['data'] = CategoriaMenu::where('estado', 1)->with('user')->get();
 
         return Response::json( $api_Result );
     }
}
