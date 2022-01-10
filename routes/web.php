<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'middleware'=>['auth','estado', 'cajero'] ],
function(){ 
    Route::get('/admin','HomeController@index')->name('dashboard');

    Route::get('user/getJson' , 'UsersController@getJson' )->name('users.getJson');
    Route::get('users' , 'UsersController@index' )->name('users.index');
    Route::post('users' , 'UsersController@store' )->name('users.store');
    Route::delete('users/{user}' , 'UsersController@destroy' );
    Route::post('users/update/{user}' , 'UsersController@update' );
    Route::get('users/{user}/edit', 'UsersController@edit' );
    Route::post('users/reset/tercero' , 'UsersController@resetPasswordTercero')->name('users.reset.tercero');
    Route::post('users/reset' , 'UsersController@resetPassword')->name('users.reset');
    Route::get( '/users/cargar' , 'UsersController@cargarSelect')->name('users.cargar');
    Route::get( '/users/cargarA' , 'UsersController@cargarSelectApertura')->name('users.cargarA');

    Route::get( '/empleados' , 'EmpleadosController@index')->name('empleados.index');
    Route::get( '/empleados/getJson/' , 'EmpleadosController@getJson')->name('empleados.getJson');
    Route::get( '/empleados/new' , 'EmpleadosController@create')->name('empleados.new');
    Route::get( '/empleados/edit/{empleado}' , 'EmpleadosController@edit')->name('empleados.edit');
    Route::put( '/empleados/{empleado}/update' , 'EmpleadosController@update')->name('empleados.update');
    Route::post( '/empleados/save/' , 'EmpleadosController@store')->name('empleados.save');
    Route::delete('empleados/delete' , 'EmpleadosController@destroy')->name('empleados.delete');
    //Route::post( '/empleado/active/{empleado}' , 'EmpleadosController@active');
    Route::get('/empleados/nitDisponible/', 'EmpleadosController@nitDisponible')->name('empleados.nitDisponible');
    Route::get('cui-disponible/', 'EmpleadosController@dpiDisponible')->name('cui-disponible');
    Route::post( 'empleados/{empleado}/asignaruser' , 'EmpleadosController@asignarUser')->name('empleados.asignaruser');

    Route::get( '/negocio/{negocio}/edit' , 'NegocioController@edit')->name('negocio.edit');
    Route::put( '/negocio/{negocio}/update' , 'NegocioController@update')->name('negocio.update');

    Route::get( '/puestos' , 'PuestosController@index')->name('puestos.index');
    Route::get( '/puestos/getJson/' , 'PuestosController@getJson')->name('puestos.getJson');
    Route::put( '/puestos/{puesto}/update' , 'PuestosController@update')->name('puestos.update');
    Route::post( '/puestos/save' , 'PuestosController@store')->name('puestos.save');
    Route::post('/puestos/{puesto}/delete' , 'PuestosController@destroy');
    Route::get('/puestos/nombreDisponible/', 'PuestosController@nombreDisponible');
    Route::get('/puestos/nombreDisponibleEdit/', 'PuestosController@nombreDisponibleEdit');

    Route::get( '/destinos_pedidos' , 'DestinosPedidosController@index')->name('destinos_pedidos.index');
    Route::get( '/destinos_pedidos/getJson/' , 'DestinosPedidosController@getJson')->name('destinos_pedidos.getJson');;
    Route::put( '/destinos_pedidos/{destino}/update' , 'DestinosPedidosController@update')->name('destinos_pedidos.update');
    Route::post( '/destinos_pedidos/save' , 'DestinosPedidosController@store')->name('destinos_pedidos.save');
    Route::post('/destinos_pedidos/{destino}/delete' , 'DestinosPedidosController@destroy');
    Route::get('/destinos_pedidos/destinoDisponible/', 'DestinosPedidosController@destinoDisponible');
    Route::get('/destinos_pedidos/destinoDisponibleEdit/', 'DestinosPedidosController@destinoDisponibleEdit');

    Route::get( '/tipos_localidad' , 'TiposLocalidadController@index')->name('tipos_localidad.index');
    Route::get( '/tipos_localidad/getJson/' , 'TiposLocalidadController@getJson')->name('tipos_localidad.getJson');
    Route::put( '/tipos_localidad/{tipolocalidad}/update' , 'TiposLocalidadController@update')->name('tipos_localidad.update');
    Route::post( '/tipos_localidad/save' , 'TiposLocalidadController@store')->name('tipos_localidad.save');
    Route::post('/tipos_localidad/{tipolocalidad}/delete' , 'TiposLocalidadController@destroy');
    Route::get('/tipos_localidad/tipolocalidadDisponible/', 'TiposLocalidadController@tipolocalidadDisponible');
    Route::get('/tipos_localidad/tipolocalidadDisponibleEdit/', 'TiposLocalidadController@tipolocalidadDisponibleEdit');
    Route::get( '/tipos_localidad/cargar' , 'TiposLocalidadController@cargarSelect')->name('tipos_localidad.cargar');
    Route::get( '/tipos_localidad/{tipo_localidad}/mapa' , 'TiposLocalidadController@mapa')->name('tipos_localidad.mapa');
    Route::get( '/tipos_localidad/{tipo_localidad}/mapa_orden' , 'TiposLocalidadController@mapaOrden')->name('tipos_localidad.mapaOrden');
    Route::post( '/tipos_localidad/mapa/update' , 'TiposLocalidadController@mapaUpdate');

    Route::get( '/localidades' , 'LocalidadesController@index')->name('localidades.index');
    Route::get( '/localidades/getJson/' , 'LocalidadesController@getJson')->name('localidades.getJson');;
    Route::put( '/localidades/{localidad}/update' , 'LocalidadesController@update')->name('localidades.update');
    Route::post( '/localidades/save' , 'LocalidadesController@store')->name('localidades.save');
    Route::post('/localidades/{localidad}/delete' , 'LocalidadesController@destroy');
    Route::get('/localidades/nombreDisponible/', 'LocalidadesController@nombreDisponible');
    Route::get('/localidades/nombreDisponibleEdit/', 'LocalidadesController@nombreDisponibleEdit');
    Route::get( '/localidades/cargarMesaCambioOrden/' , 'LocalidadesController@cargarMesaCambioOrden')->name('localidades.cargarMesaCambioOrden');

    Route::get( '/unidades_medida' , 'UnidadesMedidaController@index')->name('unidades_medida.index');
    Route::get( '/unidades_medida/getJson/' , 'UnidadesMedidaController@getJson')->name('unidades_medida.getJson');
    Route::put( '/unidades_medida/{unidad_medida}/update' , 'UnidadesMedidaController@update')->name('unidades_medida.update');
    Route::post( '/unidades_medida/save' , 'UnidadesMedidaController@store')->name('unidades_medida.save');
    Route::post('/unidades_medida/{unidad_medida}/delete' , 'UnidadesMedidaController@destroy');
    Route::get('/unidades_medida/nombreDisponible/', 'UnidadesMedidaController@nombreDisponible');
    Route::get('/unidades_medida/nombreDisponibleEdit/', 'UnidadesMedidaController@nombreDisponibleEdit');

    Route::get( '/categorias_insumos' , 'CategoriasInsumosController@index')->name('categorias_insumos.index');
    Route::get( '/categorias_insumos/getJson/' , 'CategoriasInsumosController@getJson')->name('categorias_insumos.getJson');
    Route::put( '/categorias_insumos/update' , 'CategoriasInsumosController@update')->name('categorias_insumos.update');
    Route::post( '/categorias_insumos/save' , 'CategoriasInsumosController@store')->name('categorias_insumos.save');
    Route::post('/categorias_insumos/delete' , 'CategoriasInsumosController@destroy')->name('categorias_insumos.delete');
    Route::get('/categorias_insumos/nombreDisponible/', 'CategoriasInsumosController@nombreDisponible')->name('categorias_insumos.nombreDisponible');
    Route::get('/categorias_insumos/nombreDisponibleEdit/', 'CategoriasInsumosController@nombreDisponibleEdit')->name('categorias_insumos.nombreDisponibleEdit');

    Route::get( '/insumos' , 'InsumosController@index')->name('insumos.index');
    Route::get( '/insumos/getJson/' , 'InsumosController@getJson')->name('insumos.getJson');;
    Route::put( '/insumos/{insumo}/update' , 'InsumosController@update')->name('insumos.update');
    Route::post( '/insumos/save' , 'InsumosController@store')->name('insumos.save');
    Route::post('/insumos/{insumo}/delete' , 'InsumosController@destroy');
    Route::get('/insumos/nombreDisponible/', 'InsumosController@nombreDisponible')->name('insumos.nombreDisponible');
    Route::get('/insumos/nombreDisponibleEdit/', 'InsumosController@nombreDisponibleEdit')->name('insumos.nombreDisponibleEdit');
    Route::get( '/insumos/new' , 'InsumosController@create')->name('insumos.new');
    Route::get( '/insumos/{insumo}/edit' , 'InsumosController@edit')->name('insumos.edit');
    Route::get('/insumos/get/', 'InsumosController@getInfo')->name('insumos.get');
    Route::get( '/insumos/cargar/' , 'InsumosController@cargarSelect')->name('insumos.cargar');
    Route::get( '/insumos/cargar2/' , 'InsumosController@cargarSelect2')->name('insumos.cargar2');
    Route::get( '/insumos/cargar3/' , 'InsumosController@cargarSelect3')->name('insumos.cargar3');    

    Route::get( '/categorias_menus' , 'CategoriasMenusController@index')->name('categorias_menus.index');
    Route::get( '/categorias_menus/getJson/' , 'CategoriasMenusController@getJson')->name('categorias_menus.getJson');
    Route::put( '/categorias_menus/{categoria_menu}/update' , 'CategoriasMenusController@update')->name('categorias_menus.update');
    Route::post( '/categorias_menus/save' , 'CategoriasMenusController@store')->name('categorias_menus.save');
    Route::post('/categorias_menus/{categoria_menu}/delete' , 'CategoriasMenusController@destroy');
    Route::get('/categorias_menus/nombreDisponible/', 'CategoriasMenusController@nombreDisponible');
    Route::get('/categorias_menus/nombreDisponibleEdit/', 'CategoriasMenusController@nombreDisponibleEdit');

    Route::get( '/productos' , 'ProductosController@index')->name('productos.index');
    Route::get( '/productos/getJson/' , 'ProductosController@getJson')->name('productos.getJson');
    Route::put( '/productos/{producto}/update' , 'ProductosController@update')->name('productos.update');
    Route::post( '/productos/save' , 'ProductosController@store')->name('productos.save');
    Route::post('/productos/{producto}/delete' , 'ProductosController@destroy');
    Route::get('/productos/nombreDisponible/', 'ProductosController@nombreDisponible')->name('productos.nombreDisponible');
    Route::get('/productos/nombreDisponibleEdit/', 'ProductosController@nombreDisponibleEdit')->name('productos.nombreDisponibleEdit');
    Route::get( '/productos/new' , 'ProductosController@create')->name('productos.new');
    Route::get( '/productos/{producto}/edit' , 'ProductosController@edit')->name('productos.edit');
    Route::post('/productos/{producto}/activar' , 'ProductosController@activar');
    Route::get( '/productos/cargar/' , 'ProductosController@cargarCarta')->name('productos.cargar');

    Route::get( '/recetas' , 'RecetasController@index')->name('recetas.index');
    Route::get( '/recetas/getJson/' , 'RecetasController@getJson')->name('recetas.getJson');;
    Route::put( '/recetas/{receta}/update' , 'RecetasController@update')->name('recetas.update');
    Route::post( '/recetas/save' , 'RecetasController@store')->name('recetas.save');
    Route::post('/recetas/{receta}/delete' , 'RecetasController@destroy');
    //Route::get('/recetas/nombreDisponible/', 'RecetasController@nombreDisponible');
    //Route::get('/recetas/nombreDisponibleEdit/', 'RecetasController@nombreDisponibleEdit');
    Route::get( '/recetas/new' , 'RecetasController@create')->name('recetas.new');
    Route::get( '/recetas/{receta}/edit' , 'RecetasController@edit')->name('recetas.edit');

    Route::get('/recetas/detalle/{receta}', 'RecetasController@show')->name('recetas.show');
    Route::get( '/recetas/detalle/{receta}/getJson' , 'RecetasController@getJsonDetalle' )->name('recetas.getJsonDetalle');
    Route::put( '/recetas/detalle/{recetadetalle}/update' , 'RecetasController@updateDetalle' );
    Route::post('/recetas/detalle/{recetadetalle}/delete', 'RecetasController@destroyDetalle')->name('recetas.detalle.delete');
    //Route::delete( '/recetasdetalle/destroy/{recetadetalle}' , 'RecetasController@destroyDetalle' );
    //Route::get('/recetasdetalle/edit/{recetadetalle}' , 'RecetasController@editDetalle');

    Route::get( '/cajas' , 'CajasController@index')->name('cajas.index');
    Route::get( '/cajas/getJson/' , 'CajasController@getJson')->name('cajas.getJson');
    Route::put( '/cajas/update' , 'CajasController@update')->name('cajas.update');
    Route::post( '/cajas/save' , 'CajasController@store')->name('cajas.save');
    Route::post('/cajas/delete' , 'CajasController@destroy')->name('cajas.delete');
    Route::get('/cajas/nombreDisponible/', 'CajasController@nombreDisponible')->name('cajas.nombreDisponible');
    Route::get('/cajas/nombreDisponibleEdit/', 'CajasController@nombreDisponibleEdit')->name('cajas.nombreDisponibleEdit');
    Route::get('/cajas/movimiento/{caja}', 'CajasController@show')->name('cajas.show');
    Route::get( '/cajas/movimiento/{caja}/getJson' , 'CajasController@getJsonDetalle' )->name('cajas.getJsonDetalle');

    Route::get( '/clientes' , 'ClientesController@index')->name('clientes.index');
    Route::get( '/clientes/getJson/' , 'ClientesController@getJson')->name('clientes.getJson');
    Route::get( '/clientes/new' , 'ClientesController@create')->name('clientes.new');
    Route::get( '/clientes/edit/{cliente}' , 'ClientesController@edit')->name('clientes.edit');
    Route::put( '/clientes/{cliente}/update' , 'ClientesController@update')->name('clientes.update');
    Route::post( '/clientes/save/' , 'ClientesController@store')->name('clientes.save');
    Route::post('/clientes/{cliente}/delete' , 'ClientesController@destroy');
    Route::post('/clientes/{cliente}/activar' , 'ClientesController@activar');
    Route::get('/clientes/nitDisponible/', 'ClientesController@nitDisponible')->name('clientes.nitDisponible');
    Route::get('/clientes/dpiDisponible/', 'ClientesController@dpiDisponible')->name('clientes.dpiDisponible');

    Route::get( '/proveedores' , 'ProveedoresController@index')->name('proveedores.index');
    Route::get( '/proveedores/getJson/' , 'ProveedoresController@getJson')->name('proveedores.getJson');
    Route::get( '/proveedores/new' , 'ProveedoresController@create')->name('proveedores.new');
    Route::get( '/proveedores/edit/{proveedor}' , 'ProveedoresController@edit')->name('proveedores.edit');
    Route::put( '/proveedores/{proveedor}/update' , 'ProveedoresController@update')->name('proveedores.update');
    Route::post( '/proveedores/save/' , 'ProveedoresController@store')->name('proveedores.save');
    Route::post('/proveedores/{proveedor}/delete' , 'ProveedoresController@destroy');
    Route::post('/proveedores/{proveedor}/activar' , 'ProveedoresController@activar');
    Route::get('/proveedores/nitDisponible/', 'ProveedoresController@nitDisponible')->name('proveedores.nitDisponible');

    Route::get( '/compras' , 'ComprasController@index')->name('compras.index');
    Route::get( '/compras/getJson/' , 'ComprasController@getJson')->name('compras.getJson');;
    Route::put( '/compras/{compra}/update' , 'ComprasController@update')->name('compras.update');
    Route::post( '/compras/save' , 'ComprasController@store')->name('compras.save');
    Route::post('/compras/{compra}/delete' , 'ComprasController@destroy');
    Route::get( '/compras/new' , 'ComprasController@create')->name('compras.new');
    Route::get( '/compras/edit/{compra}' , 'ComprasController@edit')->name('compras.edit');

    Route::get('/compras/detalle/{compra}', 'ComprasController@show')->name('compras.show');
    Route::get( '/compras/detalle/{compra}/getJson' , 'ComprasController@getJsonDetalle' )->name('compras.getJsonDetalle');
    Route::put( '/compras/detalle/{compradetalle}/update' , 'ComprasController@updateDetalle' );
    Route::post('/compras/detalle/{compradetalle}/delete', 'ComprasController@destroyDetalle')->name('compras.detalle.delete');
    //Route::get('/comprasdetalle/edit/{compradetalle}' , 'ComprasController@editDetalle');

    //Rutas para Series
    Route::get( '/series' , 'SeriesFacturaController@index')->name('series.index');
    Route::get( '/series/getJson/' , 'SeriesFacturaController@getJson');
    Route::post( '/series/save/' , 'SeriesFacturaController@store');
    Route::put( '/series/{serie}/update' , 'SeriesFacturaController@update');
    Route::get( '/series/rangoDisponible/', 'SeriesFacturaController@rangoDisponible');
    Route::get( '/series/rangoDisponible-edit/', 'SeriesFacturaController@rangoDisponible_edit');
    Route::post('/series/{serie}/delete' , 'SeriesFacturaController@destroy');
    Route::post('/series/{serie}/cambiarestado' , 'SeriesFacturaController@cambiarestado');
    Route::get('/series/cargarselect' , 'SeriesFacturaController@cargarSelect');

    Route::get( '/tipos_pago' , 'TiposPagoController@index')->name('tipos_pago.index');
    Route::get( '/tipos_pago/getJson/' , 'TiposPagoController@getJson')->name('tipos_pago.getJson');
    Route::put( '/tipos_pago/{tipo_pago}/update' , 'TiposPagoController@update')->name('tipos_pago.update');
    Route::post( '/tipos_pago/save' , 'TiposPagoController@store')->name('tipos_pago.save');
    Route::post('/tipos_pago/{tipo_pago}/delete' , 'TiposPagoController@destroy');
    Route::get('/tipos_pago/nombreDisponible/', 'TiposPagoController@nombreDisponible');
    Route::get('/tipos_pago/nombreDisponibleEdit/', 'TiposPagoController@nombreDisponibleEdit');

    Route::get( '/aperturas_cajas' , 'AperturasCajasController@index')->name('aperturas_cajas.index');
    Route::get( '/aperturas_cajas/getJson/' , 'AperturasCajasController@getJson')->name('aperturas_cajas.getJson');
    Route::put( '/aperturas_cajas/{tipo_pago}/update' , 'AperturasCajasController@update')->name('aperturas_cajas.update');
    //Route::post( '/aperturas_cajas/save' , 'AperturasCajasController@store')->name('aperturas_cajas.save');
    Route::post('/aperturas_cajas/{tipo_pago}/delete' , 'AperturasCajasController@destroy');

    Route::middleware('role:Administrador|Super-Administrador')
    ->post( '/aperturas_cajas/apertura' , 'AperturasCajasController@apertura')->name('aperturas_cajas.apertura');
    Route::middleware('role:Administrador|Super-Administrador')
    ->post( '/aperturas_cajas/cierre' , 'AperturasCajasController@cierre')->name('aperturas_cajas.cierre');
    Route::get( '/aperturas_cajas/get' , 'AperturasCajasController@get')->name('aperturas_cajas.get');

    Route::get( '/compras_cajas' , 'ComprasCajasController@index')->name('compras_cajas.index');
    Route::get( '/compras_cajas/getJson/' , 'ComprasCajasController@getJson')->name('compras_cajas.getJson');
    Route::post( '/compras_cajas/save' , 'ComprasCajasController@store')->name('compras_cajas.save');

    Route::post( '/ordenes_maestro/save' , 'OrdenesMaestroController@store')->name('ordenes_maestro.save');
    Route::get( '/ordenes_maestro/{orden_maestro}/edit' , 'OrdenesMaestroController@edit')->name('ordenes_maestro.edit');
    Route::get( '/ordenes_maestro/{orden_maestro}/getJson' , 'OrdenesMaestroController@getJson' )->name('ordenes_maestro.getJson');
    Route::get( '/ordenes_maestro/mesas/{orden_maestro}/getJson' , 'OrdenesMaestroController@getMesas' )->name('ordenes_maestro.getMesas');
    Route::delete('/ordenes_maestro/{orden_maestro}/delete' , 'OrdenesMaestroController@destroy');
    Route::get('/ordenes_maestro/actual' , 'OrdenesMaestroController@ordenActual');
    Route::post( '/ordenes_maestro/cambiarMesa' , 'OrdenesMaestroController@cambiarMesa')->name('ordenes_maestro.cambiarMesa');

    //Rutas mapa de mesas
    Route::get( '/localidades/{localidad}/bloquear' , 'LocalidadesController@bloquear')->name('localidades.bloquear');
    Route::get( '/localidades/{localidad}/liberar' , 'LocalidadesController@liberar')->name('localidades.liberar');
    Route::get( '/localidades/{localidad}/liberarSeguro' , 'LocalidadesController@liberarSeguro')->name('localidades.liberarSeguro');

    //Rutas ordenes o cuentas
    Route::get( '/ordenes_listado' , 'OrdenesController@indexOrdenes')->name('ordenes.indexOrdenes');
    Route::get( '/ordenes' , 'OrdenesController@index')->name('ordenes.index');
    Route::get( '/ordenes/new' , 'OrdenesController@create')->name('ordenes.new');
    Route::get( '/ordenes/detalle/{orden}/getJson' , 'OrdenesController@getJsonDetalle' )->name('ordenes.getJsonDetalle');
    Route::put( '/ordenes/{orden}/update' , 'OrdenesController@update')->name('ordenes.update');
    Route::post( '/ordenes/save' , 'OrdenesController@store')->name('ordenes.save');
    Route::post( '/ordenes/saveCuenta' , 'OrdenesController@storeCuenta')->name('ordenes.saveCuenta');
    Route::delete('/ordenes/detalle/delete', 'OrdenesController@destroyDetalle')->name('ordenes.detalle.delete');
    Route::delete('/ordenes/producto/delete', 'OrdenesController@destroyProducto')->name('ordenes.producto.delete');
    Route::post('/ordenes/detalle/menos', 'OrdenesController@MenosCantidad')->name('ordenes.detalle.MenosCantidad');

    



    //Rutas Ordenes en Cocina
    Route::get( '/ordenes_cocina' , 'OrdenesCocinaController@index')->name('ordenes_cocina.index');
    Route::post( '/ordenes_cocina/actualizar_estado' , 'OrdenesCocinaController@actualizarEstado')->name('ordenes_cocina.actualizarEstado');
    
});


Route::get('/', function () {
    $negocio = App\Negocio::all();
    return view('welcome', compact('negocio'));
});

//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home')->middleware(['estado']);

// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('/user/get/' , 'Auth\LoginController@getInfo')->name('user.get');
Route::post('/user/contador' , 'Auth\LoginController@Contador')->name('user.contador');
Route::post('/password/reset2' , 'Auth\ForgotPasswordController@ResetPassword')->name('password.reset2');
Route::get('/user-existe/', 'Auth\LoginController@userExiste')->name('user.existe');

//Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
/*Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');*/