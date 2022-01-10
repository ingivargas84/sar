<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Cliente;
use App\Events\ActualizacionBitacora;
use Validator;

class ClientesController extends Controller
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
         return view ("admin.clientes.index");
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        return view("admin.clientes.create");
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
         $cliente = Cliente::create($data);
         $cliente->user_id = Auth::user()->id;
         $cliente->save();
        
         event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Creación','', $cliente,'clientes'));
         return redirect()->route('clientes.index')->withFlash('El cliente ha sido creado exitosamente!');
         //return Response::json($cliente);
     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function show($id)
     {
         //
     }
     public function nitDisponible()
     {
         $dato = Input::get("nit");
         $query = Cliente::where("nit",$dato)->get();
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
     public function dpiDisponible()
     {
         $dato = Input::get("cui");
         $query = Cliente::where("cui",$dato)->get();
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
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(Cliente $cliente)
     {
        return view('admin.clientes.edit', compact('cliente', 'puestos'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Cliente $cliente, Request $request)
     {

        $this->validate($request,['nit' => 'required|unique:clientes,nit,'.$cliente->id
        ]);
        $this->validate($request,['cui' => 'unique:clientes,cui,'.$cliente->id
        ]);

        $nuevos_datos = array(
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'nit' => $request->nit,
            'cui' => $request->cui,
            'fecha_nacimiento' => $request->fecha_nacimiento,
            'telefono' => $request->telefono,
            'celular' => $request->celular,
            'direccion' => $request->direccion,
            'email' => $request->email

            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Edición',$cliente, $json,'clientes'));

        $cliente->update($request->all());
      
        return redirect()->route('clientes.index', $cliente)->with('flash','El cliente ha sido actualizado!');
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Cliente $cliente, Request $request)
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
            $cliente->estado = 0;
            $cliente->save();
            event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Inactivación','','','clientes'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }
     }

     public function activar(Cliente $cliente, Request $request)
     {
        $cliente->estado = 1;
        $cliente->save();
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Activación','','','clientes'));

        return Response::json(['success' => 'Éxito']);       
     }
      
     public function getJson(Request $params)
     {
         /*$query = "SELECT * FROM clientes ";
 
         $result = DB::select($query);
         $api_Result['data'] = $result;*/

         $api_Result['data'] = Cliente::all();

         /*$api_Result = DB::table('clientes')
        ->select('clientes.id','clientes.nombres', 'clientes.apellidos')
        ->get();*/
 
         return Response::json( $api_Result );
     }
}
