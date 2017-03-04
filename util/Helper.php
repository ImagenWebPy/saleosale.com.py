<?php

require 'libs/Database.php';

/**
 * 
 */
class Helper {

    function __construct() {
        $this->db = new Database(DB_TYPE, DB_HOST, DB_NAME, DB_USER, DB_PASS);
    }

    /**
     * Funcion para mostrar el menu del sitio
     * @param int $padre
     * @param type $nivel
     */
    public function mostrarMenu($padre, $nivel) {
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id= :padre_id and c.estado = :estado ORDER BY c.orden ASC LIMIT 6", array(':padre_id' => $padre, ':estado' => 1));
        echo '<ul id="nav" class="hidden-xs">';
        foreach ($result as $row) {
            if ($row['Count'] > 0) {
                echo "<li class='level0 nav-7 level-top'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
                $this->subMenu($row['id'], $nivel + 1);
                echo "</li>";
            } elseif ($row['Count'] == 0) {
                if ($row['id'] == 71) {
                    echo "<li class='level0 nav-7 level-top parent'><a href='/'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                } elseif ($row['id'] == 85) {
                    echo "<li class='level0 nav-7 level-top parent'><a href='" . URL . $row['url_rewrite'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                } else {
                    echo "<li class='level0 nav-7 level-top parent'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                }
            } 
                else;
        }
        if (!empty($this->menuPlus(0, 1))) {
            echo '<li class="level0 drop-menu"> <a href="#"> <span>+</span></a>';
            $this->menuPlus(0, 1);
            echo '</li>';
        }
        echo "</ul>";
    }

    public function menuResponsive($padre, $nivel) {
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id= :padre_id ORDER BY c.orden ASC", array(':padre_id' => $padre));
        echo '<ul class="navmenu">';
        echo '<li>';
        echo '<div class="menutop">';
        echo '<div class="toggle"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span></div>';
        echo '<h2>Menu</h2>';
        echo '</div>';
        echo '<ul style="display:none;" class="submenu">';
        foreach ($result as $row) {
            if ($row['Count'] > 0) {
                echo "<li class='level0 nav-1 level-top parent'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "' class='level-top'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
                //$this->subMenuResponsive($row['id'], $nivel + 1);
                echo "</li>";
            } elseif ($row['Count'] == 0) {
                if ($row['id'] == 71) {
                    echo "<li class='level0 nav-1 level-top first parent'> <a href='/' class='level-top'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                } else {
                    echo "<li class='level0 nav-1 level-top first parent'> <a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "' class='level-top'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                }
            } 
                else;
        }
        echo "</ul>";
        echo '</li>';
        echo '</ul>';
    }

    private function subMenuResponsive($padre, $nivel) {
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id = :padre_id ", array(':padre_id' => $padre));
        echo '<ul class="level0">';
        foreach ($result as $row) {
            if ($row['Count'] > 0) {
                echo "<li class='level1 nav-6-1 parent item'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
//$new_sub = new Helper();
                echo "</li>";
            } elseif ($row['Count'] == 0) {
                echo "<li class='level1 nav-6-1 parent item'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</a></li>";
            } 
                else;
        }
        echo '</ul>';
    }

    private function subMenu($padre, $nivel) {
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id = :padre_id and c.estado = :estado", array(':padre_id' => $padre, ':estado' => 1));
        echo '<div class="level0-wrapper dropdown-6col">';
        if (!empty($this->getMenuBanner($padre)))
            echo $this->getMenuBanner($padre);
        echo '<div class="level0-wrapper2">';
        echo '<div class="nav-block nav-block-center">';
        echo '<ul class="level0">';
        foreach ($result as $row) {
            if ($row['Count'] > 0) {
                echo "<li class='level1 nav-6-1 parent item'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
//$new_sub = new Helper();
                echo "</li>";
            } elseif ($row['Count'] == 0) {
                echo "<li class='level1 nav-6-1 parent item'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</a></li>";
            } 
                else;
        }
        echo "</ul>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }

    private function menuPlus($padre, $nivel) {
        $new_sub = new Helper();
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id= :padreId and c.estado = 1 AND c.orden > 6 ORDER BY c.orden ASC", array(':padreId' => $padre));
        if (!empty($result)) {
            echo '<ul class="level1">';
            foreach ($result as $row) {
                if ($row['Count'] > 0) {
                    echo "<li class='level1 first parent'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
                    $new_sub->subMenuPlus($row['id'], $nivel + 1);
                    echo "</li>";
                } elseif ($row['Count'] == 0) {
                    echo "<li class='level1'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a></li>";
                } 
                    else;
            }
            echo "</ul>";
        }
    }

    public function subMenuPlus($padre, $nivel) {
        $result = $this->db->select("SELECT c.id, c.descripcion, c.url_rewrite, Deriv1.Count FROM categoria c LEFT OUTER JOIN (SELECT padre_id, COUNT(*) AS Count FROM categoria GROUP BY padre_id) Deriv1 ON c.id = Deriv1.padre_id WHERE c.padre_id = :padre_id ", array(':padre_id' => $padre));
        echo '<ul class="level2">';
        foreach ($result as $row) {
            echo "<li class='level2 nav-2-1-1'><a href='" . URL . "producto/categoria/" . $row['url_rewrite'] . "-" . $row['id'] . "'><span>" . utf8_encode($row['descripcion']) . "</span></a>";
        }
        echo '</ul>';
    }

    public function headerBar($url) {
        $cant = count($url);
        $seccion = $url;
        $bar = "";
        if ($cant == 1) {
            if (empty($seccion[0])) {
                $bar .= '<!-- header service -->
            <div class="header-service">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-xs-12">
                            <div class="content">
                                <div class="icon-truck">&nbsp;</div>
                                <span>Envíos a todo el País</span></div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-xs-12">
                            <div class="content">
                                <div class="icon-support">&nbsp;</div>
                                <span>Servicio de Atención al Cliente</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end header service --> ';
            } else {
                $bar .='<div class="breadcrumbs">
                <div class="container">
                  <div class="row">
                    <ul>
                      <li class="home"> <a title="Ir al Inicio" href="/">Inicio</a><span>&mdash;›</span></li>
                      <li class="category13"><strong>' . $seccion[0] . '</strong></li>
                    </ul>
                  </div>
                </div>
              </div>';
            }
        } elseif ($cant > 1) {
            switch ($cant) {
                case 2:
                    $bar .='<div class="breadcrumbs">
                <div class="container">
                  <div class="row">
                    <ul>
                      <li class="home"> <a title="Ir al Inicio" href="/">Inicio</a><span>&mdash;›</span></li>
                      <li class=""><a title="Ir a ' . $seccion[0] . '" href="' . URL . $seccion[0] . '">' . $seccion[0] . '</a><span>&mdash;›</span></li>
                      <li class="category13"><strong>' . $seccion[1] . '</strong></li>
                    </ul>
                  </div>
                </div>
              </div>';
                    break;
                case 3:
                    $bar .='<div class="breadcrumbs">
                <div class="container">
                  <div class="row">
                    <ul>
                      <li class="home"> <a title="Ir al Inicio" href="/">Inicio</a><span>&mdash;›</span></li>
                      <li class=""><a title="Ir a ' . $seccion[0] . '" href="' . URL . $seccion[0] . '">' . $seccion[0] . '</a><span>&mdash;›</span></li>
                      <li class=""><a title="Ir a ' . $seccion[1] . '" href="' . URL . $seccion[1] . '">' . $seccion[1] . '</a><span>&mdash;›</span></li>
                      <li class="category13"><strong>' . $seccion[2] . '</strong></li>
                    </ul>
                  </div>
                </div>
              </div>';
                    break;
            }
        }
        return $bar;
    }

    public function getPage() {
        $url = isset($_GET['url']) ? $_GET['url'] : null;
        $url = rtrim($url, '/');
        $url = filter_var($url, FILTER_SANITIZE_URL);
        $pagina = (explode('/', $url));
        return $pagina;
    }

    /**
     * Funcion para mostrar los banners del sitio
     * @param int $idposicion
     * @param string $orden (ASC, DESC, RAND)
     * @param int $idcategoria default NULL
     */
    public function printBanner($idposicion, $orden = 'ASC', $idcategoria = NULL) {
        $banner = array();
        if ($idcategoria == NULL) {
            $result = $this->db->select("SELECT * FROM banner WHERE id_posicion = :idPosicion AND estado = :estado ORDER BY orden $orden", array(':idPosicion' => $idposicion, ':estado' => 1));
            switch ($idposicion) {
                case 1;
                    foreach ($result as $item) {
                        $bannerItem = "<li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='" . IMAGES . $item['imagen'] . "'> <img src='" . IMAGES . $item['imagen'] . "' data-bgposition='left top' data-bgfit='cover' data-bgrepeat='no-repeat' alt='banner'/>";
                        if (!empty($item['texto_1']))
                            $bannerItem .= "<div class='tp-caption ExtraLargeTitle sft  tp-resizeme ' data-x='40'  data-y='30'  data-endspeed='500'  data-speed='500' data-start='1100' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:2; white-space:nowrap;'>" . utf8_encode($item['texto_1']) . "</div>";
                        if (!empty($item['texto_2']))
                            $bannerItem .= "<div class='tp-caption LargeTitle sfl  tp-resizeme ' data-x='40'  data-y='75'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3; white-space:nowrap;'>" . utf8_encode($item['texto_2']) . "</div>";
                        if ((!empty($item['texto_enlace'])) && (!empty($item['enlace'])))
                            $bannerItem .= "<div class='tp-caption sfb  tp-resizeme ' data-x='40'  data-y='360'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a href='" . utf8_encode($item['enlace']) . "' class='buy-btn'>" . utf8_encode($item['texto_enlace']) . "</a></div>";
                        if (!empty($item['texto_3']))
                            $bannerItem .= "<div class='tp-caption Title sft  tp-resizeme ' data-x='40'  data-y='150'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'>Ver todos los cupones<br></div>";
                        $bannerItem .= "</li>";
                        array_push($banner, $bannerItem);
                    }
                    break;
                case 2:
                    foreach ($result as $item) {
                        $bannerItem = '<div class="RHS-banner">
                              <div class="add"><a href="' . $item['enlace'] . '"><img alt="banner-img" src="' . IMAGES . $item['imagen'] . '"></a></div>
                                </div>';
                        array_push($banner, $bannerItem);
                    }
                    break;
                case 3:
                    foreach ($result as $item) {
                        $bannerItem = '<div class="col-lg-6 col-xs-12 col-sm-6 wow bounceInUp animated"><a href="' . $item['enlace'] . '"><img alt="' . $item['imagen'] . '" src="' . IMAGES . $item['imagen'] . '" class="img-responsive"></a></div>';
                        array_push($banner, $bannerItem);
                    }
                    break;
            }
        }
        return $banner;
    }

    /**
     * Funcion para mostrar los productos en el index por seccion
     * @param int $idSeccion
     * @param string $orden
     */
    public function productoDestacado($idSeccion, $orden = 'ASC') {
        $helper = new Helper();
        $result = $this->db->select("SELECT id_producto FROM producto_seleccionado WHERE id_seccion_producto = :idSeccion ORDER BY orden $orden", array(':idSeccion' => $idSeccion));
        $productoDestacado = array();
        $item = '';
#recorremos la tabla de productos destacados para obtener los id de los productos
        foreach ($result as $res) {
            $producto = $this->db->select("select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.id = :id_producto", array(':id_producto' => $res['id_producto']));
#recorremos la tabla producto
            foreach ($producto as $product) {
                $imagen = explode('|', $product['imagen']);
#el primer elemento siempre va a ser la imagen principal
                $imagen = $imagen[0];
//guaranies
                if ($product['id_moneda'] == 1) {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $product['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($product['precio'], 0, ',', '.');
                    if ($product['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($product['precio_oferta'], 0, ',', '.');
                    }
//dolares
                } else {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $product['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($product['precio'], 2, ',', '.');
                    if ($product['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($product['precio_oferta'], 2, ',', '.');
                    }
                }
                $item .= '<!-- Item -->
                        <div class="item">
                            <div class="col-item">';
                if ($product['precio_oferta'] != 0)
                    $item .= '<div class="sale-label sale-top-right">Oferta</div>';
                if ($product['nuevo'] == 1)
                    $item .= '<div class="new-label new-top-right">Nuevo</div>';
                $item .= '<div class="product-image-area"> <a class="product-image" title="' . utf8_encode($product['nombre']) . '" href="' . $helper->urlProducto($product['id']) . '"> <img src="' . IMAGE_PRODUCT . $imagen . '" class="img-responsive" alt="' . utf8_encode($product['nombre']) . '" /> </a></div>';
                if (!empty($_SESSION['cliente']['id'])) {
                    $item .= '<div class="actions-links"><span class="add-to-links"> <a title="Agregar a mi lista de Deseos" class="link-wishlist" href="' . URL . 'cliente/agregar_lista_deseo/' . $_SESSION['cliente']['id'] . '/' . $product['id'] . '"><span>Agregar a mi lista de Deseos</span></a></span> </div>';
                }
                $item .= '<div class="info">
                                    <div class="info-inner">
                                        <div class="item-title"> <a title=" " href="' . $helper->urlProducto($product['id']) . '"> ' . utf8_encode($product['marca']) . ' - ' . utf8_encode($product['nombre']) . '</a> </div>
                                        <!--item-title-->
                                        <div class="item-content">
                                           <div class="ratings">
                                                ' . $this->calcularValoracion($product['id'], 1) . '
                                            </div>
                                           <div class="price-box">';
                if ($product['precio_oferta'] == 0) {
                    $item .='<div class = "price-box"> <span class = "regular-price"> <span class = "price">' . $precio . '</span> </span> </div>';
                } else {
                    $item .='<p class = "special-price"> <span class = "price"> ' . $precio_oferta . ' </span> </p>';
                    $item .='<p class = "old-price"> <span class = "price-sep">-</span> <span class = "price"> ' . $precio . ' </span> </p >';
                }
                $item .= '</div>
                                        </div>
                                        <!--item-content--> 
                                    </div>
                                    <!--info-inner-->
                                    <div class="actions">
                                        <a href="' . URL . 'cart/agregar/' . $product['id'] . '" type="button" title="Agregar al Carrito" class="button btn-cart"><span>Agregar al Carrito</span></a>
                                    </div>
                                    <!--actions-->
                              <div class="clearfix"> </div>
                            </div>
                        </div>
                      </div>';
            }
        }
        array_push($productoDestacado, $item);
        return $productoDestacado;
    }

    /**
     * Funcion para mostrar productos destacados por categoria
     * @param int $idSeccion
     * @param int $limit default (3)
     * @param string $orden Default (ASC)
     */
    public function mostrarCatIndex($idSeccion, $limit = 3, $orden = 'ASC') {
        $helper = new Helper();
        $destacado = array();
        $item = '';
        $result = $this->db->select("SELECT id_producto FROM producto_seleccionado WHERE id_seccion_producto = :idSeccion ORDER BY orden $orden", array(':idSeccion' => $idSeccion));
#recorremos la tabla de productos destacados para obtener los id de los productos
        foreach ($result as $desc) {
            $producto = $this->db->select("select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.id = :id_producto", array(':id_producto' => $desc['id_producto']));
            $imagen = explode('|', $producto[0]['imagen']);
            $imagen = $imagen[0];
//guaranies
            if ($producto[0]['id_moneda'] == 1) {
                $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto[0]['id_moneda']));
                $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio'], 0, ',', '.');
                if ($producto[0]['precio_oferta'] != 0) {
                    $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio_oferta'], 0, ',', '.');
                }
//dolares
            } else {
                $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto[0]['id_moneda']));
                $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio'], 2, ',', '.');
                if ($producto[0]['precio_oferta'] != 0) {
                    $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio_oferta'], 2, ',', '.');
                }
            }
#armamos el producto
            $item .='<div class="item">
                            <div class="item-area">
                                <div class="product-image-area"> <a href="' . $helper->urlProducto($producto[0]['id']) . '" class="product-image"> <img src="' . IMAGE_PRODUCT . $imagen . '" alt=""> </a> </div>
                                <div class="details-area">
                                    <h2 class="product-name"><a href="' . $helper->urlProducto($producto[0]['id']) . '">' . $producto[0]['marca'] . ' - ' . $producto[0]['nombre'] . '</a></h2>
                                    <div class="ratings">
                                        <div class="rating-box">
                                            ' . $helper->calcularValoracion($producto[0]['id'], 1) . '
                                        </div>
                                    </div>';
            if ($producto[0]['precio_oferta'] == 0) {
                $item .='<div class = "price-box"> <span class = "regular-price"> <span class = "price">' . $precio . '</span> </span> </div>';
            } else {
                $item .='<p class = "special-price"> <span class = "price"> ' . $precio_oferta . ' </span> </p>';
                $item .='<p class = "old-price"> <span class = "price-sep">-</span> <span class = "price"> ' . $precio . ' </span> </p >';
            }
            $item .='</div>
                </div>
                </div>';
        }
        array_push($destacado, $item);
        return $destacado;
    }

    /**
     * Funcion para limpiar un string
     * @param strig $String a quitar caracteres especiales y espacios
     * @return string formateado
     */
    public function cleanUrl($String) {
        $String = str_replace(array('á', 'à', 'â', 'ã', 'ª', 'ä'), "a", $String);
        $String = str_replace(array('Á', 'À', 'Â', 'Ã', 'Ä'), "A", $String);
        $String = str_replace(array('Í', 'Ì', 'Î', 'Ï'), "I", $String);
        $String = str_replace(array('í', 'ì', 'î', 'ï'), "i", $String);
        $String = str_replace(array('é', 'è', 'ê', 'ë'), "e", $String);
        $String = str_replace(array('É', 'È', 'Ê', 'Ë'), "E", $String);
        $String = str_replace(array('ó', 'ò', 'ô', 'õ', 'ö', 'º'), "o", $String);
        $String = str_replace(array('Ó', 'Ò', 'Ô', 'Õ', 'Ö'), "O", $String);
        $String = str_replace(array('ú', 'ù', 'û', 'ü'), "u", $String);
        $String = str_replace(array('Ú', 'Ù', 'Û', 'Ü'), "U", $String);
        $String = str_replace(array('[', '^', '´', '`', '¨', '~', ']'), "", $String);
        $String = str_replace("ç", "c", $String);
        $String = str_replace("Ç", "C", $String);
        $String = str_replace("ñ", "n", $String);
        $String = str_replace("Ñ", "N", $String);
        $String = str_replace("Ý", "Y", $String);
        $String = str_replace("ý", "y", $String);

        $String = str_replace("'", "", $String);
        $String = str_replace(".", "_", $String);
        $String = str_replace(" ", "_", $String);
        $String = str_replace("/", "_", $String);

        $String = str_replace("&aacute;", "a", $String);
        $String = str_replace("&Aacute;", "A", $String);
        $String = str_replace("&eacute;", "e", $String);
        $String = str_replace("&Eacute;", "E", $String);
        $String = str_replace("&iacute;", "i", $String);
        $String = str_replace("&Iacute;", "I", $String);
        $String = str_replace("&oacute;", "o", $String);
        $String = str_replace("&Oacute;", "O", $String);
        $String = str_replace("&uacute;", "u", $String);
        $String = str_replace("&Uacute;", "U", $String);
        return $String;
    }

    /**
     * Funcion para formar una url amigable para el producto
     * @param int $idProducto
     * @return string con la url amigable
     */
    public function urlProducto($idProducto) {
        $helper = new Helper();
//datos del producto
        $producto = $this->db->select("SELECT id, nombre, id_marca FROM producto WHERE id = :id", array(':id' => $idProducto));
//marca del producto
        $marca = $this->db->select("SELECT descripcion FROM marca WHERE id = :id", array(':id' => $producto[0]['id_marca']));

        $url_producto = strtolower(URL_PRODUCTO . $marca[0]['descripcion'] . '-' . $helper->cleanUrl($producto[0]['nombre']) . '-' . $producto[0]['id']);

        return $url_producto;
    }

    /**
     * Arma el nombre de producto con su marca
     * @param int $idProducto
     * @return string nombre del producto con su marca
     */
    public function getProductoNombre($idProducto) {
        $producto = $this->db->select("Select nombre, id_marca from producto WHERE id = :id", array(':id' => $idProducto));
        $marca = $this->db->select("Select descripcion from marca WHERE id = :id", array(':id' => $producto[0]['id_marca']));
        $nombre = utf8_encode($marca[0]['descripcion']) . ' - ' . utf8_encode($producto[0]['nombre']);
        return $nombre;
    }

    /**
     * Funcion para obtener los precios formateados
     * @param type $idProducto
     * @return array de precios(precio normal y precio oferta)
     */
    public function getProductoPrecio($idProducto) {
        $precios = array();
//datos del producto
        $producto = $this->db->select("SELECT id_moneda, precio, precio_oferta FROM producto WHERE id = :id", array(':id' => $idProducto));
//obtenemos la moneda del producto
        $moneda = $this->db->select("SELECT simbolo from moneda WHERE id = :id", array(':id' => $producto[0]['id_moneda']));
//inicializamos las variables
        $precio = 0;
        $precio_oferta = 0;
//guaranies
        if ($producto[0]['id_moneda'] == 1) {
            $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio'], 0, ',', '.');
            if ($producto[0]['precio_oferta'] != 0) {
                $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio_oferta'], 0, ',', '.');
            }
//dolares
        } else {
            $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio'], 2, ',', '.');
            if ($producto[0]['precio_oferta'] != 0) {
                $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto[0]['precio_oferta'], 2, ',', '.');
            }
        }
        $precios = array('precio' => $precio, 'precio_oferta' => $precio_oferta);
        return $precios;
    }

    public function busquedaCategorias() {
        $padre = 0;
        $sqlCategorias = $this->db->select("SELECT * from categoria where padre_id = :padre_id", array(':padre_id' => $padre));
        $categorias = '<form action="' . URL . 'producto/busqueda/1/" method="GET" id="search_mini_form" name="categorias">
                                    <!--<select name="category_id" class="cate-dropdown hidden-xs">
                                        <option value="0">Todas las Categorias</option>';
        /* foreach ($sqlCategorias as $categoria) {
          $categorias .='<option value="' . $categoria['id'] . '">' . utf8_encode($categoria['descripcion']) . '</option>';
          } */
        $categorias .='   </select>-->
                                    <input type="text" placeholder="Ingrese la promoción a Buscar..." value="" maxlength="70" class="" name="search" id="search">
                                    <button id="submit-button" class="search-btn-bg"><span>Buscar</span></button>
                                </form>';
        return $categorias;
    }

    /**
     * Funcion para limpiar un input antes de enviarlo por post
     * @param type $data
     * @return type
     */
    public function cleanInput($data) {
        $data = trim($data);
        $data = str_replace("'", "\'", $data);
        $data = htmlspecialchars($data);
        $data = stripslashes($data);

        return $data;
    }

    /**
     * Funcion para mostrar mensajes de alerta
     * @param string $type (success - info - warning - error)
     * @param string $message (mensaje a mostrar)
     * @return string
     */
    public function messageAlert($type, $message) {
        $alert = "";
        switch ($type) {
            case 'success':
                $alert .= '<div class="alert alert-success" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'info':
                $alert .= '<div class="alert alert-info" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'warning':
                $alert .= '<div class="alert alert-warning" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
            case 'error':
                $alert .= '<div class="alert alert-danger" role="alert">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            ' . $message . '
                        </div>';
                break;
        }
        return $alert;
    }

    /**
     * 
     * @return string url anterior del sitio
     */
    public function getUrlAnterior() {
        $url = (!empty($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : '';
        return $url;
    }

    /**
     * Funcion que muestra el carrito
     * @return string
     */
    public function showCarrito() {
        $helper = new Helper();
        $carrito = new Carrito();
        $datosCarrito = '<div class="top-cart-contain">
                            <div class="mini-cart">
                                <div data-toggle="dropdown" data-hover="dropdown" class="basket dropdown-toggle"> <a href="#">
                                        <div class="cart-box"><span id="cart-total"><strong>' . $carrito->articulos_total() . '</strong> cupones </span></div>
                                    </a></div>
                                <div>
                                    <div class="top-cart-content arrow_box">
                                        <div class="block-subtitle">Agregados Recientemente(s)</div>
                                        <ul id="cart-sidebar" class="mini-products-list">';
        $items = $carrito->get_content();
#alteramos el orden del array para mostrar siempre primiro el ultimo elemento que se agrega
        if (!empty($items))
            $items = array_reverse($items);
        $i = 0;
        if (!empty($items)) {
            foreach ($items as $item) {
#mostramos siempre los dos ultimos
                if ($i <= 2) {
                    $datosCarrito .= ' <li class = "item even"> <a class = "product-image" href = "' . $helper->urlProducto($item['id']) . '"><img src = "' . IMAGE_PRODUCT . $item['imagen'] . '" width = "80"></a>
        <div class = "detail-item">
        <div class = "product-details"> <a href = "' . URL . 'cart/eliminar/' . $item['unique_id'] . '" title = "Remover este producto" onClick = "" class = "glyphicon glyphicon-remove">&nbsp;
        </a>
        <p class = "product-name"> <a href = "' . $helper->urlProducto($item['id']) . '" >' . $item['nombre'] . '</a> </p>
        </div>
        <div class = "product-details-bottom"> <span class = "price">' . $this->getPrecioCarrito($item['precio'], $item['cantidad']) . '</span> <span class = "title-desc">Cant:</span> <strong>' . $item['cantidad'] . '</strong> </div>
        </div>
        </li>';
                }
                $i++;
            }
        } else {
            $datosCarrito .= '<li>Su carrito se encuentra vacío</li>';
        }
        $datosCarrito .= '</ul>
                                        <div class="actions">
                                            <a  href= "' . URL . 'cart/carrito_paso2/" class="btn-checkout" type="button"><span>Comprar</span></A>
                                            <a href="' . URL . 'cart/carrito_resumen/" class="view-cart" type="button"><span>Ver Carrito</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';
        return $datosCarrito;
    }

    /**
     * 
     * @param float $valor
     * @param int $cantidad
     * @return string con el precio formateado
     */
    public function getPrecioCarrito($valor, $cantidad = 1) {
        $precio = "";
#obtenemos el ISO del guaraní
        $moneda = $this->db->select("SELECT simbolo from moneda WHERE id = :id", array(':id' => 1));
        $price = (float) $valor * $cantidad;
        $precio = $moneda[0]['simbolo'] . ' ' . number_format($price, 0, ',', '.');
        return $precio;
    }

    /**
     * Funcion para obtener el precio total del item en el carrito
     * @param float $valor
     * @param int $cantidad
     * @return string formateado con el precio total del item
     */
    public function getPrecioTotalItem($valor, $cantidad = 1) {
        $precio = "";
#obtenemos el ISO del guaraní
        $moneda = $this->db->select("SELECT simbolo from moneda WHERE id = :id", array(':id' => 1));
        $price = (float) $valor * $cantidad;
        $precio = $moneda[0]['simbolo'] . ' ' . number_format($price, 0, ',', '.');
        return $precio;
    }

    /**
     * Funcion que retorna el precio unitario del producto
     * @param int $idProducto
     * @return float el precio unitario
     */
    public function getUnitPrice($idProducto, $cantidad = 1) {
        $sth = $this->db->select("SELECT precio, precio_oferta, id_moneda from producto where id = :id", array(':id' => $idProducto));
        $unit_price = $sth[0]['precio'];
        $unit_sale = $sth[0]['precio_oferta'];
        $unit_symbol = $sth[0]['id_moneda'];

        /**
         * Si el producto esta en dolares lo combertimos a guaranies
         */
        if ($unit_symbol == 2) {
            $cambio = $this->db->select("select cotizacion from cotizacion_moneda where fecha_cotizacion = (SELECT MAX(fecha_cotizacion) FROM cotizacion_moneda)");
            /**
             * convertimos la moneda a guaranies
             * tipo de cambio del dia por el precio
             */
#verificamos que el precio oferta no este vacio
            if ($unit_sale == 0) {
                $precio = (float) $unit_price * (float) $cambio[0]['cotizacion'];
            } else {
                $precio = (float) $unit_sale * (float) $cambio[0]['cotizacion'];
            }
#verificamos que el precio oferta no este vacio
            if ($unit_sale == 0) {
                $precio = (float) $unit_price * (float) $cambio[0]['cotizacion'];
            } else {
                $precio = (float) $unit_sale * (float) $cambio[0]['cotizacion'];
            }
//$precio = $cart->convertirMoneda($precio);
        } else {
#precio en guaranies, no hacemos nada
            $precio = $unit_price;
        }

        $precioUnidad = $this->getPrecioCarrito($precio);
        return $precioUnidad;
    }

    /**
     * Funcion que retorna la url actual en forma de array
     * @return array url
     */
    public function getUrl() {
        $url = $_GET['url'];
        $url = explode('/', $url);
        return $url;
    }

    /**
     * Funcion que envia los emails del sitio
     * @param string $destinatario
     * @param string $asunto
     * @param string $seccion 
     * @param string $mensaje defualt ''
     * @param string $destinatarioNombre
     */
    public function sendMail($destinatario, $asunto, $seccion, $mensaje = '', $destinatarioNombre = '') {
        date_default_timezone_set('America/Asuncion');
        #verificamos que la variable mensaje este seteada
        if (!empty($mensaje))
            $message = $mensaje;
        /*
         * CONFIGURACION ENVIO MAIL PRODUCCION
         */
        $emailFrom = MAILFROM;
        $nameFrom = NAMEMAIL;
        //para el envío en formato HTML 
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";

        //dirección del remitente 
        $headers .= "From: $nameFrom <$emailFrom>\r\n";

        //dirección de respuesta, si queremos que sea distinta que la del remitente 
        $headers .= "Reply-To: $emailFrom\r\n";

        //ruta del mensaje desde origen a destino 
        //$headers .= "Return-path: $destinatario\r\n";
        //direcciones que recibián copia 
        //$headers .= "Cc: maria@desarrolloweb.com\r\n";
        //direcciones que recibirán copia oculta 
        //$headers .= "Bcc: pepe@pepe.com,juan@juan.com\r\n";

        switch ($seccion) {
            case 'compra[finalizada]':
                //Definimos el tema del email
                $id_forma_pago = $_SESSION['checkout']['forma_pago'];
                $formaPago = $this->db->select("select descripcion from forma_pago where id = " . $id_forma_pago);
                switch ($id_forma_pago) {
                    case 1 :
                        #Efectivo (Pago contra Entrega)
                        $mensaje = array(
                            'forma_pago' => $formaPago[0]['descripcion'],
                            'mensaje' => 'Una vez recibido tu pedido, deberás abonar la totalidad del mismo al repartidor.'
                        );
                        break;
                    case 2 :
                        #Tarjeta de Crédito
                        $mensaje = array(
                            'forma_pago' => $formaPago[0]['descripcion'],
                            'mensaje' => 'Una vez recibido tu pedido, deberás abonar la totalidad del mismo al repartidor con tu tarjeta de crédito. Para ello el repartidor llevara un post consigo para que puedas realizar el pago.'
                        );
                        break;
                    case 3 :
                        #Tigo Money
                        $mensaje = array(
                            'forma_pago' => $formaPago[0]['descripcion'],
                            'mensaje' => 'Para que tu pedido sea enviado, tienes que girar la totalidad del mismo al siguiente numero <strong>0986 656 300</strong>. Una vez confirmado el pago, tu pedido será enviado.'
                        );
                        break;
                    case 4 :
                        #Billetera Personal
                        $mensaje = array(
                            'forma_pago' => $formaPago[0]['descripcion'],
                            'mensaje' => 'Para que tu pedido sea enviado, tienes que girar la totalidad del mismo al siguiente numero <strong>0974 530 000</strong>. Una vez confirmado el pago, tu pedido será enviado.'
                        );
                        break;
                    case 5 :
                        #usado como parte de pago
                        $mensaje = array(
                            'forma_pago' => $formaPago[0]['descripcion'],
                            'mensaje' => 'Si aprobamos su usado como parte de pago, lo estaremos notificando por cuanto lo tasamos. '
                        );
                        break;
                }
                $asunto = 'Hola ' . $destinatarioNombre . ', muchas gracias por tu compra';
                $cuerpo = $this->getSuccesMessage($mensaje);
                break;
            case 'recuperar[contrasena]':
                //Definimos el tema del email
                $asunto = $asunto;
                $cuerpo = $this->getForgotPass($message);
                break;
            case 'cliente[bienvenida]':
                //Definimos el tema del email
                $asunto = $asunto;
                $cuerpo = $this->getWelcomeMessage();
                break;
            case 'newsletter[bienvenida]':
                $asunto = $asunto;
                $cuerpo = $this->getWelcomeNewsletterMessage();
                break;
            case 'subasta[finalizada]':
                $asunto = $asunto;
                $cuerpo = $this->subastaFinalizada($message);
                break;
            case 'solicitud[financiacion]':
                $asunto = $asunto;
                $cuerpo = $this->solicitudFinanciacion($message);
                break;
            case 'solicitud[admin]':
                $asunto = $asunto;
                $cuerpo = $this->solicitudFinanciacionAdmin($message);
                break;
            case 'compra[admin]':
                $asunto = $asunto;
                $message = 'Se ha realizado un nuevo pedido desde la web, para visualizarlo puede ingresar al <a hre="' . URL . 'admin">administrador</a>';
                $cuerpo = $this->sendAdminEmails($message);
                break;
            case 'subasta[admin]':
                $asunto = $asunto;
                $message = 'Se ha realizado un nuevo pedido desde la web, para visualizarlo puede ingresar al <a hre="' . URL . 'admin">administrador</a>';
                $cuerpo = $this->sendAdminSubasta($message);
                break;
            case 'subasta[oferta]':
                $asunto = $asunto;
                $cuerpo = $this->sendSubastaOferta($message);
                break;
            case 'pedido[cambioEstado]':
                $asunto = $asunto;
                $cuerpo = $this->cambioEstadoPedido($message);
                break;
            case 'pedido[cambioEstadoPago]':
                $asunto = $asunto;
                $cuerpo = $this->cambioEstadoPedidoPago($message);
                break;
            case 'subasta[cambioEstadoPago]':
                $asunto = $asunto;
                $cuerpo = $this->cambioEstadoSubasta($message);
                break;
        }
        mail($destinatario, $asunto, $cuerpo, $headers);
    }

    private function getSuccesMessage($mensaje) {
#obtenemos la direccion del cliente
        //$idDireccion = $_SESSION['checkout']['id_direccion_cliente'];
        //$direccion = $this->db->select("select c.descripcion as ciudad, dc.barrio, dc.calle_principal, dc.calle_lateral1, dc.telefono from direccion_cliente dc left join ciudad c on c.id = dc.id_ciudad where dc.id = $idDireccion");
#carrito
        $carrito = new Carrito();
        $items = $carrito->get_content();
        $subTotal = 0;
#Mensaje
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href="' . URL . '"><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h1>¡Gracias por su compra!</h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Hola ' . $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'] . ', gracias por comprar en nuestro sitio.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Te pasamos los números que has adquirido:</p>
                                    <ul>';
        foreach ($_SESSION['cupon']['datos'] as $value) {
            $idProducto = $value['id_producto'];
            $nombreProducto = $this->db->select("select nombre from producto where id = $idProducto");
            $nombre = $nombreProducto[0]['nombre'];
            $nroCupon = $value['nro_cupon'];
            $message .= "<li>
                                                                                Número del cupón para el producto $nombre: <strong>$nroCupon</strong>
                                                                            </li>";
        }
        var_dump($message);
        die();
        $message .= '</ul>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p><strong>Forma de pago: </strong>' . $mensaje['forma_pago'] . '.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>' . $mensaje['mensaje'] . '.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div><a href="' . URL . 'cliente/dashboard/"
                                                       style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all; margin:10px;">Mi Panel</a></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="w320">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
											<td>&nbsp;</td>
                                            <td class="mini-container-right">
                                                <table cellpadding="0" cellspacing="0" width="100%" background="#fff">
                                                    <tr>
                                                        <td class="mini-block-padding">
                                                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                                                <tr>
                                                                    <td style="background-color:#fff; border:1px solid #e5e5e5; padding:12px 15px 15px;border-radius:5px; width:253px; margin:10px;">
                                                                        <h4>Fecha del Pedido</h4>
                                                                        ' . date('d-m-y H:i:s', strtotime($_SESSION['pedido_finalizado']['fecha'])) . ' <br />
                                                                        <br />
                                                                        <span class="header-sm">Pedido</span> <br />
                                                                        #' . $_SESSION['pedido_finalizado']['id'] . '
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
                    <center>
                        <table cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="item-table">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td class="title-dark" width="300">
                                                Item
                                            </td>
                                            <td class="title-dark" width="163">
                                                Cant.
                                            </td>
                                            <td class="title-dark" width="97">
                                                Total
                                            </td>
                                        </tr>';
        foreach ($items as $item) {
            $subTotal += $item['precio'];
            $message .= '<tr>
                <td class = "item-col item">
                <table cellspacing = "0" cellpadding = "0" width = "100%">
                <tr>
                <td class = "mobile-hide-img">
                <a href = ""><img width = "110" height = "92" src = "' . IMAGE_PRODUCT . $item['imagen'] . '" alt = "item1"></a>
                </td>
                <td class = "product">
                <span style = "color: #4d4d4d; font-weight:bold;">' . $item['nombre'] . '</span> <br />
                </td>
                </tr>
                </table>
                </td>
                <td class = "item-col quantity">
                ' . $item['cantidad'] . '
                </td>
                <td class = "item-col">
                ' . $this->getPrecioCarrito($item['precio'], $item['cantidad']) . '
                </td>
                </tr >';
        }
        $message .= '<tr>
                                            <td class="item-col item mobile-row-padding"></td>
                                            <td class="item-col quantity"></td>
                                            <td class="item-col price"></td>
                                        </tr>


                                        <tr>
                                            <td class="item-col item">
                                            </td>
                                            <td class="item-col quantity" style="text-align:right; padding-right: 10px; border-top: 1px solid #cccccc;">
                                                <span class="total-space">Subtotal</span> <br />
                                                <span class="total-space">Envío</span> <br />
                                                <span class="total-space" style="font-weight: bold; color: #4d4d4d">Total</span>
                                            </td>
                                            <td class="item-col price" style="text-align: left; border-top: 1px solid #cccccc;">
                                                <span class="total-space">' . $this->getPrecioCarrito($subTotal) . '</span> <br />
                                                
                                                <span class="total-space" style="font-weight:bold; color: #4d4d4d">' . $this->getPrecioCarrito($carrito->precio_total()) . '</span>
                                            </td>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function solicitudFinanciacion($mensaje) {
        $items = $this->db->select("select * from producto where id = " . $mensaje['id_producto']);
#Mensaje
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href="' . URL . '"><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h1>Solicitud de Crédito</h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Hola ' . $mensaje['nombre'] . ', hemos recibido tu solicitud.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    En Breve un Asesor Comercial se estara comunicando contigo.
                                </td>
                            </tr>
                            <tr>
                                <td class="w320">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="mini-container-left">
                                                <table cellpadding="0" cellspacing="0" width="100%" style=" ">
                                                    <tr>
                                                        <td class="mini-block-padding">
                                                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                                                <tr>
                                                                    <td style="background-color:#fff; border:1px solid #e5e5e5; padding:12px 15px 15px;border-radius:5px; width:253px; margin:10px;">
                                                                        <h4>Datos de la solicitud</h4>
                                                                        Cantidad Cuotas: ' . $mensaje['cuotas'] . ' <br />
                                                                        Cantidad Items: ' . $mensaje['cantidad'] . ' <br />
                                                                        Monto de la Cuota: ' . $mensaje['monto_cuota'] . ' <br />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
                    <center>
                        <table cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="item-table">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td class="title-dark" width="300">
                                                Producto Seleccionado
                                            </td>
                                        </tr>';
        foreach ($items as $item) {
            $imagenes = explode('|', $item['imagen']);
            $message .= '<tr>
                <td class = "item-col item">
                <table cellspacing = "0" cellpadding = "0" width = "100%">
                <tr>
                <td class = "mobile-hide-img">
                <a href = ""><img width = "110" height = "92" src = "' . IMAGE_PRODUCT . $imagenes[0] . '" alt = "item1"></a>
                </td>
                <td class = "product">
                <span style = "color: #4d4d4d; font-weight:bold;">' . $item['nombre'] . '</span> <br />
                </td>
                </tr>
                </table>
                </td>
                </tr >';
        }
        $message .= '<tr>
                                            <td class="item-col item mobile-row-padding"></td>
                                            <td class="item-col quantity"></td>
                                            <td class="item-col price"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function solicitudFinanciacionAdmin($mensaje) {
        $items = $this->db->select("select * from producto where id = " . $mensaje['id_producto']);
#Mensaje
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href="' . URL . '"><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h1>Solicitud de Crédito</h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Se ha generado una nueva solicitud de financión desde el sitio web. El nombre del solicitante es:' . $mensaje['nombre'] . '</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="w320">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="mini-container-left">
                                                <table cellpadding="0" cellspacing="0" width="100%" style=" ">
                                                    <tr>
                                                        <td class="mini-block-padding">
                                                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                                                <tr>
                                                                    <td style="background-color:#fff; border:1px solid #e5e5e5; padding:12px 15px 15px;border-radius:5px; width:253px; margin:10px;">
                                                                        <h4>Datos de la solicitud</h4>
                                                                        Teléfono: ' . $mensaje['telefono'] . ' <br />
                                                                        Cantidad Cuotas: ' . $mensaje['cuotas'] . ' <br />
                                                                        Cantidad Items: ' . $mensaje['cantidad'] . ' <br />
                                                                        Monto de la Cuota: ' . $mensaje['monto_cuota'] . ' <br />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
                    <center>
                        <table cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="item-table">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td class="title-dark" width="300">
                                                Producto Seleccionado
                                            </td>
                                        </tr>';
        foreach ($items as $item) {
            $imagenes = explode('|', $item['imagen']);
            $message .= '<tr>
                <td class = "item-col item">
                <table cellspacing = "0" cellpadding = "0" width = "100%">
                <tr>
                <td class = "mobile-hide-img">
                <a href = ""><img width = "110" height = "92" src = "' . IMAGE_PRODUCT . $imagenes[0] . '" alt = "item1"></a>
                </td>
                <td class = "product">
                <span style = "color: #4d4d4d; font-weight:bold;">' . $item['nombre'] . '</span> <br />
                </td>
                </tr>
                </table>
                </td>
                </tr >';
        }
        $message .= '<tr>
                                            <td class="item-col item mobile-row-padding"></td>
                                            <td class="item-col quantity"></td>
                                            <td class="item-col price"></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function subastaFinalizada($mensaje) {
        $imagen = explode('|', $mensaje['imagen']);
        #Mensaje
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href="' . URL . '"><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h1>¡Tu subasta ha sido cargada!</h1>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Hola ' . $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'] . ', hemos recibido su subasta.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>La estaremos procesando en la brevedad posible.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Una vez confirmada tu subasta por nuestros asesores, la misma se publicará en <a href="' . URL . 'subasta/">saleosale.com.py/subasta/</a>.</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div><a href="' . URL . 'cliente/dashboard/"
                                                       style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all; margin:10px;">Mi Panel</a></div>
                                </td>
                            </tr>
                            <tr>
                                <td class="w320">
                                    <table cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td class="mini-container-left">
                                                <table cellpadding="0" cellspacing="0" width="100%" style=" ">
                                                    <tr>
                                                        <td class="mini-block-padding">
                                                            <table cellspacing="0" cellpadding="0" width="100%" style="border-collapse:separate !important;">
                                                                <tr>
                                                                    <td style="background-color:#fff; border:1px solid #e5e5e5; padding:12px 15px 15px;border-radius:5px; width:253px; margin:10px;">
                                                                        <h4>Datos de la Subasta</h4>
                                                                        Fecha de Inicio: ' . date('d-m-Y', strtotime($mensaje['fecha_inicio'])) . ' <br />
                                                                        Fecha de Finalización: ' . date('d-m-Y', strtotime($mensaje['fecha_fin'])) . ' <br />
                                                                        Condición: ' . $mensaje['condicion'] . ' <br />
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #ffffff;  border-top: 1px solid #e5e5e5; border-bottom: 1px solid #e5e5e5;">
                    <center>
                        <table cellpadding="0" cellspacing="0" width="600">
                            <tr>
                                <td colspan="3">&nbsp;</td>
                            </tr>
                            <tr>
                                <td class="item-table">
                                    <table cellspacing="0" cellpadding="0" width="100%">
                                        <tr>
                                            <td class="title-dark" width="300">
                                                Item
                                            </td>
                                            <td class="title-dark" width="97">
                                                Oferta Minima
                                            </td>
                                        </tr>';
        $message .= '<tr>
                <td class = "item-col item">
                <table cellspacing = "0" cellpadding = "0" width = "100%">
                <tr>
                <td class = "mobile-hide-img">
                <a href = ""><img width = "110" height = "92" src = "' . IMAGE_SUBASTA . $imagen[0] . '" alt = "item1"></a>
                </td>
                <td class = "product">
                <span style = "color: #4d4d4d; font-weight:bold;">' . utf8_encode($mensaje['marca']) . ' - ' . utf8_encode($mensaje['nombre']) . '</span> <br />
                </td>
                </tr>
                </table>
                </td>
                <td class = "item-col">
                ' . $this->getPrecioCarrito($mensaje['oferta_minima']) . '
                </td>
                </tr >';
        $message .= '
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function getForgotPass($message) {
        $url_temporal = 'http://saleosale.imagenwebhq.com/public/images/';
        #obtenemos el nombre del cliente
        $email = $message['email'];
        $token = $message['token'];
        $fullName = $this->db->select("select nombre, apellido from cliente where email = '$email'");
        $nombre = $fullName[0]['nombre'] . ' ' . $fullName[0]['apellido'];
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h2>Hola ' . $nombre . ', has recibido este correo electrónico porque solicitaste una nueva contraseña para su cuenta.</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Para cambiar su contraseña, haga clic en el siguiente boton:</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div><a href="' . URL . 'login/cambiar/' . $token . '"
                                                       style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all; margin:10px;">Cambiar</a></div>
                                </td>
                            </tr>
                            <tr>
                                <td><p>Si no has solicitado regenerar tu contraseña, por favor haga caso omiso a este correo electrónico.</p></td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function getWelcomeMessage($message) {
        #obtenemos el nombre del cliente
        $email = $message['email'];
        $token = $message['token'];
        $fullName = $this->db->select("select nombre, apellido from cliente where email = '$email'");
        $nombre = $fullName[0]['nombre'] . ' ' . $fullName[0]['apellido'];
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <h2>Hola ' . $nombre . ', gracias por registrarte en nuestra tienda.</h2>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <p>Puedes ingresar al panel de tu cuenta, haciendo clic en el siguiente boton:</p>
                                </td>
                            </tr>
                            <tr>
                                <td align="center">
                                    <div><a href="' . URL . 'login"
                                                       style="background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all; margin:10px;">Ingresar</a></div>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function sendAdminEmails($mensaje) {
        #obtenemos el nombre del cliente

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Gracias por su Compra</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <p>' . $mensaje . '</p>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function sendAdminSubasta($mensaje) {

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nueva Subasata</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <p> Se ha agregao una nueva subasta en el sitio</p>
                                    <p> Para ver los detalles de la misma puedes acceder al administrador del sitio</p>
                                    <a href="' . URL . 'admin/subastas/">Admin</a>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function cambioEstadoPedido($mensaje) {

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nueva Subasata</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <p> Hola ' . $mensaje['cliente'] . ', el estado de tu pedido ha cambiado.</p>
                                    <p> Nuevo Estado: <strong>' . $mensaje['estado'] . '</strong></p>
                                    <p> Puedes acceder a tu pedido haciendo clic en el siguiente enlace <a href="' . URL . 'cliente/ordenes/' . $mensaje['id_pedido'] . '">Pedido</a>
                                        <br> o puedes acceder a tu <a href="' . URL . 'login">cuenta</a></p>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function cambioEstadoPedidoPago($mensaje) {

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nueva Subasata</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <p> Hola ' . $mensaje['cliente'] . ', el estado del pago de uno de tus pedidos ha cambiado.</p>
                                    <p> Nuevo Estado: <strong>' . $mensaje['estado'] . '</strong></p>
                                    <p> Puedes acceder a tu pedido haciendo clic en el siguiente enlace <a href="' . URL . 'cliente/ordenes/' . $mensaje['id_pedido'] . '">Pedido</a>
                                        <br> o puedes acceder a tu <a href="' . URL . 'login">cuenta</a></p>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function cambioEstadoSubasta($mensaje) {

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <title>Nueva Subasata</title>
	</head>
    <body bgcolor="#f7f7f7">
		<table align="center" cellpadding="0" cellspacing="0" class="container-for-gmail-android" width="100%">
            <tr>
                <td align="left" valign="top" width="100%" style="background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                    <center>
                        <img src="http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class="force-width-gmail">
                            <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#ffffff" background="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style="background-color:transparent">
                                <tr>
                                    <td width="100%" height="80" valign="top" style="text-align: center; vertical-align:middle;">
                                        <!--[if gte mso 9]>
                                        <v:rect xmlns:v="urn:schemas-microsoft-com:vml" fill="true" stroke="false" style="mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                                          <v:fill type="tile" src="http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color="#ffffff" />
                                          <v:textbox inset="0,0,0,0">
                                        <![endif]-->
                                        <center>
                                            <table cellpadding="0" cellspacing="0" width="600" class="w320">
                                                <tr>
                                                    <td class="pull-left mobile-header-padding-left" style="vertical-align: middle;">
                                                        <a href=""><img width="220" src="' . IMAGES . 'logo.png" alt="logo" /></a>
                                                    </td>
                                                    <td class="pull-right mobile-header-padding-right" style="color: #4d4d4d;">
                                                        <a href=""><img width="44" height="47" src="http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt="twitter" /></a>
                                                        <a href=""><img width="38" height="47" src="http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt="facebook" /></a>
                                                    </td>
                                                </tr>
                                            </table>
                                        </center>
                                        <!--[if gte mso 9]>
                                        </v:textbox>
                                      </v:rect>
                                      <![endif]-->
                                    </td>
                                </tr>
                            </table>
                    </center>
                </td>
            </tr>
            <tr>
                <td align="center" valign="top" width="100%" style="background-color: #f7f7f7;" class="content-padding">
                    <center>
                        <table cellspacing="0" cellpadding="0" width="600" class="w320">
                            <tr>
                                <td align="center">
                                    <p> Hola ' . $mensaje['cliente'] . ', el estado de una de tus subastas ha cambiado.</p>
                                    <p> Nuevo Estado: <strong>' . $mensaje['estado'] . '</strong></p>
                                    <p> Puedes acceder a tu subasta haciendo clic en el siguiente enlace <a href="' . URL . 'cliente/modificar/' . $mensaje['id'] . '">Substa</a>
                                        <br> o puedes acceder a tu <a href="' . URL . 'login">CUENTA</a></p>
                                </td>
                            </tr>
                        </table>
                    </center>
                </td>
            </tr>
            ' . $this->direccionEmail() . '
        </table>
	</body>
</html>';
        return $message;
    }

    private function sendSubastaOferta(
    $mensaje) {

        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
        <html xmlns = "http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
                <meta name = "viewport" content = "width=device-width, initial-scale=1" />
                <title>Nueva Subasata</title>
                </head>
                <body bgcolor = "#f7f7f7">
                <table align = "center" cellpadding = "0" cellspacing = "0" class = "container-for-gmail-android" width = "100%">
                <tr>
                <td align = "left" valign = "top" width = "100%" style = "background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                <center>
                <img src = "http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class = "force-width-gmail">
                <table cellspacing = "0" cellpadding = "0" width = "100%" bgcolor = "#ffffff" background = "http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style = "background-color:transparent">
                <tr>
                <td width = "100%" height = "80" valign = "top" style = "text-align: center; vertical-align:middle;">
                <!--[if gte mso 9]>
                <v:rect xmlns:v = "urn:schemas-microsoft-com:vml" fill = "true" stroke = "false" style = "mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                <v:fill type = "tile" src = "http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color = "#ffffff" />
                <v:textbox inset = "0,0,0,0">
                <![endif] -->
                <center>
                <table cellpadding = "0" cellspacing = "0" width = "600" class = "w320">
                <tr>
                <td class = "pull-left mobile-header-padding-left" style = "vertical-align: middle;">
                <a href = ""><img width = "220" src = "' . IMAGES . 'logo.png" alt = "logo" /></a>
                </td>
                <td class = "pull-right mobile-header-padding-right" style = "color: #4d4d4d;">
                <a href = ""><img width = "44" height = "47" src = "http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt = "twitter" /></a>
                <a href = ""><img width = "38" height = "47" src = "http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt = "facebook" /></a>
                </td>
                </tr>
                </table>
                </center>
                <!--[if gte mso 9]>
                </v:textbox>
                </v:rect>
                <![endif] -->
                </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>
                <tr>
                <td align = "center" valign = "top" width = "100%" style = "background-color: #f7f7f7;" class = "content-padding">
                <center>
                <table cellspacing = "0" cellpadding = "0" width = "600" class = "w320">
                <tr>
                <td align = "center">
                <p> Hola ' . $mensaje['nombre'] . ', han superado tu oferta en la siguiente subasta:<br>
                <a href = "' . URL . 'subasta/item/' . $mensaje['id_subasta'] . '">' . URL . 'subasta/item/' . $mensaje['id_subasta'] . ' </a><br>
                <span style = "font-size:12px;">OBS.: Tienes que haber iniciado sesión para poder visualizar la subasta</span></p>

                <p> La fecha en que se realizo la oferta fue el ' . date('d-m-Y H:i:s ', strtotime($mensaje['fecha_oferta'])) . ' <br>
                El monto ofertado fue de ' . $mensaje['monto_oferta'] . ' </p>
                </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>
                ' . $this->direccionEmail() . '
                </table>
                </body>
                </html>';
        return $message;
    }

    private function getWelcomeNewsletterMessage($message) {
        #obtenemos el nombre del cliente
        $email = $message['

        email'];
        $token = $message['token'];
        $fullName = $this->db->select("select nombre, apellido from cliente where email = '$email'");
        $nombre = $fullName[0]['nombre'] . ' ' . $fullName[0]['apellido'];
        $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
                <html xmlns = "http://www.w3.org/1999/xhtml">
                <head>
                <meta http-equiv = "Content-Type" content = "text/html; charset=UTF-8" />
                <meta name = "viewport" content = "width=device-width, initial-scale=1" />
                <title>Gracias por su Compra</title>
                </head>
                <body bgcolor = "#f7f7f7">
                <table align = "center" cellpadding = "0" cellspacing = "0" class = "container-for-gmail-android" width = "100%">
                <tr>
                <td align = "left" valign = "top" width = "100%" style = "background:repeat-x url(http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg) #ffffff;">
                <center>
                <img src = "http://s3.amazonaws.com/swu-filepicker/SBb2fQPrQ5ezxmqUTgCr_transparent.png" class = "force-width-gmail">
                <table cellspacing = "0" cellpadding = "0" width = "100%" bgcolor = "#ffffff" background = "http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" style = "background-color:transparent">
                <tr>
                <td width = "100%" height = "80" valign = "top" style = "text-align: center; vertical-align:middle;">
                <!--[if gte mso 9]>
                <v:rect xmlns:v = "urn:schemas-microsoft-com:vml" fill = "true" stroke = "false" style = "mso-width-percent:1000;height:80px; v-text-anchor:middle;">
                <v:fill type = "tile" src = "http://s3.amazonaws.com/swu-filepicker/4E687TRe69Ld95IDWyEg_bg_top_02.jpg" color = "#ffffff" />
                <v:textbox inset = "0,0,0,0">
                <![endif] -->
                <center>
                <table cellpadding = "0" cellspacing = "0" width = "600" class = "w320">
                <tr>
                <td class = "pull-left mobile-header-padding-left" style = "vertical-align: middle;">
                <a href = ""><img width = "220" src = "' . IMAGES . 'logo.png" alt = "logo" /></a>
                </td>
                <td class = "pull-right mobile-header-padding-right" style = "color: #4d4d4d;">
                <a href = ""><img width = "44" height = "47" src = "http://s3.amazonaws.com/swu-filepicker/k8D8A7SLRuetZspHxsJk_social_08.gif" alt = "twitter" /></a>
                <a href = ""><img width = "38" height = "47" src = "http://s3.amazonaws.com/swu-filepicker/LMPMj7JSRoCWypAvzaN3_social_09.gif" alt = "facebook" /></a>
                </td>
                </tr>
                </table>
                </center>
                <!--[if gte mso 9]>
                </v:textbox>
                </v:rect>
                <![endif] -->
                </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>
                <tr>
                <td align = "center" valign = "top" width = "100%" style = "background-color: #f7f7f7;" class = "content-padding">
                <center>
                <table cellspacing = "0" cellpadding = "0" width = "600" class = "w320">
                <tr>
                <td align = "center">
                <h2>Hola!, te has suscrito al newsletter.</h2>
                </td>
                </tr>
                <tr>
                <td align = "center">
                <p>Para ver todas nuestras ofertas y promociones puedes ver acceder a nuestro sitio web.</p>
                </td>
                </tr>
                <tr>
                <td align = "center">
                <div><a href = "' . URL . '"
                style = "background-color:#ff6f6f;border-radius:5px;color:#ffffff;display:inline-block;font-family:\'Cabin\', Helvetica, Arial, sans-serif;font-size:14px;font-weight:regular;line-height:45px;text-align:center;text-decoration:none;width:155px;-webkit-text-size-adjust:none;mso-hide:all; margin:10px;">Ir al Sitio</a></div>
                </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>
                ' . $this->direccionEmail() . '
                </table>
                </body>
                </html>';
        return $message;
    }

    private function direccionEmail() {
        $direccion = '

        <tr>
                <td align = "center" valign = "top" width = "100%" style = "background-color: #fff; height: 100px;">
                <center>
                <table cellspacing = "0" cellpadding = "0" width = "600" class = "w320">
                <tr>
                <td style = "padding: 25px 0 25px" align = "center">
                <strong>Sociedad Anónima Comercial de Occidente (SACO) </strong><br />
                (+595 021) 328 3400 <br />
                Santa Rosa 668 c/ España <br />
                Asunción - Paraguay <br /><br />
                </td>
                </tr>
                </table>
                </center>
                </td>
                </tr>';
        return $direccion;
    }

    /**
     * Funcion que retorna el costo de envio de la ciudad seleccionada para
     * el envio del pedido
     * @return float costo de envio
     */
    private function getCostoEnvio() {
        $costo = (float) 0;
        $id = $_SESSION['checkout']['id_direccion_cliente'];
        $result = $this->db->select("select ce.costo from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad LEFT JOIN costo_envio ce on ce.id = c.id_costo_envio where dc.id = :id", array(':id ' => $id));
        $costo = $result[0]['costo'];
        return $costo;
    }

    /**
     * Funcion que retorna el estado del pedido
     * @param string $estado
     * @return string con el mensaje formateado
     */
    public function estadoPedido($estado) {
        $type = '';
        $message = '';
        switch ($estado) {
            case 'Confirmado':
                $type = 'info';
                $message = 'Su pedido ha sido Confirmado.';
                break;
            case 'Procesando':
                $type = 'info';
                $message = 'Su pedido está siendo procesado.';
                break;
            case 'En camino al cliente':
                $type = 'info';
                $message = 'Su pedido ya está en camino.';
                break;
            case 'Sin stock':
                $type = 'info';
                $message = 'Lo sentimos, estamos sin stock';
                break;
            case 'Entregado':
                $type = 'info';
                $message = 'Su pedido ya ha sido entregado.';
                break;
            case 'Devuelto':
                $type = 'info';
                $message = 'Ha devuelto este pedido.';
                break;
            case 'Cancelado':
                $type = 'error';
                $message = 'Su pedido ha sido cancelado.';
                break;
        }
        $estadoPedido = $this->messageAlert($type, $message);
        return $estadoPedido;
    }

    public function estadoPago($estado) {
        $type = '';
        $message = '';
        switch ($estado) {
            case 'Pendiente':
                $type = 'warning';
                $message = 'Pendiente de pago.';
                break;
            case 'Procesando Pago':
                $type = 'info';
                $message = 'Su pago está siendo procesado.';
                break;
            case 'Pago Confirmado':
                $type = 'success';
                $message = 'Pago Confirmadoo.';
                break;
            case 'Error de Pago':
                $type = 'error';
                $message = 'Lo sentimos, hubo un error con su pago';
                break;
            case 'Reembolsado':
                $type = 'info';
                $message = 'Su pago ha sido reembolsado.';
                break;
            case 'Expirado':
                $type = 'error';
                $message = 'Su pago ha expirado. ';
                break;
        }
        $estadoPago = $this->messageAlert($type, $message);
        return $estadoPago;
    }

    /**
     * Funcion que retorna la lista de pagina de acuerdo a la seccion pasada
     * [Solo para el Footer]
     * @param int $idSeccion
     * @return string con la lista de paginas
     */
    public function getPaginas($idSeccion) {
        $result = $this->db->select("select p.id as id_pagina, p.nombre_pagina, p.url_rewrite from pagina p WHERE p.id_seccion_pagina = $idSeccion and p.estado = 1");
        $enlaces = '<ul class = "links">';
        foreach ($result as $item) {
            $enlaces .= '<li><a href = "' . URL . 'pagina/seccion/' . $item['id_pagina'] . '/' . $item

                    ['url_rewrite'] . '" title = "' . utf8_encode($item['nombre_pagina']) . '">' . utf8_encode($item['nombre_pagina']) . '</a></li>';
        }
        $enlaces .= '</ul>';
        return $enlaces;
    }

    /**
     * Funcion que muestra la valoracion del producto
     * @param int $idProducto
     * @param int $vista (1->Catalogo, 2->Producto, 3->Opiniones)
     * @return string con la valoracion del producto
     */
    public function calcularValoracion($idProducto, $vista, $idCliente = NULL) {
        #obtenemos las valoraciones del producto
        $cant = 0;
        if ($idCliente == null) {
            $sqlOpinion = $this->db->select("select valorizacion from producto_opinion where id_producto = $idProducto");
        } else {
            $sqlOpinion = $this->db->select("select valorizacion from producto_opinion where id_producto = $idProducto and id_cliente = $idCliente");
        }
        $opinion = array();
        foreach ($sqlOpinion as $item) {
            array_push($opinion, $item['valorizacion']);
        }
        if (!empty($opinion)) {
            #calculamos la media
            $sum = array_sum($opinion);
            $cant = count($opinion);
            $media = $sum / $cant;
            #calculamos el porcentaje
            /*
             * 5----------100
             * $media-----x
             * ($media*100)/5
             */
            $porcentaje = ($media * 100) / 5;
        } else {
            $porcentaje = 0;
        }
        switch ($vista) {
            case '1':
                $rating = '<div class = "rating-box">
                    <div class = "rating" id = "rating' . $idProducto . ' "></div>
                    </div>';
                if ($porcentaje != 0) {
                    $rating .= '<script type = "text/javascript">
                                $(document).ready(function(){
                                    $("#rating' . $idProducto . '").css("width", "' . $porcentaje . '");
                                }); </script>';
                } else {
                    $rating .= '<script type="text/javascript">
    $(document).ready(function () {
        $("#rating' . $idProducto . '").css("width", "0");
    });
</script>';
                }
                break;
            case '2':
//producto
                if ($porcentaje != 0) {
                    $rating = '<p class="rating-links"> <a href="#">' . $cant . ' reseña(as)</a> <span class="separator">|</span> <a href="#product-detail-tab">Agregar una Reseña</a> </p>';
                    $rating .= '<script type="text/javascript">
    $(document).ready(function () {
        $(".rating-box .rating").css("width", "' . $porcentaje . '");
    });
</script>';
                } else {
                    $rating = '<p class="rating-links"> <a href="#">0 reseña(as)</a> <span class="separator">|</span> <a href="#product-detail-tab">Agregar una Reseña</a> </p>';
                    $rating .= '<script type="text/javascript">
    $(document).ready(function () {
        $(".rating-box .rating").css("width", "0");
    });
</script>';
                }
                break;
        }
        return $rating;
    }

    /**
     * Funcion que lista las opciones del campo enum de una tabla
     * @param string $table
     * @param string $field
     * @return array con las opciones del campo enum
     */
    public function getEnumOptions($table, $field) {
        $finalResult = array();
        if (strlen(trim($table)) < 1)
            return false;
        $query = $this->db->select("show columns from $table");
        foreach ($query as $row) {
            if ($field != $row["Field"])
                continue;
            //check if enum type 
            if (preg_match('/enum.(.*)./', $row['Type'], $match)) {
                $opts = explode(',', $match[1]);
                foreach ($opts as $item)
                    $finalResult[] = substr($item, 1, strlen($item) - 2);
            } else
                return false;
        }
        return $finalResult;
    }

    public function getCiudadesZonas($idZona) {
        $sqlCuiadades = $this->db->select("select c.id, c.descripcion as ciudad, c.id_departamento, d.descripcion as departamento from ciudad c LEFT JOIN departamento d on d.id = c.id_departamento where id_costo_envio = $idZona and c.estado = 1");
        return $sqlCuiadades;
    }

    public function getCiudadesDepartamentos($idDepartamento) {
        $sqlCiudades = $this->db->select("select distinct c.id, c.descripcion as ciudad from ciudad c where c.id_departamento = $idDepartamento and c.id_costo_envio is NULL");
        return $sqlCiudades;
    }

    public function getMenuBanner($idCategoria) {
        $banners = $this->db->select("SELECT b.imagen, b.enlace FROM banner b WHERE b.id_categoria = $idCategoria AND estado = 1 AND estado_menu = 1 ORDER BY b.orden ASC");
        $banner = '';
        if (!empty($banners)) {
            $banner = '<div class="nav-add">';
            foreach ($banners as $item) {
                $imagen = utf8_encode($item['imagen']);
                $enlace = $item['enlace'];
                $banner .= '<div class="push_item">
        <div class="push_img"> <a href="' . URL . $enlace . '"> <img alt="' . $imagen . '" src="' . IMAGES . 'categorias/' . $imagen . '"></a> </div>
    </div>';
            }
            $banner .='                <br class="clear">
</div>';
        }
        return $banner;
    }

    public function obtenerOfertaActual($idSubasta) {
        $ofertas = array();
        $sqlSubastaOferta = $this->db->select("select monto_oferta, fecha_oferta from subasta_oferta where id_subasta = $idSubasta order by fecha_oferta LIMIT 1");
        if (!empty($sqlSubastaOferta)) {
            $pujas = $this->getSubastaOfertas($idSubasta, 1);
            $monto_oferta = $sqlSubastaOferta[0]['monto_oferta'];
            if (!empty($pujas[0]['monto_oferta'])) {
                if ($pujas[0]['monto_oferta'] > $monto_oferta)
                    $monto_oferta = $pujas[0]['monto_oferta'];
            }
            array_push($ofertas, array(
                'oferta' => $monto_oferta,
                'fecha_oferta' => $sqlSubastaOferta[0]['fecha_oferta']
            ));
        }
        return $ofertas;
    }

    /**
     * Funcion que retorna las ofertas de una subasta, ordenadas descendentemente  
     * @param int $idSubasta
     * @param int $limit
     * @return array
     */
    public function getSubastaOfertas($idSubasta, $limit = NULL) {
        $limite = '';
        if (!empty($limit))
            $limite = "LIMIT $limit";
        $ofertas = array();
        $sqlOfertas = $this->db->select("select s.id,
                                                so.monto_oferta,
                                                so.id_cliente as id_ofertante,
                                                so.fecha_oferta
                                        from subasta s
                                        LEFT JOIN subasta_oferta so on s.id = so.id_subasta
                                        where s.id = $idSubasta
                                        ORDER BY so.id DESC $limite");
        foreach ($sqlOfertas as $item) {
            array_push($ofertas, array(
                'id_subasta' => $item['id'],
                'monto_oferta' => $item['monto_oferta'],
                'id_ofertante' => $item['id_ofertante'],
                'fecha_oferta' => $item['fecha_oferta']
            ));
        }
        return $ofertas;
    }

    public function calcularCuotaProducto($precioProducto, $interes = 5, $cuotas = 12, $anual = 0.42) {
        $gasto_monto = ($precioProducto * $interes) / 100;
        $monto_total_prestamo = $precioProducto + $gasto_monto;
        $mes = $anual / 12;
        $aux = (pow(1 + $mes, $cuotas) - 1);
        $aux_2 = $mes * pow(1 + $mes, $cuotas);
        $aux_3 = $aux / $aux_2;

        $monto_cuota = $this->getPrecioCarrito($monto_total_prestamo / $aux_3);
        return $monto_cuota;
    }

    /**
     * 
     * @param string $texto
     * @param string $tipo (danger,success,warning,default,primary)
     * @param string $id
     * @return string
     */
    public function showLabel($texto, $tipo, $id = null) {
        $idLabel = '';
        if (!empty($id)) {
            $idLabel = "id='$id'";
        }
        $label = "<span class='label label-$tipo' $idLabel>$texto</span>";
        return $label;
    }

    public function getEmailsAdmin($clave) {
        $sqlEmails = $this->db->select("select valor from cms_config_sitio ccs where ccs.clave = '$clave'");
        return $sqlEmails[0]['valor'];
    }

}
