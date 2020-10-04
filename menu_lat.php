
<div class="page-sidebar navbar-collapse collapse">

    <ul class="page-sidebar-menu  page-header-fixed " data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200" style="padding-top: 0px">
        <li class="sidebar-toggler-wrapper hide">
            <div class="sidebar-toggler"> </div>
        </li>

        <li class="nav-item <?php if($pagina == 'inicio'){ echo 'active open';}?>">
            <a href="index.php" class="nav-link nav-toggle">
                <i class="icon-home"></i>
                <span class="title">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="heading">
            <h3 class="uppercase">GESTIÓN COMERCIAL</h3>
        </li>
        <li class="nav-item  <?php if($pagina == 'itinerario'){ echo 'active open';}?> ">
            <a href="itinerario.php" class="nav-link nav-toggle">
                <i class="icon-folder"></i>
                <span class="title">Itinerario Visitas</span>
                <span class="selected"></span>
            </a>
        </li>
        <li class="nav-item  <?php if($pagina == 'planeador'){ echo 'active open';}?> ">
            <a href="planeador.php" class="nav-link nav-toggle">
                <i class="icon-calendar"></i>
                <span class="title">Planeador</span>
                <span class="selected"></span>
            </a>
        </li>

        <?php 
        if (in_array(103, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'movimientos'){ echo 'active open';}?> ">
            <a href="movimientos.php" class="nav-link nav-toggle">
                <i class="icon-graph"></i>
                <span class="title">Movimientos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(16, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'comisiones'){ echo 'active open';}?> ">
            <a href="cuadro_comisiones.php" class="nav-link nav-toggle">
                <i class="icon-calculator"></i>
                <span class="title">Cuadro de comisiones</span>
            </a>
        </li>
        <?php 
        } 

        if (in_array(107, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'celebres'){ echo 'active open';}?> ">
            <a href="clientes_celebres.php" class="nav-link nav-toggle">
                <i class="icon-badge"></i>
                <span class="title">Clientes Celebres</span>
            </a>
        </li>
        <?php 
        }
        ?>

        

        
        <?php
        if (in_array(37, $_SESSION["permisos"]) || in_array(38, $_SESSION["permisos"]) || in_array(111, $_SESSION["permisos"]))
        {
        ?>
        <li class="heading">
            <h3 class="uppercase">LOGÍSTICA</h3>
        </li>
        <li class="nav-item  <?php if($pagina == 'ordenes' || $pagina == 'nueva_orden'){ echo 'active open';}?> ">
            <a href="javascript:;" class="nav-link nav-toggle">
                <i class="icon-basket"></i>
                <span class="title">Pedidos</span>
                <span class="arrow"></span>
            </a>
            <ul class="sub-menu">
                <?php 
                if (in_array(37, $_SESSION["permisos"]))
                {
                ?>
                <li class="nav-item <?php if($pagina == 'ordenes'){ echo 'active open';}?> ">
                    <a href="pedidos.php" class="nav-link ">
                        <span class="title">Ordenes</span>
                    </a>
                </li>
                <?php 
                }

                if (in_array(111, $_SESSION["permisos"]))
                {
                ?>
                <li class="nav-item <?php if($pagina == 'nueva_orden'){ echo 'active open';}?> ">
                    <a href="pedido_add.php" class="nav-link ">
                        <span class="title">Nueva Orden</span>
                    </a>
                </li>
                <?php 
                } ?>
            </ul>
        </li>
        <?php
        }
        ?>

        <?php
        if (in_array(29, $_SESSION["permisos"]) || in_array(30, $_SESSION["permisos"]) || in_array(31, $_SESSION["permisos"]) || in_array(32, $_SESSION["permisos"]))
        {
        ?>
        <li class="heading">
            <h3 class="uppercase">PAGINA WEB</h3>
        </li>
        <li class="nav-item  <?php if($pagina == 'categorias'){ echo 'active open';}?> ">
            <a href="categorias.php" class="nav-link nav-toggle">
                <i class="icon-grid"></i>
                <span class="title">Categorías</span>
            </a>
        </li>
        <li class="nav-item  <?php if($pagina == 'productos'){ echo 'active open';}?> ">
            <a href="productos.php" class="nav-link nav-toggle">
                <i class="icon-puzzle"></i>
                <span class="title">Productos</span>
            </a>
        </li>
        <?php
        }
        ?>


        <li class="heading">
            <h3 class="uppercase">INFORMES</h3>
        </li>
        <li class="nav-item  <?php if($pagina == 'info_efectividad'){ echo 'active open';}?> ">
            <a href="informe_efectividad.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Efectividad de Visitas</span>
            </a>
        </li>
        <li class="nav-item  <?php if($pagina == 'ventas_acumuladas'){ echo 'active open';}?> ">
            <a href="informe_acumulado.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Ventas Acumuladas</span>
            </a>
        </li>
        <?php 
        if (in_array(22, $_SESSION["permisos"]) || in_array(27, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_novisitados'){ echo 'active open';}?> ">
            <a href="informe_novisitados.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Clientes NO Visitados</span>
            </a>
        </li>
        <?php
        }

        if (in_array(128, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_cli_des'){ echo 'active open';}?> ">
            <a href="informe_clientes_desha.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Clientes Deshabilitados</span>
            </a>
        </li>
        <?php
        }

        if (in_array(23, $_SESSION["permisos"]) || in_array(24, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_hijos'){ echo 'active open';}?> ">
            <a href="informe_hijos.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Hijos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(99, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_especialidades'){ echo 'active open';}?> ">
            <a href="informe_especialidades.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Especialidades</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(25, $_SESSION["permisos"]) || in_array(28, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_ventas'){ echo 'active open';}?> ">
            <a href="informe_ventas.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Ventas</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(108, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_cli_celebre'){ echo 'active open';}?> ">
            <a href="informe_clientes_celebres.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Clientes Celebres</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(119, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_cli_nuevos'){ echo 'active open';}?> ">
            <a href="informe_clientes_nuevos.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Clientes Nuevos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(129, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_prod_mes'){ echo 'active open';}?> ">
            <a href="informe_producto_mes.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Productos del Mes</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(130, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item  <?php if($pagina == 'info_cli_descuento'){ echo 'active open';}?> ">
            <a href="informe_clientes_descuentos.php" class="nav-link nav-toggle">
                <i class="icon-notebook"></i>
                <span class="title">Descuento Preferencial</span>
            </a>
        </li>
        <?php 
        }
        ?>



        <li class="heading">
            <h3 class="uppercase">Administrar</h3>
        </li>
        <?php
        if (in_array(63, $_SESSION["permisos"]))
        {
        ?> 
        <li class="nav-item <?php if($pagina == 'usuarios'){ echo 'active open';}?>">
            <a href="usuarios.php" class="nav-link nav-toggle">
                <i class="icon-users"></i>
                <span class="title">Usuarios</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(21, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'datos'){ echo 'active open';}?>">
            <a href="cargar_datos.php" class="nav-link nav-toggle">
                <i class="icon-cloud-upload"></i>
                <span class="title">Cargar Datos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(67, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'roles'){ echo 'active open';}?>">
            <a href="roles.php" class="nav-link nav-toggle">
                <i class="icon-layers"></i>
                <span class="title">Roles-Permisos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(71, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'zonas'){ echo 'active open';}?>">
            <a href="zonas.php" class="nav-link nav-toggle">
                <i class="icon-map"></i>
                <span class="title">Zonas</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(80, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'laboratorios'){ echo 'active open';}?>">
            <a href="laboratorios.php" class="nav-link nav-toggle">
                <i class="icon-chemistry"></i>
                <span class="title">Laboratorios</span>
            </a>
        </li>
        <?php 
        }


        if (in_array(76, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'especialidades'){ echo 'active open';}?>">
            <a href="especialidades.php" class="nav-link nav-toggle">
                <i class="icon-pin"></i>
                <span class="title">Especialidades</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(88, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'obsequios'){ echo 'active open';}?>">
            <a href="obsequios.php" class="nav-link nav-toggle">
                <i class="icon-present"></i>
                <span class="title">Obsequios</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(120, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'cliente_celebre'){ echo 'active open';}?>">
            <a href="tabla_val_cli_cel.php" class="nav-link nav-toggle">
                <i class="icon-like"></i>
                <span class="title">Tabla Clientes Celebres</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(75, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'porcecrecimiento'){ echo 'active open';}?>">
            <a href="porcecrecimiento.php" class="nav-link nav-toggle">
                <i class="icon-bar-chart"></i>
                <span class="title">Tabla % Crecimiento</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(84, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'literaturas'){ echo 'active open';}?>">
            <a href="literaturas.php" class="nav-link nav-toggle">
                <i class="icon-book-open"></i>
                <span class="title">Literaturas</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(92, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'contactos'){ echo 'active open';}?>">
            <a href="contactos.php" class="nav-link nav-toggle">
                <i class="icon-magnet"></i>
                <span class="title">Contactos</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(124, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'banners'){ echo 'active open';}?>">
            <a href="banners.php" class="nav-link nav-toggle">
                <i class="icon-picture"></i>
                <span class="title">Admin. Banners</span>
            </a>
        </li>
        <?php 
        }

        if (in_array(1001, $_SESSION["permisos"]))
        {
        ?>
        <li class="nav-item <?php if($pagina == 'configuracion'){ echo 'active open';}?>">
            <a href="configuracion.php" class="nav-link nav-toggle">
                <i class="icon-settings"></i>
                <span class="title">Configuración</span>
            </a>
        </li>
        <?php 
        }
        //print_r($_SESSION["permisos"]);
        ?>
    </ul>

</div>
