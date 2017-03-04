<?php
$helper = new Helper();
$nivel = $_SESSION['admin']['nivel'];
$pagina = $helper->getPage();
$metodo = (!empty($pagina[1])) ? $pagina[1] : '';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Sale o Sale | Administrador</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="<?php echo URL; ?>public/admin/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="<?php echo URL; ?>public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo URL; ?>public/admin/dist/css/AdminLTE.min.css">
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="<?php echo URL; ?>public/admin/dist/css/skins/_all-skins.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
        <?php if ($metodo == 'producto'): ?>
            <link rel="stylesheet" href="<?php echo URL; ?>public/admin/css/progress_style.css">
        <?php endif; ?>
        <?php
        #cargamos los css de las vistas
        if (isset($this->css)) {
            foreach ($this->css as $css) {
                echo '<link rel="stylesheet" href="' . URL . 'views/' . $css . '" type="text/css">';
            }
        }
        ?>
        <!-- jQuery 2.1.4 -->
        <script src="<?php echo URL; ?>public/admin/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <?php if ($metodo == 'producto'): ?>
            <script src="<?php echo URL; ?>public/admin/js/jquery.form.min.js"></script>
            <script src="<?php echo URL; ?>public/admin/js/upload_progress.js"></script>
        <?php endif; ?>
    </head>
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">

            <header class="main-header">

                <!-- Logo -->
                <a href="index2.html" class="logo">
                    <!-- mini logo for sidebar mini 50x50 pixels -->
                    <span class="logo-mini"><img src="<?php echo IMAGES; ?>logo-min-white.png" class="img-responsive" /></span>
                    <!-- logo for regular state and mobile devices -->
                    <span class="logo-lg"><img src="<?php echo IMAGES; ?>logo-white.png" class="img-responsive" /></span>
                </a>

                <!-- Header Navbar: style can be found in header.less -->
                <nav class="navbar navbar-static-top" role="navigation">
                    <!-- Sidebar toggle button-->
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                        <span class="sr-only">Toggle navigation</span>
                    </a>
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    <span class="hidden-xs"><?php echo utf8_encode($_SESSION['admin']['nombre']); ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <p>
                                            <?php echo utf8_encode($_SESSION['admin']['nombre']); ?> - <?php echo utf8_encode($_SESSION['admin']['nivel']); ?>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?= URL; ?>admin/cambiar_contrasena" class="btn btn-default btn-flat">Cambiar Contraseña</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo URL; ?>admin/salir/" class="btn btn-default btn-flat">Salir</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </nav>
            </header>
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="main-sidebar">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class="header">Navegación Principal</li>
                        <li><a href="<?php echo URL; ?>admin/index/"><i class="fa fa-dashboard"></i> <span>Dashboard</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/productos/"><i class="fa fa-barcode" aria-hidden="true"></i> <span>Productos</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/productos_destacados/"><i class="fa fa-star" aria-hidden="true"></i> <span>Productos Destacados</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/clientes/"><i class="fa fa-user"></i> <span>Clientes</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/pedidos/"><i class="fa fa-list-alt"></i> <span>Pedidos</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/categorias/"><i class="fa fa-th-list"></i> <span>Categorías</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/resenas/"><i class="fa fa-pencil-square-o"></i> <span>Reseñas</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/subastas/"><i class="fa fa-gavel"></i> <span>Subastas</span></a></li>
                        <li><a href="<?php echo URL; ?>admin/solicitudes/"><i class="fa fa-credit-card"></i> <span>Solicitudes</span></a></li>
                        <?php if ($nivel == 'Administrador'): ?>
                            <li><a href="<?php echo URL; ?>admin/costo_envio/"><i class="fa fa-money"></i> <span>Gastos de envío</span></a></li>
                        <?php endif; ?>
                        <li class="treeview"><a href="#"><i class="fa fa-picture-o" aria-hidden="true"></i> <span>Banners</span><i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <li><a href="<?php echo URL; ?>admin/slider/"><i class="fa fa-circle-o"></i> Slider</li>
                                <li><a href="<?php echo URL; ?>admin/lateral_inicio/"><i class="fa fa-circle-o"></i> Lateral Inicio</li>
                                <li><a href="<?php echo URL; ?>admin/inferior_inicio/"><i class="fa fa-circle-o"></i> Inferior Inicio</li>
                                <li><a href="<?php echo URL; ?>admin/banner_categoria/"><i class="fa fa-circle-o"></i> Banner Categorías</li>
                                <li><a href="<?php echo URL; ?>admin/banner_menu/"><i class="fa fa-circle-o"></i> Banner Menú</li>
                            </ul>
                        </li>
                        <?php if ($nivel == 'Administrador'): ?>
                            <li class="header">Usuarios</li>
                            <li><a href="<?php echo URL; ?>admin/usuarios"><i class="fa fa-users"></i> <span>Usuarios</span></a></li>
                            <li><a href="<?php echo URL; ?>admin/emails"><i class="fa fa-envelope"></i> <span>E-mails</span></a></li>
                            <?php endif; ?>
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>