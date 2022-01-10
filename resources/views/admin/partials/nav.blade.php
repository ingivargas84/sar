    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
        <li class="header">Navegacion</li>
        <!-- Optionally, you can add icons to the links -->
        <li class="{{request()->is('admin')? 'active': ''}}" ><a href="{{route('dashboard')}}"><i class="fa fa-tachometer-alt"></i> <span>Inicio</span></a></li>
               
        <li class="treeview {{request()->is('empleados*', 'puestos*','destinos_pedidos*','tipos_localidad*','localidades*','unidades_medida*','categorias_insumos*','insumos*', 'productos*', 'categorias_menus*', 'recetas*', 'cajas*')? 'active': ''}}">
          <a href="#"><i class="fa fa-book"></i> <span>Catalogos Generales</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          

          <ul class="treeview-menu">
            <li class="{{request()->is('clientes')? 'active': ''}}"><a href="{{route('clientes.index')}}"> 
              <i class="fa fa-street-view"></i>Clientes</a>
            </li>  
          </ul>
          

          <ul class="treeview-menu">
            <li class="{{request()->is('series')? 'active': ''}}"><a href="{{route('series.index')}}"> 
              <i class="fa fa-book"></i>Series</a>
            </li>  
          </ul>

          
        </li>


        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-truck-loading"></i> <span>Gestión de Compras</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('proveedores')? 'active': ''}}"><a href="{{route('proveedores.index')}}"> 
              <i class="fa fa-users-cog"></i>Proveedores</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('compras')? 'active': ''}}"><a href="{{route('compras.index')}}"> 
              <i class="fa fa-pallet"></i>Registro de Compra</a>
            </li>  
          </ul>


        </li>


        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-mitten"></i> <span>Control de Cocina</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('destinos_pedidos')? 'active': ''}}"><a href="{{route('destinos_pedidos.index')}}"> 
              <i class="fa fa-list-ul"></i>Destinos de Pedidos</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('categorias_insumos')? 'active': ''}}"><a href="{{route('categorias_insumos.index')}}"> 
              <i class="fa fa-shopping-basket"></i>Categorias de Insumos</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('insumos')? 'active': ''}}"><a href="{{route('insumos.index')}}"> 
              <i class="fa fa-carrot"></i>Insumos</a>
            </li>  
          </ul>
          
          <ul class="treeview-menu">
            <li class="{{request()->is('unidades_medida')? 'active': ''}}"><a href="{{route('unidades_medida.index')}}"> 
              <i class="fa fa-temperature-low"></i>Unidades de Medida</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('recetas')? 'active': ''}}"><a href="{{route('recetas.index')}}"> 
              <i class="fa fa-blender"></i>Recetas</a>
            </li>  
          </ul>

        </li>



        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-utensils"></i> <span>Control de Restaurante</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('tipos_localidad')? 'active': ''}}"><a href="{{route('tipos_localidad.index')}}"> 
              <i class="fa fa-project-diagram"></i>Tipos de Localidad</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('localidades')? 'active': ''}}"><a href="{{route('localidades.index')}}"> 
              <i class="fa fa-chair"></i>Localidades</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('productos')? 'active': ''}}"><a href="{{route('productos.index')}}"> 
              <i class="fa fa-wine-bottle"></i>Producto Menú</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('categorias_menus')? 'active': ''}}"><a href="{{route('categorias_menus.index')}}"> 
              <i class="fa fa-file-signature"></i>Categorias de Menús</a>
            </li>  
          </ul>


        </li>



        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-cash-register"></i> <span>Control de Caja</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('cajas')? 'active': ''}}"><a href="{{route('cajas.index')}}"> 
              <i class="fa fa-coins"></i>Cajas</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('aperturas_cajas')? 'active': ''}}"><a href="{{route('aperturas_cajas.index')}}"> 
              <i class="fa fa-file-invoice-dollar"></i>Apertura/Cierre de Caja</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('compras_cajas')? 'active': ''}}"><a href="{{route('compras_cajas.index')}}"> 
              <i class="fa fa-hand-holding-usd"></i>Compras por Caja</a>
            </li>  
          </ul>   
          
          <ul class="treeview-menu">
            <li class="{{request()->is('tipos_pago')? 'active': ''}}"><a href="{{route('tipos_pago.index')}}"> 
              <i class="fa fa-search-dollar"></i>Tipos de Pago</a>
            </li>  
          </ul>

        </li>


        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-user-friends"></i> <span>Administración Personal</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
            <li class="{{request()->is('empleados')? 'active': ''}}"><a href="{{route('empleados.index')}}"> 
              <i class="fa fa-user-tie"></i>Empleados</a>
            </li>  
          </ul>

          <ul class="treeview-menu">
            <li class="{{request()->is('puestos')? 'active': ''}}"><a href="{{route('puestos.index')}}"> 
              <i class="fa fa-user-tag"></i>Puestos</a>
            </li>  
          </ul>      

        </li>


        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-print"></i> <span>Reportes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>


        </li>


        <li class="treeview {{request()->is('users*')? 'active': ''}}">
          <a href="#"><i class="fa fa-users"></i> <span>Gestion Usuarios</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{request()->is('users')? 'active': ''}}"><a href="{{route('users.index')}}"> 
              <i class="fa fa-eye"></i>Usuarios</a>
            </li>
            <li>
                <a href="#" data-toggle="modal" data-target="#modalResetPassword"><i class="fa fa-lock-open"></i>Cambiar contraseña</a>             
            </li>

          </ul>          
        </li>

        @role('Super-Administrador|Administrador')

        <li class="treeview {{request()->is('negocio*')? 'active': ''}}">
            <a href="#"><i class="fa fa-building"></i> <span>Mi Negocio</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
  
            <ul class="treeview-menu">
              <li class="{{request()->routeIs('negocio.edit')? 'active': ''}}"><a href="{{route('negocio.edit', 1)}}"> 
                <i class="fa fa-edit"></i>Editar Mi Negocio</a>
              </li>  
            </ul>
        </li>
        @endrole
        
        
    </ul>

    <!-- /.sidebar-menu -->