<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Insumo;
use App\CategoriaInsumo;
use App\UnidadMedida;
use Validator;
use DB;

use App\Events\ActualizacionBitacora;

class InsumosController extends Controller
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
         return view ("admin.insumos.index");
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
 
         $insumo = new Insumo;
         $insumo->nombre = $data['nombre'];
         $insumo->unidad_id = $data['unidad_id'];
         $insumo->categoria_insumo_id = $data['categoria_insumo_id'];
         $insumo->medida_id = $data['medida_id'];
         $insumo->cantidad_medida = $data['cantidad_medida'];
         $insumo->stock_minimo = $data['stock_minimo'];
         $insumo->user_id = Auth::user()->id;
         $insumo->save();                       
 
         event(new ActualizacionBitacora($insumo->id, Auth::user()->id,'Creación','', $insumo,'insumos'));
 
         return redirect()->route('insumos.index')->withFlash('El insumo ha sido creado exitosamente!');
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        $unidades = UnidadMedida::all();
        $categorias = CategoriaInsumo::all();
        return view("admin.insumos.create" , compact("unidades", 'categorias'));
     }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = Insumo::where("nombre",$dato)
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
 
         $query = Insumo::where("nombre",$dato)
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
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
      public function edit(Insumo $insumo)
      {
        $unidades = UnidadMedida::all();
        $categorias = CategoriaInsumo::all();
        return view("admin.insumos.edit" , compact("unidades", 'categorias', 'insumo'));
      }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Insumo $insumo, Request $request)
     {
        $nuevos_datos = array(
            'nombre' => $request->nombre,
            'unidad_id' => $request->unidad_id,
            'categoria_insumo_id' => $request->categoria_insumo_id,
            'medida_id' => $request->medida_id,
            'cantidad_medida' => $request->cantidad_medida,
            'stock_minimo' => $request->stock_minimo
            );
        $json = json_encode($nuevos_datos);
 
         event(new ActualizacionBitacora($insumo->id, Auth::user()->id,'Edición',$insumo, $json,'insumos'));
         $insumo->nombre = $request->nombre;
         $insumo->unidad_id = $request->unidad_id;
         $insumo->categoria_insumo_id = $request->categoria_insumo_id;
         $insumo->medida_id = $request->medida_id;
         $insumo->cantidad_medida = $request->cantidad_medida;
         $insumo->stock_minimo = $request->stock_minimo;
         $insumo->save();
 
         return redirect()->route('insumos.index')->withFlash('El insumo ha sido modificado exitosamente!');
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Insumo $insumo, Request $request)
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
             $insumo->estado = 0;
             $insumo->save();
             event(new ActualizacionBitacora($insumo->id, Auth::user()->id,'Inactivación','','','insumos'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
 
        
         
     }
     
     public function getJson(Request $params)
     {
         /*$query = "SELECT * FROM insumos ";
 
         $result = DB::select($query);
         $api_Result['data'] = $result;*/
 
         $api_Result['data'] = Insumo::where('estado', 1)->with('user')->with('categoria_insumo')->get();
 
         return Response::json( $api_Result );
     }

    public function getInfo(Request $request)
	{
        $codigo = $request["codigo"];

		if ($codigo == "")
		{
			$result = "";
			return Response::json($result);
		}
        else 
        {
            //$query = "select * from insumos WHERE id = '".$codigo."' ";
            //$result = DB::select($query);
            $result = DB::table('insumos')
            ->select('insumos.id','insumos.nombre', 'insumos.unidad_id', 'insumos.medida_id', 'insumos.cantidad_medida', 'insumos.estado', 'movimientos_insumos.precio', 'movimientos_insumos.id as id2' )
            ->leftjoin('movimientos_insumos', function($join){
                $join->on('insumos.id','=','movimientos_insumos.insumo_id');
            })
            ->where('insumos.id', $codigo)
            ->orderBy('movimientos_insumos.id', 'desc')
            ->limit(1)
            ->get();
            return Response::json($result);
        }
    }

    public function cargarSelect()
    {
        $query = Input::get("query");

        $result = DB::select($query);
        //$api_Result['data'] = $result;

        return Response::json( $result );		
    }

    public function cargarSelect2()
    {
        $insumo_id = Input::get("insumo_id");
        $receta_id = Input::get("receta_id");

        if ($insumo_id == ""){
            $insumo_id = 0;
        }

        $query = "SELECT I.id, I.nombre, I.unidad_id, I.cantidad_medida, I.medida_id FROM insumos I
        LEFT JOIN recetas_detalle RD on I.id = RD.insumo_id AND RD.receta_id = ".$receta_id." 
        WHERE RD.insumo_id is null AND I.estado = 1 OR I.id = ".$insumo_id." ";

        $result = DB::select($query);
		return Response::json( $result );			
    }

    public function cargarSelect3()
    {
        $insumo_id = Input::get("insumo_id");
        $compra_id = Input::get("compra_id");

        if ($insumo_id == ""){
            $insumo_id = 0;
        }

        $query = "SELECT I.id, I.nombre, I.unidad_id, I.cantidad_medida, I.medida_id FROM insumos I
        LEFT JOIN compras_detalle CD on I.id = CD.insumo_id AND CD.compra_id = ".$compra_id." 
        WHERE CD.insumo_id is null AND I.estado = 1 OR I.id = ".$insumo_id." ";

        $result = DB::select($query);
		return Response::json( $result );			
    }
}
