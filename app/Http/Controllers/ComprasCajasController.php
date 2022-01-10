<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\CompraCaja;
use App\Caja;
use App\MovimientoCaja;
use App\AperturaCaja;
use Validator;
use DB;

use App\Events\ActualizacionBitacora;

class ComprasCajasController extends Controller
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
        $cajas  = Caja::where('estado',1)->where('apertura', 1)->get();
        return view ("admin.compras_cajas.index", compact('cajas'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {       
        $request['user_id'] = Auth::user()->id;
        $compra_caja = CompraCaja::create($request->all());

        //Movimiento de caja
        /*$result = DB::table('aperturas_cajas as AC')
        ->select('C.id','C.nombre', 'U.name','AC.fecha_apertura', 'AC.monto_cierre', 'AC.id as apertura_id', DB::raw('U.id as user_id'))
        ->join('users as U', function($join){
            $join->on('U.id','=','AC.user_cajero_id');
        })
        ->join('cajas as C', function($join){
            $join->on('C.id','=','AC.caja_id');
        })
        ->where('AC.fecha_cierre', null)
        ->where('C.id', $request->caja_id)
        ->first();*/

        $caja = Caja::where('id', $request->caja_id)->first();
        $apertura  = $caja->aperturas()->where('fecha_cierre', null)->first();
    
        $movimiento = new MovimientoCaja;
        $movimiento->caja_id = $request->caja_id;
        $movimiento->descripcion = 'Compra';
        $movimiento->ingreso =0;
        $movimiento->salida = $request->total;
        $movimiento->saldo = $apertura->monto_cierre - $request->total;
        $movimiento->user_id = Auth::user()->id;
        $movimiento->save();

        $apertura->monto_cierre = $movimiento->saldo;
        $apertura->save();


        event(new ActualizacionBitacora($compra_caja->id, Auth::user()->id,'Creación','',$compra_caja,'compras_cajas'));

        return Response::json(['success' => 'Éxito']);
    }
    
    public function getJson(Request $params)
    {
        /*$query = "SELECT * FROM compras_cajas ";

        $result = DB::select($query);
        $api_Result['data'] = $result;*/

        $api_Result['data'] = CompraCaja::with('user', 'caja')->get();

        return Response::json( $api_Result );
    }
}
