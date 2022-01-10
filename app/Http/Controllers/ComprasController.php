<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Compra;
use App\CompraDetalle;
use App\CompraEstado;
use App\Proveedor;
use App\UnidadMedida;
use App\Insumo;
use Validator;
use DB;

use App\Events\ActualizacionBitacora;
use App\MovimientoInsumo;

class ComprasController extends Controller
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
        return view ("admin.compras.index");
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
            $formulario_request["fecha_compra"] = Carbon::now();
            $compra_maestro = Compra::create($formulario_request);

            //Guarda Detalle

            $Detalles = $todo_request['detalle'];

            foreach($Detalles as $detalle) {

                $detalle['insumo_id'] = $detalle['insumo_id'];
                $detalle['cantidad'] = $detalle["cantidad"];
                $detalle['precio'] = $detalle["precio"];
                $detalle['subtotal'] = $detalle["subtotal_compra"];
                $detalle['fecha_ingreso'] = Carbon::now();
                $detalle['cantidad_convertida'] = $detalle["cantidad_medida"] * $detalle["cantidad"];

                $detallemovimiento = MovimientoInsumo::create($detalle);
				$detalle["movimiento_insumo_id"] = $detallemovimiento->id;

                $compra_maestro->compras_detalle()->create($detalle);

                event(new ActualizacionBitacora($compra_maestro->id, Auth::user()->id,'Creación','',$compra_maestro,'compras'));	
                
            }

		DB::commit();
		return Response::json(['success' => 'ok']);
		}

		catch(Exception $e)
		{
            DB::rollBack();
		}
    }

    public function show(Compra $compra)
    {       
        $unidades = UnidadMedida::where('estado', 1)->get();
        return view('admin.compras.show', compact('compra', 'unidades'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create()
    {
        $unidades = UnidadMedida::where('estado', 1)->get();
        $proveedores = Proveedor::where('estado', 1)->get();
        $insumos = Insumo::where('estado', 1)->get();

        return view("admin.compras.create" , compact('unidades', 'insumos', 'proveedores'));
    }
    
    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Compra $compra, Request $request)
    {
        $nuevos_datos = array(
            'serie' => $request->serie,
            'numero_doc' => $request->numero_doc,
            'fecha_factura' => $request->fecha_factura
            );
        $json = json_encode($nuevos_datos);


        event(new ActualizacionBitacora($compra->id, Auth::user()->id,'Edición',$compra, $json,'compras'));

        $compra->update($nuevos_datos);

        return Response::json(['success' => 'Éxito']);
    }

    public function updateDetalle(CompraDetalle $compradetalle, Request $request)
    {
        $nuevos_datos = array(
            'insumo_id' => $request->insumo_id,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
            'subtotal' => $request->precio * $request->cantidad
            );
        $json = json_encode($nuevos_datos);

        //Se actualiza el total de la factura
        $compra = Compra::where('id', $compradetalle->compra_id)->first();
        $subtotal_nuevo = $request->cantidad * $request->precio;
		$nuevoTotalFactura = $compra->total - $compradetalle->subtotal + $subtotal_nuevo;
		$compra->total = $nuevoTotalFactura;
        $compra->save();
        
        //Se actualiza el movimiento de insumo
        $movimiento = MovimientoInsumo::where('id', $compradetalle->movimiento_insumo_id)->first();
        $insumo = Insumo::where('id', $request->insumo_id)->first();
        $cantidad_medida = $insumo->cantidad_medida;
        $movimiento->cantidad = $request->cantidad;
        $movimiento->insumo_id = $request->insumo_id;
        $movimiento->precio = $request->precio;
        $movimiento->cantidad_convertida = $request->cantidad * $cantidad_medida;
        $movimiento->save();

        event(new ActualizacionBitacora($compradetalle->id, Auth::user()->id,'Edición',$compradetalle, $json,'compras_detalle'));
        $compradetalle->update($nuevos_datos);

        return Response::json(['success' => 'Éxito', 'total_nuevo' => $nuevoTotalFactura]);
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy(Compra $compra, Request $request)
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

            $detalles = CompraDetalle::where('compra_id', $compra->id)->get();

            foreach($detalles as $detalle)
            {
                $movimiento = MovimientoInsumo::where('id', $detalle["movimiento_insumo_id"])
                ->get()->first();
                
                $movimiento->update(['cantidad' => 0, 'cantidad_convertida' => 0, 'precio' => 0]);
            }

            $compra->compra_estado_id = 3;
            $compra->save();
            event(new ActualizacionBitacora($compra->id, Auth::user()->id,'Inactivación','','','compras'));

            return Response::json(['success' => 'Éxito']);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }

    public function destroyDetalle(CompraDetalle $compradetalle, Request $request)
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
            //Se actualiza el total de la factura
            //$compra = Compra::where('id', $compradetalle->compra_id)->first();
            $compra = $compradetalle->compra()->first();
            //dd($compra);
            $nuevoTotalFactura = $compra->total - $compradetalle->subtotal;
            $compra->total = $nuevoTotalFactura;
            $compra->save();

            $movimiento = MovimientoInsumo::where('id', $compradetalle->movimiento_insumo_id)
            ->get()->first();
                
            $movimiento->update(['cantidad' => 0, 'cantidad_convertida' => 0, 'precio' => 0]);

            $compradetalle->delete();

            if($compradetalle->count() == 0 ){
                $compra->compra_estado_id = 3;
                $compra->save();
            }
            event(new ActualizacionBitacora($compradetalle->id, Auth::user()->id,'Eliminación','','','compras_detalle'));

            return Response::json(['success' => 'Éxito', 'total_nuevo' => $nuevoTotalFactura]);

        }

        else{
            return  Response::json(['password_actual' => 'La contraseña no coincide'], 422);
        }

    }
    
    public function getJson(Request $params)
    {

        $api_Result['data'] = Compra::with('proveedor', 'compra_estado')->get();

        return Response::json( $api_Result );
    }

    public function getJsonDetalle(Request $params, $compra)
	{
		$query = 'SELECT CD.id, CD.precio, CD.subtotal, I.nombre, I.id as insumo_id, CD.cantidad, UM.nombre as unidad_medida, UM.id as unidad_medida_id, C.compra_estado_id as estado FROM compras_detalle CD
        INNER JOIN insumos I on I.id = CD.insumo_id 
        INNER JOIN unidades_medida UM on UM.id = I.unidad_id
        INNER JOIN compras C on CD.compra_id = C.id
        WHERE CD.compra_id = '.$compra.'';

		$result = DB::select($query);
		$api_Result['data'] = $result;

		return Response::json( $api_Result );
	}
}
