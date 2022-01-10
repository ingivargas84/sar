<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Puesto;
use Validator;

use App\Events\ActualizacionBitacora;

class PuestosController extends Controller
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
        return view ("admin.puestos.index");
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

        $puesto = new Puesto;
        $puesto->nombre = $data['nombre'];
        $puesto->user_id = Auth::user()->id;
        $puesto->save();                       

        event(new ActualizacionBitacora($puesto->id, Auth::user()->id,'Creación','',$puesto,'puestos'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = Puesto::where("nombre",$dato)
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

        $query = Puesto::where("nombre",$dato)
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
    public function update(Puesto $puesto, Request $request)
    {
       /*$this->validate($request,['emp_cui' => 'required|unique:puestos,emp_cui,'.$puesto->id
       ]);*/
       $respuesta = $request->all();
       //dd($respuesta, $puesto);

        event(new ActualizacionBitacora($puesto->id, Auth::user()->id,'Edición',$puesto->nombre, $respuesta['nombre'],'puestos'));
        $puesto->nombre = $request->nombre;
        $puesto->save();

        return Response::json(['success' => 'Éxito']);
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Puesto $puesto, Request $request)
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
            $puesto->estado = 0;
            $puesto->save();
            event(new ActualizacionBitacora($puesto->id, Auth::user()->id,'Inactivación','','','puestos'));

            return Response::json(['success' => 'Éxito']);

         }

         else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
         }

       
        
    }
    
    public function getJson(Request $params)
    {
        /*$query = "SELECT * FROM puestos ";

        $result = DB::select($query);
        $api_Result['data'] = $result;*/

        $api_Result['data'] = Puesto::where('estado', 1)->with('user')->get();

        return Response::json( $api_Result );
    }
}
