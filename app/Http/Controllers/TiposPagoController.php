<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\TipoPago;
use Validator;

use App\Events\ActualizacionBitacora;

class TiposPagoController extends Controller
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
        return view ("admin.tipos_pago.index");
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

        $tipo_pago = new TipoPago;
        $tipo_pago->nombre = $data['nombre'];
        $tipo_pago->user_id = Auth::user()->id;
        $tipo_pago->save();                       

        event(new ActualizacionBitacora($tipo_pago->id, Auth::user()->id,'Creación','',$tipo_pago,'tipos_pago'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = TipoPago::where("nombre",$dato)
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

        $query = TipoPago::where("nombre",$dato)
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
    public function update(TipoPago $tipo_pago, Request $request)
    {
    /*$this->validate($request,['emp_cui' => 'required|unique:tipos_pago,emp_cui,'.$tipo_pago->id
    ]);*/
    $respuesta = $request->all();
    //dd($respuesta, $tipo_pago);

        event(new ActualizacionBitacora($tipo_pago->id, Auth::user()->id,'Edición',$tipo_pago->nombre, $respuesta['nombre'],'tipos_pago'));
        $tipo_pago->nombre = $request->nombre;
        $tipo_pago->save();

        return Response::json(['success' => 'Éxito']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(TipoPago $tipo_pago, Request $request)
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
            $tipo_pago->estado = 0;
            $tipo_pago->save();
            event(new ActualizacionBitacora($tipo_pago->id, Auth::user()->id,'Inactivación','','','tipos_pago'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    
        
    }
    
    public function getJson(Request $params)
    {
        $api_Result['data'] = TipoPago::where('estado', 1)->with('user')->get();

        return Response::json( $api_Result );
    }
}
