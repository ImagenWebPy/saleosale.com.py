<?php
$helper = new Helper();
$carrito = new Carrito();
?>
<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8">
        <!--[if IE]>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <![endif]-->
        <title><?= (isset($this->title)) ? SITE_TITLE . $this->title : SITE_TITLE . 'Compra, Vende, Subasta'; ?></title>
        <!-- Favicons Icon -->
        <link rel="icon" href="<?php echo URL; ?>public/images/ico.png" type="image/x-icon" />
        <link rel="shortcut icon" href="<?php echo URL; ?>public/images/ico.png" type="image/x-icon" />
        <!-- Mobile Specific -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        <!-- CSS Style -->
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/animate.css" type="text/css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/style.css" type="text/css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/revslider.css" type="text/css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/owl.carousel.css" type="text/css">
        <link rel="stylesheet" href="<?php echo URL; ?>public/css/owl.theme.css" type="text/css">
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" type="text/css" rel="stylesheet" >
        <!--<link rel="stylesheet" href="<?php echo URL; ?>public/css/font-awesome.css" type="text/css">-->
        <!-- Google Fonts -->
        <link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,300,700,800,400,600' rel='stylesheet' type='text/css'>
        <?php
        #cargamos los css de las vistas
        if (isset($this->public_css)) {
            foreach ($this->public_css as $public_css) {
                echo '<link rel="stylesheet" href="' . URL . 'public/css/' . $public_css . '" type="text/css">';
            }
        }
        if (isset($this->public_folderHeader)) {
            foreach ($this->public_folderHeader as $public_folderHeader) {
                echo '<link rel="stylesheet" href="' . URL . 'public/' . $public_folderHeader . '" type="text/css">';
            }
        }
        if (isset($this->css)) {
            foreach ($this->css as $css) {
                echo '<link rel="stylesheet" href="' . URL . 'views/' . $css . '" type="text/css">';
            }
        }
        ?>
        <script type="text/javascript" src="<?php echo URL; ?>public/js/jquery.min.js"></script> 
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDntTgrkMZP5jloH-JpzZFODBJxwuevgy0"></script>
        <?php
        if (isset($this->pluggins_js)) {
            foreach ($this->pluggins_js as $pluggins_js) {
                echo '<script async defer src="' . URL . '/public/pluggins/' . $pluggins_js . '"></script>';
            }
        }
        ?>
    </head>
    <body class="cms-index-index">
        <!--GOOGLE ANALYTICS CODE-->
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-78952813-1', 'auto');
            ga('send', 'pageview');

        </script>
        <!-- /GOOGLE ANALYTICS CODE-->
        <div class="page"> 
            <!-- Header -->
            <header class="header-container">
                <div class="header-top">
                    <div class="container">
                        <div class="row"> 
                            <!-- Header Language -->
                            <div class="col-xs-6">
                                <?php if (!empty($_SESSION['cliente'])): ?>
                                    <div class="welcome-msg hidden-xs"> Hola <?php echo $_SESSION['cliente']['nombre']; ?>! </div>
                                <?php else: ?>
                                    <div class="welcome-msg hidden-xs"> Bienvenido! </div>
                                <?php endif; ?>
                            </div>
                            <div class="col-xs-6"> 
                                <?php if (!empty($_SESSION['cliente'])): ?>
                                    <!-- Header Top Links -->
                                    <div class="toplinks">
                                        <div class="links">
                                            <div class="myaccount"><a title="Mi Cuenta" href="<?php echo URL ?>cliente/dashboard/"><span class="hidden-xs">Mi Cuenta</span></a></div>
                                            <div class="wishlist"><a title="Lista de Deseos"  href="<?php echo URL ?>cliente/lista_deseos/"><span class="hidden-xs">Lista de Deseos</span></a></div>
                                            <div class="check"><a title="Comprar" href="<?php echo URL ?>cart/carrito_resumen"><span class="hidden-xs">Carrito</span></a></div>
                                        </div>
                                    </div>
                                    <!-- End Header Top Links --> 
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="header container">
                    <div class="row">
                        <div class="col-lg-2 col-sm-3 col-md-2 col-xs-12"> 
                            <!-- Header Logo --> 
                            <a class="logo" title="Sale o Sale" href="/"><img alt="Sale o Sale" src="<?php echo URL; ?>public/images/logo-min.png" class="img-responsive" style=" width: 85px;"></a> 
                            <!-- End Header Logo --> 
                        </div>
                        <div class="col-lg-6 col-sm-5 col-md-6 col-xs-12"> 
                            <!-- Search-col -->
<!--                            <div class="search-box">
                                <?php //echo $helper->busquedaCategorias(); ?>
                            </div>-->
                            <!-- End Search-col --> 
                        </div>
                        <?php if (empty($_SESSION['cliente'])): ?>
                            <!-- Top Cart -->
                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                <div class="signup"><a title="Login" href="<?php echo URL; ?>login"><span>Regístrate</span></a></div>
                                <span class="or"> O</span>
                                <div class="login"><a title="Login" href="<?php echo URL; ?>login"><span>Inicia Sesión</span></a></div>
                            </div>
                            <!-- End Top Cart --> 
                        <?php else: ?>
                            <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
                                <div class="login"><a title="Cerrar Sesión" href="<?php echo URL; ?>login/cerrar"><span>Cerrar Sesión</span></a></div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </header>
            <!-- end header --> 
            <!-- Navbar -->
            <nav>
                <div class="container">
                    <div class="nav-inner"> 
                        <!-- mobile-menu -->
                        <div class="hidden-desktop" id="mobile-menu">
                            <?php $helper->menuResponsive(0, 1); ?>
                        </div>
                        <!--End mobile-menu --> 
                        <a class="logo-small" title="Sale o Sale" href="/"><img alt="Sale o Sale" src="<?php echo URL; ?>public/images/logo.png" class="img-responsive" style=" width: 120px;"></a>
                            <?php
                            $helper->mostrarMenu(0, 1);
                            echo $helper->showCarrito();
                            ?>
                    </div>
                </div>
            </nav>
            <!-- end nav --> 
            <?php echo $helper->headerBar($helper->getPage()); ?>

