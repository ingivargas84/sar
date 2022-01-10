<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Producto;
use App\CategoriaMenu;
use Validator;

use App\Events\ActualizacionBitacora;
use DB;
use App\DestinoPedido;

class ProductosController extends Controller
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
        $user = Auth::User();
        return view ("admin.productos.index",compact('user'));
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
 
         $producto = new Producto;
         $producto->nombre = $data['nombre'];
         $producto->categoria_menu_id = $data['categoria_menu_id'];
         $producto->precio = $data['precio'];
         $producto->destino_pedido_id = $data['destino_pedido_id'];
         $producto->user_id = Auth::user()->id;
         $producto->save();                       
 
         event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Creación','', $producto,'productos'));
 
         return redirect()->route('productos.index')->withFlash('El producto ha sido creado exitosamente!');
     }

     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        $categorias = CategoriaMenu::all();
        $destinos = DestinoPedido::all();
        return view("admin.productos.create" , compact('categorias', 'destinos'));
     }
 
     public function nombreDisponible()
     {
         $dato = Input::get("nombre");
         $query = Producto::where("nombre",$dato)->get();
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
 
         $query = Producto::where("nombre",$dato)->where('id','!=', $id)->get();
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
      public function edit(Producto $producto)
      {
        if($producto->estado == 1){
            $categorias = CategoriaMenu::all();
            $destinos = DestinoPedido::all();
            return view("admin.productos.edit" , compact('categorias', 'producto', 'destinos'));           
        }
        else{
            return redirect()->route('productos.index')->with('alerta','El Producto esta desactivado, no es posible editar');
        }
       
      }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Producto $producto, Request $request)
     {
         $productoA = $producto;
         $producto->nombre = $request->nombre;
         $producto->categoria_menu_id = $request->categoria_menu_id;
         $producto->precio = $request->precio;
         $producto->destino_pedido_id = $request->destino_pedido_id;
         $producto->save();

         event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Edición',$productoA, $producto,'productos'));
         
         return redirect()->route('productos.index')->withFlash('El producto ha sido modificado exitosamente!');
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Producto $producto, Request $request)
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
             $producto->estado = 0;
             $producto->save();
             event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Inactivación','','','productos'));
 
             return Response::json(['success' => 'Éxito']);
 
          }
 
          else{
             return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
          }
     }

     public function activar(Producto $producto, Request $request)
     {
        $producto->estado = 1;
        $producto->save();
        event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Activación','','','productos'));

        return Response::json(['success' => 'Éxito']);       
     }
     
     public function getJson(Request $params)
     { 
         $api_Result['data'] = Producto::with('user')->with('categoria_menu')->get();
 
         return Response::json( $api_Result );
     }

    public function cargarSelect()
    {
        $dato = Input::get("producto_id");

        if ($dato == ""){
            $dato = 0;
        }

        $result = DB::table('productos')
        ->select('productos.id','productos.nombre')
        ->leftJoin('recetas','productos.id','=','recetas.producto_id')
        ->wherenull('recetas.producto_id')
        ->orWhere('productos.id', '=', $dato)
        ->get();

        return Response::json( $result );		
    }

    public function cargarCarta()
	{
        $dato = Input::get("categoria");
        $cuenta = Input::get('cuenta');

        if ($dato == "")
        {
            $dato = 0;
        }

        if ($cuenta == ""){
            $cuenta = 0;
        }

        if($dato == "todo"){
            if($cuenta == 0){
                $result = DB::table('productos')
                ->select('productos.id','productos.nombre', 'productos.precio')
                ->where('productos.estado', 1)
                ->get();

            }else{
                $query = "select P.id, P.nombre, P.precio from productos P 
                LEFT JOIN ordenes_detalles OD on P.id = OD.producto_id AND OD.orden_id = ".$cuenta."
                WHERE OD.producto_id is null AND P.estado = 1 ";

                $result = DB::select($query);
            }
            
        }else{
            /*$result = DB::table('productos as P')
            ->select('P.id','P.nombre', 'P.precio')
            ->leftJoin('ordenes_detalles as OD','P.id','=','OD.producto_id', 'AND', 'OD.orden_id', '=', $cuenta)
            ->wherenull('OD.producto_id')
            ->where('P.categoria_menu_id', $dato)
            ->where('P.estado', 1)
            ->get();*/

            $query = "select P.id, P.nombre, P.precio from productos P 
            LEFT JOIN ordenes_detalles OD on P.id = OD.producto_id AND OD.orden_id = ".$cuenta."
            WHERE OD.producto_id is null AND P.estado = 1 AND P.categoria_menu_id = ".$dato." ";

            $result = DB::select($query);
        }

        return Response::json( $result );		
    }
}
