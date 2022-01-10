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
use App\Empleado;
use App\Puesto;
use App\EstadoEmpleado;


//use App\Http\Controllers\Controller;

class EmpleadosController extends Controller
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
         return view ("admin.empleados.index");
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        $puestos = Puesto::where('estado', 1)->get();
        return view("admin.empleados.create" , compact("puestos"));
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
         $empleado = Empleado::create($data);
 
         return redirect()->route('empleados.index')->withFlash('El empleado ha sido creado exitosamente!');
         //return Response::json($empleado);
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
         $query = Empleado::where("nit",$dato)->get();
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
         $dato = Input::get("emp_cui");
         $query = Empleado::where("emp_cui",$dato)->get();
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
     public function edit(Empleado $empleado)
     {
        $puestos = Puesto::where('estado', 1)->get();
        return view('admin.empleados.edit', compact('empleado', 'puestos'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Empleado $empleado, Request $request)
     {
        $this->validate($request,['nit' => 'unique:empleados,nit,'.$empleado->id
        ]);
        $this->validate($request,['emp_cui' => 'required|unique:empleados,emp_cui,'.$empleado->id
        ]);
        $empleado->update($request->all());
      
        return redirect()->route('empleados.index', $empleado)->with('flash','El empleado ha sido actualizado!');
     }

     public function asignarUser(Empleado $empleado, Request $request)
     {
         $data = $request->all();
        $empleado->update(['user_id' => $data['usuarios']]);
      
        return Response::json(['success' => 'Éxito']);
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Request $request)
     {
        $empleado = Empleado::where('id', $request->id)->first();
        $empleado->estado_id = 2;
        $empleado->save();
        return Response::json(['success' => 'Éxito']);
     }
 
     public function getInfo(Request $request)
     {
         $empleado = $request["data"];
 
         if ($empleado == "")
         {
             $result = "";
             return Response::json( $result);
         }
         else {
             $query = "SELECT e.nombre, e.apellido, p.sueldo 
 
             FROM empleados e
             
             INNER JOIN puestos p on p.id = e.puesto_id WHERE e.id ='".$empleado."'";
                 $result = DB::select($query);
                 return Response::json( $result);
             }
 
     }
     
     public function getJson(Request $params)
     {
         /*$query = "SELECT * FROM empleados ";
 
         $result = DB::select($query);
         $api_Result['data'] = $result;*/

         $api_Result['data'] = Empleado::with('puesto')->with('estado')->get();
 
         return Response::json( $api_Result );
     }
}
