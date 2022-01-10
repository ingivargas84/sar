<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\SerieFactura;
use Validator;
use App\Events\ActualizacionBitacora;
use App\EstadoSerie;

class SeriesFacturaController extends Controller
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
        return view ("admin.series.index");
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {       

        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
            
        $serie = SerieFactura::create($data);

        event(new ActualizacionBitacora($serie->id, Auth::user()->id,'Creación','', $serie,'series_facturas'));

        return Response::json(['success' => 'Éxito']);
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

    public function update(SerieFactura $serie, Request $request)
    {
        $seriea=$serie;
        $id= $serie->id;
        $serie->resolucion = $request->resolucion;
        $serie->serie = $request->serie;
        $serie->fecha_resolucion = $request->fecha_resolucion;
        $serie->fecha_vencimiento = $request->fecha_vencimiento;
        $serie->inicio = $request->inicio;
        $serie->fin = $request->fin;
        $serie->save();
        
        event(new ActualizacionBitacora($serie->id, Auth::user()->id,'Edicion',$seriea,$serie,'series_facturas'));
        
        return Response::json(['success' => 'Éxito']);
        
    }
    public function cambiarestado(SerieFactura $serie, Request $request)
    {
        $seriea=$serie;
        $id= $serie->id;
        $serie->estado = $request->estado;
        $serie->save();
        
        event(new ActualizacionBitacora($serie->id, Auth::user()->id,'Cambio de estado',$seriea, $serie,'series_facturas'));
        
        return Response::json(['success' => 'Éxito']);   
    }

    public function destroy(SerieFactura $serie, Request $request)
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
            $serie2=$serie;
            $serie->estado = 5;
            $serie->save();
            event(new ActualizacionBitacora($serie->id, Auth::user()->id,'Inactivación',$serie2,$serie,'series_facturas'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

        
    }

    public function getDatos(Serie $serie) {

        return Response::json($serie);
    }
    public function getJson(Request $params)
    {
    
        $query = 'SELECT F.estado as estado, S.estado as estado_id,S.inicio as inicio, S.fin as fin ,S.id as id,S.resolucion as resolucion, S.serie as serie,  S.fecha_resolucion as fecha_resolucion, S.fecha_vencimiento as fecha_vencimiento ,  S.created_at as fecha, U.name as usuario_crea
        FROM series_facturas S
        INNER JOIN users U on S.user_id = U.id
        INNER JOIN estados_series  F on S.estado = F.id';

        $result = DB::select($query);
        $api_Result['data'] = $result;

        return Response::json( $api_Result );
    }

    public function rangoDisponible()
    {
        $inicio = Input::get("inicio");
        if($inicio == "") $inicio =0;
        $fin = Input::get('fin');
        if($fin == "") $fin =0;
        $serie = Input::get("serie");
        if($serie == "") return 'true';

        $query = 'select s.serie, s.inicio, s.fin FROM series_facturas s  WHERE s.serie = "'.$serie.'" and s.fin >= "'.$inicio.'" ';
        $series = DB::select($query);
        
        $contador = count($series);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }
    
    public function rangoDisponible_edit()
    {
        $inicio = Input::get("inicio");
        if($inicio == "") $inicio =0;
        $fin = Input::get('fin');
        if($fin == "") $fin =0;
        $serie = Input::get("serie");
        if($serie == "") return 'true';
        $serie_id = Input::get("serie_id");

        $query = 'select s.serie, s.inicio, s.fin FROM series_facturas s  WHERE s.serie = "'.$serie.'" and s.fin >= "'.$inicio.'" AND s.id != "'.$serie_id.'" AND s.id <= "'.$serie_id.'" ';
        $series = DB::select($query);
        
        $contador = count($series);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }
    public function cargarSelect()
    {
        $result = DB::table('estados_series')
        ->select('estados_series.id','estados_series.estado')->get();

        return Response::json( $result );		
    }
}
