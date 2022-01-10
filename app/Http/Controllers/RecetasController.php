<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Receta;
use App\Producto;
use App\UnidadMedida;
use App\Insumo;
use Validator;
Use DB;

use App\Events\ActualizacionBitacora;
use App\RecetaDetalle;

class RecetasController extends Controller
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
        return view ("admin.recetas.index");
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)
    {  
        try{
			DB::beginTransaction();

            $todo_request = $request->all();
            $formulario_request = $todo_request['formData'];
            $formulario_request["user_id"] = Auth::user()->id;
            $receta_maestro = Receta::create($formulario_request);

            //Guarda Detalle

            $Detalles = $todo_request['detalle'];

            foreach($Detalles as $detalle) {

                $detalle['user_id'] = Auth::user()->id;
                $detalle['insumo_id'] = $detalle['insumo_id'];
                $detalle['cantidad'] = $detalle["cantidad"];

                $receta_maestro->recetas_detalle()->create($detalle);

                event(new ActualizacionBitacora($receta_maestro->id, Auth::user()->id,'Creación','',$receta_maestro,'recetas'));	
                
            }

		DB::commit();
		return Response::json(['success' => 'ok']);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
    }

    public function show(Receta $receta)
    {
        /*$insumos = DB::table('insumos')
        ->select('insumos.id','insumos.nombre', 'insumos.estado')
        ->leftjoin('recetas_detalle', function($join){
            $join->on('insumos.id','=','recetas_detalle.insumo_id')->where('recetas_detalle.receta_id', 3);
        })
        ->where('insumos.estado', 1)
        ->wherenull('recetas_detalle.insumo_id')
        ->toSql();*/
        
        $unidades = UnidadMedida::where('estado', 1)->get();
        return view('admin.recetas.show', compact('receta', 'unidades'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $unidades = UnidadMedida::where('estado', 1)->get();
        $productos = DB::table('productos')
        ->select('productos.id','productos.nombre', 'productos.estado')
        ->leftjoin('recetas', function($join){
            $join->on('productos.id','=','recetas.producto_id')->where('recetas.estado', '=', '1');
        })
        ->where('productos.estado', 1)
        ->wherenull('recetas.producto_id')
        ->get();

        return view("admin.recetas.create" , compact('unidades', 'productos'));
    }
 
    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = Receta::where("nombre",$dato)
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

        $query = Receta::where("nombre",$dato)
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
    /*public function update(Receta $receta, Request $request)
    {

        $respuesta = $request->all();

        event(new ActualizacionBitacora($receta->id, Auth::user()->id,'Edición',$receta->nombre, $respuesta['nombre'],'recetas'));
        $receta->nombre = $request->nombre;
        $receta->save();

        return Response::json(['success' => 'Éxito']);
    }*/

    public function updateDetalle(RecetaDetalle $recetadetalle, Request $request)
    {
        $nuevos_datos = array(
            'insumo_id' => $request->insumo_id,
            'cantidad' => $request->cantidad
            );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($recetadetalle->id, Auth::user()->id,'Edición',$recetadetalle, $json,'recetas_detalle'));
        $recetadetalle->cantidad = $request->cantidad;
        $recetadetalle->insumo_id = $request->insumo_id;
        $recetadetalle->save();

        return Response::json(['success' => 'Éxito']);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Receta $receta, Request $request)
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
            $receta->estado = 0;
            $receta->save();
            event(new ActualizacionBitacora($receta->id, Auth::user()->id,'Inactivación','','','recetas'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }

    public function destroyDetalle(RecetaDetalle $recetadetalle, Request $request)
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
            $recetadetalle->delete();
            event(new ActualizacionBitacora($recetadetalle->id, Auth::user()->id,'Eliminación','','','recetas_detalle'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }
    
    public function getJson(Request $params)
    {

        $api_Result['data'] = Receta::where('estado', 1)->with('user', 'producto')->get();

        return Response::json( $api_Result );
    }

    public function getJsonDetalle(Request $params, $receta)
	{
		$query = 'SELECT RD.id, I.nombre, I.id as insumo_id, RD.cantidad, UM.nombre as unidad_medida, UM.id as unidad_medida_id FROM recetas_detalle RD
        INNER JOIN insumos I on I.id = RD.insumo_id 
        INNER JOIN unidades_medida UM on UM.id = I.medida_id
        WHERE RD.receta_id = '.$receta.'';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
}
