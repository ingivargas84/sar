<?php

namespace App\Http\Middleware;

use Closure;
use DB;
use App\User;

class CajeroMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $id = auth()->user()->id;
        $query = "SELECT C.id, C.nombre, U.name, U.id, AC.fecha_apertura from aperturas_cajas AC
        INNER JOIN users U on U.id = AC.user_cajero_id
        INNER JOIN cajas C on C.id = AC.caja_id WHERE AC.fecha_cierre is null AND U.id = $id " ;
        
        $result = DB::select($query);
        $contador = count($result);

        if (auth()->check() && !auth()->user()->hasRole('Cobrador')){
            return $next($request);
        }
        else{

            if(auth()->check() && auth()->user()->hasRole('Cobrador') && $contador > 0){
                return $next($request);             
            }
            else{
                auth()->logout();
                return redirect()
                ->route('login')
                ->with('MensajeEstado','El usuario ingresado no tiene caja abierta');
            }
            
        }
        
    }
}
