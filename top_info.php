<div class="page-header navbar navbar-fixed-top bg-default bg-font-default">

    <div class="page-header-inner ">

        <div class="page-logo">
            <a href="index.php">
                <img src="assets/layouts/layout/img/logo.png" alt="logo" class="logo-default" /> </a>
            <div class="menu-toggler sidebar-toggler"> </div>
        </div>

        <a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse"> </a>

        <div class="top-menu">
            <ul class="nav navbar-nav pull-right">
                <li class="dropdown dropdown-user">
                    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
                        <img alt="" class="img-circle" src="assets/avatars/img/<?php echo $_SESSION["avatar"];?>" />
                        <span class="username username-hide-on-mobile"> <?php echo $_SESSION["nomusu"].' '.$_SESSION["apeusu"];?> </span>
                        <i class="fa fa-angle-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-default">
                        <li>
                            <a href="#"><i class="icon-user"></i> Mi Perfil </a>
                        </li>
                        <li class="divider"> </li>
                        <li>
                            <a href="#"><i class="icon-lock"></i> Bloquear </a>
                        </li>
                        <li>
                            <a href="cerrar_sesion.php"><i class="icon-key"></i> Cerrar Sesión </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>

    </div>
</div>