<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Caja;
use Validator;
use DB;
use App\MovimientoCaja;

use App\Events\ActualizacionBitacora;
use App\AperturaCaja;

class AperturasCajasController extends Controller
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
        return view ("admin.aperturas_cajas.index");
    }
 
    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */

    public function apertura(Request $request)
    {
        $password_usuario = Auth::user()->password;

        $data = $request->all();

        $errors = Validator::make($data,[
            'password_admin' => ['required'],
        ]);

        if($errors->fails())
        {
            return  Response::json($errors->errors(), 422);
        }

        if(password_verify($data['password_admin'],$password_usuario))
        {
            $apertura = new AperturaCaja();
            $apertura->monto = $request->monto;
            $apertura->monto_cierre = $request->monto;
            $apertura->caja_id = $request->caja_id;
            $apertura->user_cajero_id = $request->user_cajero_id;
            $apertura->user_aperturo_id = Auth::user()->id;
            $apertura->fecha_apertura = Carbon::now();
            $apertura->estado = 1;
            $apertura->save();

            //Cambiando estado a cajero
            $cajero = $apertura->user_cajero()->first();
            $cajero->caja_abierta = 1;
            $cajero->save();

            //cambiando estado a caja
            $caja = Caja::where('id', $request->caja_id)->first();
            $caja->apertura = 1;
            $caja->save();

            //Movimiento de caja
            $movimiento = new MovimientoCaja;
            $movimiento->caja_id = $caja->id;
            $movimiento->descripcion = 'Apertura de Caja';
            $movimiento->ingreso =$request->monto;
            $movimiento->salida = 0;
            $movimiento->saldo = $request->monto;
            $movimiento->user_id = Auth::user()->id;
            $movimiento->save();

            event(new ActualizacionBitacora($caja->id, Auth::user()->id,'Apertura','','','cajas'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_admin' => 'La contraseña no coincide'], 422);
        }
    
    }

    public function cierre(Request $request)
    {
        $password_usuario = Auth::user()->password;

        $data = $request->all();

        $errors = Validator::make($data,[
            'password_admin_cierre' => ['required'],
        ]);

        if($errors->fails())
        {
            return  Response::json($errors->errors(), 422);
        }

        if(password_verify($data['password_admin_cierre'],$password_usuario))
        {
            $apertura = AperturaCaja::where('id', $request->apertura_id)->first();
            $apertura->user_cerro_id = Auth::user()->id;
            $apertura->fecha_cierre = Carbon::now();
            $apertura->estado = 0;
            $apertura->efectivo = $request->efectivo;
            $apertura->sobrante = $request->sobrante;
            $apertura->faltante = $request->faltante;
            $apertura->save();

            //Cambiando estado a cajero
            $cajero = $apertura->user_cajero()->first();
            $cajero->caja_abierta = 0;
            $cajero->save();

            $caja = Caja::where('id', $request->caja_id)->first();
            $caja->apertura = 0;
            $caja->save();

            //Movimiento de caja
            $movimiento = new MovimientoCaja;
            $movimiento->caja_id = $caja->id;
            $movimiento->descripcion = 'Cierre de Caja';
            $movimiento->ingreso =0;
            $movimiento->salida = $request->monto_cierre;
            $movimiento->saldo = 0;
            $movimiento->user_id = Auth::user()->id;
            $movimiento->save();

            event(new ActualizacionBitacora($caja->id, Auth::user()->id,'Cierre','','','cajas'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_admin_cierre' => 'La contraseña no coincide'], 422);
        }
    
    }

    public function get(Request $request)
	{
        $id = $request["id"];

		if ($id == "")
		{
			$result = "";
			return Response::json($result);
		}
        else 
        {
            $caja = Caja::where('id', $id)->first();
            $apertura  = $caja->aperturas()->where('fecha_cierre', null)->with('user_cajero')->first();
            return Response::json($apertura);
        }
    }
     
    public function getJson(Request $request)
    {
        if(!$request->ajax()) return abort('403');
        $query = "SELECT AC.id, C.nombre, UA.name as user_aperturo, UCC.name as user_cerro, UC.name as cajero, 
        AC.fecha_apertura, AC.fecha_cierre, AC.monto, AC.monto_cierre, AC.sobrante, AC.faltante, AC.efectivo, AC.estado 
        from aperturas_cajas AC
                INNER JOIN cajas C on C.id = AC.caja_id
                LEFT JOIN users UA on UA.id= AC.user_aperturo_id
                LEFT JOIN users UC on UC.id = AC.user_cajero_id
                LEFT JOIN users UCC on UCC.id = AC.user_cerro_id ";

        $result = DB::select($query);
        $api_Result['data'] = $result;

        //$api_Result['data'] = Caja::where('estado', 1)->with('user')->get();

        return Response::json( $api_Result );
    }
}
