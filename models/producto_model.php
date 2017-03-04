<?php

class Producto_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion para mostrar el slider de las categorias
     * @param int $idPosicion
     * @param int $idCategoria
     */
    public function mostrarBanner($idPosicion, $idCategoria, $orden = 'ASC') {
        $bannerCategoria = array();
        $estado = 1;
        $item = '';
        $categoria = $this->db->select("SELECT * FROM banner WHERE id_posicion = :idPosicion AND id_categoria = :idCategoria AND estado = :estado ORDER BY orden $orden", array(':idPosicion' => $idPosicion, ':idCategoria' => $idCategoria, ':estado' => $estado));
        foreach ($categoria as $cat) {
            $item .='<!-- Item -->
                    <div class="item"> <a href="' . URL . $cat['enlace'] . '"><img alt="" src="' . IMAGES . 'categorias/' . $cat['imagen'] . '"></a> </div>
                    <!-- End Item --> ';
        }
        array_push($bannerCategoria, $item);
        return $bannerCategoria;
    }

    public function getProducto($producto) {
        return $producto;
    }

    /**
     * Funcion para mostrar los productos en sus categorias o como relacionados
     * @param int $idCategoria
     * @param int $idProducto default NULL
     * @param string $orden default DESC
     * @param int $limit default 8
     * @return array con grilla de productos
     */
    public function getProductos($idCategoria, $idProducto = NULL, $orden = 'DESC', $limit = 8, $limitEnd = NULL) {
        $helper = new Helper();
        $estado = 1;
        $item = '';
        $lista = array();
        #formateamos el Order BY
        if ($orden == 'RAND()') {
            $order = "ORDER BY RAND()";
        } else {
            $order = "ORDER BY id $orden";
        }
        if (!empty($idProducto)) {
            $helper = new Helper();
            //ITEM VIEW
            #excluimos del producto de la lista
            $productos = $this->db->select("select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.id_categoria IN (:idCategoria) AND p.estado = :estado AND p.id != :idProducto $order LIMIT $limit", array(':idCategoria' => $idCategoria, ':estado' => $estado, ':idProducto' => $idProducto));
            foreach ($productos as $producto) {
                $imagen = explode('|', $producto['imagen']);
                #el primer elemento siempre va a ser la imagen principal
                $imagen = $imagen[0];
                //guaranies
                if ($producto['id_moneda'] == 1) {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 0, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 0, ',', '.');
                    }
                    //dolares
                } else {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 2, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 2, ',', '.');
                    }
                }
                $item .= '<!-- Item -->
                        <div class="item">
                            <div class="col-item">';
                if ($producto['precio_oferta'] != 0)
                    $item .= '<div class="sale-label sale-top-right">Oferta</div>';
                if ($producto['nuevo'] == 1)
                    $item .= '<div class="new-label new-top-right">Nuevo</div>';
                $item .= '<div class="product-image-area"> <a class="product-image" title="' . $producto['nombre'] . '" href="' . $helper->urlProducto($producto['id']) . '"> <img src="' . IMAGE_PRODUCT . $imagen . '" class="img-responsive" alt="' . $producto['nombre'] . '" /> </a></div>';
                if (!empty($_SESSION['cliente']['id'])) {
                    $item .= '<div class="actions-links"><span class="add-to-links"> <a title="Agregar a mi lista de Deseos" class="link-wishlist" href="' . URL . 'cliente/agregar_lista_deseo/' . $_SESSION['cliente']['id'] . '/' . $producto['id'] . '"><span>Agregar a mi lista de Deseos</span></a></span> </div>';
                }
                $item .='<div class="info">
                                    <div class="info-inner">
                                        <div class="item-title"> <a title=" " href="' . $helper->urlProducto($producto['id']) . '"> ' . $producto['marca'] . ' - ' . $producto['nombre'] . '</a> </div>
                                        <!--item-title-->
                                        <div class="item-content">
                                           <div class="ratings">
                                                <div class="rating-box">
                                                    ' . $helper->calcularValoracion($producto['id'], 1) . '
                                                </div>
                                            </div>
                                           <div class="price-box">';
                if ($producto['precio_oferta'] == 0) {
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
                                        <a href="' . URL . 'cart/agregar/' . $producto['id'] . '" title="Agregar al Carrito" class="button btn-cart"><span>Agregar al Carrito</span></a>
                                    </div>
                                    <!--actions-->
                              <div class="clearfix"> </div>
                            </div>
                        </div>
                      </div>';
            }
            array_push($lista, $item);
        } elseif ((!empty($idCategoria)) && (empty($idProducto))) {
            //CATEGORY VIEW
            $productos = $this->db->select("select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.id_categoria IN ($idCategoria) AND p.estado = :estado $order LIMIT $limit,$limitEnd", array(':estado' => $estado));
            foreach ($productos as $producto) {
                $imagen = explode('|', $producto['imagen']);
                #el primer elemento siempre va a ser la imagen principal
                $imagen = $imagen[0];
                //guaranies
                if ($producto['id_moneda'] == 1) {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 0, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 0, ',', '.');
                    }
                    //dolares
                } else {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 2, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 2, ',', '.');
                    }
                }
                $item .='<li class="item col-lg-4 col-md-3 col-sm-4 col-xs-12">
                            <div class="col-item">';
                if ($producto['precio_oferta'] != 0)
                    $item .= '<div class="sale-label sale-top-right">Oferta</div>';
                if ($producto['nuevo'] == 1)
                    $item .= '<div class="new-label new-top-right">Nuevo</div>';
                $item .= '<div class="product-image-area"> <a class="product-image" title="' . $producto['nombre'] . '" href="' . $helper->urlProducto($producto['id']) . '"> <img src="' . IMAGE_PRODUCT . $imagen . '" class="img-responsive" alt="a" /> </a></div>';
                if (!empty($_SESSION['cliente']['id'])) {
                    $item .= '<div class="actions-links"><span class="add-to-links"> <a title="Agregar a mi lista de Deseos" class="link-wishlist" href="' . URL . 'cliente/agregar_lista_deseo/' . $_SESSION['cliente']['id'] . '/' . $producto['id'] . '"><span>Agregar a mi lista de Deseos</span></a></span> </div>';
                }
                $item .= '<div class="info">
                                    <div class="info-inner">
                                        <div class="item-title"> <a title=" Sample Product" href="' . $helper->urlProducto($producto['id']) . '"> ' . $producto['marca'] . ' - ' . $producto['nombre'] . ' </a> </div>
                                        <!--item-title-->
                                        <div class="item-content">
                                            <div class="ratings">
                                                <div class="rating-box">
                                                    ' . $helper->calcularValoracion($producto['id'], 1) . '
                                                </div>
                                            </div>
                                            <div class="price-box">';
                if ($producto['precio_oferta'] == 0) {
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
                                        <a href="' . URL . 'cart/agregar/' . $producto['id'] . '" type="button" title="Agregar al Carrito" class="button btn-cart"><span>Agregar al Carrito</span></a>
                                    </div>
                                    <!--actions-->

                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </li>';
            }
            array_push($lista, $item);
        } //elseif (!empty($limitEnd)) {
//            $productos = $this->db->select("SELECT * from producto WHERE id_categoria = :idCategoria AND estado = :estado $order LIMIT $limit,$limitEnd", array(':idCategoria' => $idCategoria, ':estado' => $estado));
//        }
        return $lista;
    }

    /**
     * 
     * @param type $idCategoria
     * @param type $pagina
     * @return array
     */
    public function getItemsPaginacion($idCategoria, $pagina = NULL) {
        #numero de registros por pagina
        $num_rec_per_page = CANT_REGISTROS_PAGINA;
        #verificamos en que pagina se encuentra
        if (!empty($pagina)) {
            $page = $pagina;
        } else {
            $page = 1;
        }
        #definimos la pagina actual
        $start_from = ($page - 1) * $num_rec_per_page;

        $item = $this->getProductos($idCategoria, NULL, 'DESC', $start_from, $num_rec_per_page);
        return $item;
    }

    /**
     * Funcion para obtener la navegacion de la paginacion
     * @param string $idCategoria
     * @param string $nombreCategoria
     * @param int $pagina
     * @return array
     */
    public function getPaginas($idCategoria, $nombreCategoria, $pagina, $busqueda = NULL, $string = NULL) {
        $estado = 1;
        $paginas = "";
        #obtenemos el nombre de la categoria
        #numero de registros por pagina
        $num_rec_per_page = CANT_REGISTROS_PAGINA;
        /*
         * Verificamos de donde se realizo la solicitud
         * si es null, es una categoria
         * sino, es una busqueda
         */
        if ($string == NULL) {
            $sqlProductos = $this->db->select("SELECT * FROM producto WHERE id_categoria IN ($idCategoria) AND estado = :estado", array(':estado' => $estado));
        } else {
            $busq = preg_replace('/(\s|\+)+/s', ' + ', $busqueda);
            $busq_arr = explode(' + ', $busq);
            foreach ($busq_arr as $_ind => $_val) {
                switch (true) {
                    case preg_match('/.{3,}[^e]s/', $_val):
                        $busq_arr[$_ind] = substr($_val, 0, -1);
                        break;
                    case preg_match('/.{3,}es/', $_val):
                        $busq_arr[$_ind] = substr($_val, 0, -2);
                        break;
                }
            }
            $order = "ORDER BY id DESC";
            if ($idCategoria == 0) {
                $sql = "SELECT * from producto WHERE estado = :estado ";
                $sql .= "AND nombre LIKE '%" . implode('%', $busq_arr) . "%' ";
                $sql .= "OR tags LIKE '%" . implode('%', $busq_arr) . "%' ";
                $sqlProductos = $this->db->select($sql, array(':estado' => $estado));
            } else {
                $sql = "SELECT * from producto WHERE id_categoria IN (:categoria) ";
                $sql .= "AND estado = :estado ";
                $sql .= "AND nombre LIKE '%" . implode('%', $busq_arr) . "%' ";
                $sql .= "OR tags LIKE '%" . implode('%', $busq_arr) . "%' ";
                $sqlProductos = $this->db->select($sql, array(':categoria' => $idCategoria, ':estado' => $estado));
            }
        }
        //cantidad total de registros
        $total_records = count($sqlProductos);
        //total de paginas
        $total_pages = ceil($total_records / $num_rec_per_page);
        $paginas .= "<ul class='pagination'>";
        if ($string == NULL) {
            $paginas .= "<li><a href='" . URL . "producto/categoria/" . $nombreCategoria . "/1'>" . '|<' . "</a></li> "; // Goto 1st page  
        } else {
            $paginas .= "<li><a href='" . URL . "producto/" . $nombreCategoria . "/1/" . $string . "'>" . '|<' . "</a></li> "; // Goto 1st page  
        }
        for ($i = 1; $i <= $total_pages; $i++) {
            $var_class = "class_" . $i;
            if ($pagina == $i) {
                $var_class = 'class="active"';
            } else {
                $var_class = 'class=""';
            }
            if ($string == NULL) {
                $paginas .= "<li $var_class><a href='" . URL . "producto/categoria/" . $nombreCategoria . "/" . $i . "'>" . $i . "</a></li> ";
            } else {
                $paginas .= "<li $var_class><a href='" . URL . "producto/" . $nombreCategoria . "/" . $i . "/" . $string . "'>" . $i . "</a> </li>";
            }
        };
        if ($string == NULL) {
            $paginas .= "<li><a href='" . URL . "producto/categoria/" . $nombreCategoria . "/" . $total_pages . "'>" . '>|' . "</a> </li>"; // Goto last page
        } else {
            $paginas .= "<li><a href='" . URL . "producto/" . $nombreCategoria . "/" . $total_pages . "/" . $string . "'>" . '>|' . "</a> </li>"; // Goto last page
        }
        $paginas .= "</ul>";
        return $paginas;
    }

    /**
     * Funcion para obtener las categorias hijas del padre y armar el menu
     * @param int $id
     * @param string $nombres
     * @return array
     */
    public function getCategoriasHijas($id, $nombres = NULL) {
        $subCategoria = array();
        $name = "";
        #si $idCategoria != NULL es padre
        if ($nombres != NULL) {
            foreach ($nombres as $item) {
                $name .= '<li class="level0- level0 last"> <span class="magicat-cat"><a href="' . URL . 'producto/categoria/' . $item['url_rewrite'] . '-' . $item['id'] . '"><span>' . utf8_encode($item['descripcion']) . '</span></a></span> </li>';
            }
            array_push($subCategoria, $name);
        } else {
            $categorias = $this->db->select("SELECT cat.id, cat.descripcion, cat.url_rewrite  from categoria c LEFT JOIN categoria cat on cat.padre_id = c.padre_id where c.id = $id and c.estado = 1");
            foreach ($categorias as $item) {
                $name .= '<li class="level0- level0 last"> <span class="magicat-cat"><a href="' . URL . 'producto/categoria/' . $item['url_rewrite'] . '-' . $item['id'] . '"><span>' . utf8_encode($item['descripcion']) . '</span></a></span> </li>';
            }
            array_push($subCategoria, $name);
        }

        return $subCategoria;
    }

    /**
     * Funcion para mostrar publicidad en el detalle de un producto
     * @param int $idPosicion
     * @param int $idCategoria
     * @param int $idProducto
     * @param string $orden
     * @return string
     */
    public function getPublicidadProducto($idPosicion, $idCategoria, $idProducto, $orden = "RAND()") {
        $banner = $this->db->select("SELECT imagen, enlace FROM banner WHERE id_posicion = :idPosicion AND id_categoria = :idCategoria AND id_producto = :idProducto", array(':idPosicion' => $idPosicion, ':idCategoria' => $idCategoria, ':idProducto' => $idProducto));
        $publicidad = "";
        if (!empty($banner)) {
            $publicidad .= '<div class="text-banner">
                                        <a href="' . utf8_encode($banner[0]['enlace']) . '"><img src="' . IMAGES_PUBLICIDAD . utf8_encode($banner[0]['imagen']) . '" alt="' . utf8_encode($banner[0]['imagen']) . '"></a>
                                    </div>';
        }
        return $publicidad;
    }

    /**
     * Retorna los resultados de una busqueda realizada por el usuario
     * @param int $idCategoria
     * @param string $stringBusqueda
     * @return array
     */
    public function getBusqueda($pagina, $id_categoria, $busqueda) {
        $resultados = array();
        #numero de registros por pagina
        $num_rec_per_page = CANT_REGISTROS_PAGINA;
        #verificamos en que pagina se encuentra
        if (!empty($pagina)) {
            $page = $pagina;
        } else {
            $page = 1;
        }
        #definimos la pagina actual
        $start_from = ($page - 1) * $num_rec_per_page;

        $resultados = $this->getProductosBusqueda($id_categoria, 'DESC', $start_from, $num_rec_per_page, $busqueda);

        return $resultados;
    }

    /**
     * Funcion interna para listar los productos resultantes de la busqueda
     * @param string $categoria
     * @param string $orden
     * @param int $limitStart
     * @param int $limitEnd
     * @param string $busqueda
     * @return array listado de productos
     */
    private function getProductosBusqueda($categoria, $orden, $limitStart, $limitEnd, $busqueda) {
        $helper = new Helper();
        $listado = array();
        $item = '';
        $busq = preg_replace('/(\s|\+)+/s', ' + ', $busqueda);
        $busq_arr = explode(' + ', $busq);
        foreach ($busq_arr as $_ind => $_val) {
            switch (true) {
                case preg_match('/.{3,}[^e]s/', $_val):
                    $busq_arr[$_ind] = substr($_val, 0, -1);
                    break;
                case preg_match('/.{3,}es/', $_val):
                    $busq_arr[$_ind] = substr($_val, 0, -2);
                    break;
            }
        }
        #formateamos el Order BY
        if ($orden == 'RAND()') {
            $order = "ORDER BY RAND()";
        } else {
            $order = "ORDER BY p.id $orden";
        }
        #estado del producto
        $estado = 1;
        if ($categoria == 0) {
            $sql = "select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.estado = :estado ";
            $sql .= "AND p.nombre LIKE '%" . implode('%', $busq_arr) . "%' ";
            $sql .= "OR p.tags LIKE '%" . implode('%', $busq_arr) . "%' ";
            //$sql .= "OR descripcion LIKE '%" . implode('%', $busq_arr) . "%' ";
            //$sql .= "OR contenido LIKE '%" . implode('%', $busq_arr) . "%' ";
            $sql .= "$order LIMIT $limitStart,$limitEnd";
            $productos = $this->db->select($sql, array(':estado' => $estado));
        } else {
            $sql = "select p.*, m.descripcion as marca from producto p LEFT JOIN marca m on m.id = p.id_marca WHERE p.id_categoria IN (:categoria) ";
            $sql .= "AND p.estado = :estado ";
            $sql .= "AND p.nombre LIKE '%" . implode('%', $busq_arr) . "%' ";
            $sql .= "OR p.tags LIKE '%" . implode('%', $busq_arr) . "%' ";
            //$sql .= "OR descripcion LIKE '%" . implode('%', $busq_arr) . "%' ";
            //$sql .= "OR contenido LIKE '%" . implode('%', $busq_arr) . "%' ";
            $sql .= "$order LIMIT $limitStart,$limitEnd";
            $productos = $this->db->select($sql, array(':categoria' => $categoria, ':estado' => $estado));
        }
        if (!empty($productos)) {
            foreach ($productos as $producto) {
                $imagen = explode('|', $producto['imagen']);
                #el primer elemento siempre va a ser la imagen principal
                $imagen = $imagen[0];
                //guaranies
                if ($producto['id_moneda'] == 1) {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 0, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 0, ',', '.');
                    }
                    //dolares
                } else {
                    $moneda = $this->db->select("SELECT simbolo FROM moneda WHERE id = :idMoneda", array(':idMoneda' => $producto['id_moneda']));
                    $precio = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio'], 2, ',', '.');
                    if ($producto['precio_oferta'] != 0) {
                        $precio_oferta = $moneda[0]['simbolo'] . ' ' . number_format($producto['precio_oferta'], 2, ',', '.');
                    }
                }
                $item .='<li class="item col-lg-4 col-md-3 col-sm-4 col-xs-12">
                            <div class="col-item">';
                if ($producto['precio_oferta'] != 0)
                    $item .= '<div class="sale-label sale-top-right">Oferta</div>';
                if ($producto['nuevo'] == 1)
                    $item .= '<div class="new-label new-top-right">Nuevo</div>';
                $item .= '<div class="product-image-area"> <a class="product-image" title="' . $producto['nombre'] . '" href="' . $helper->urlProducto($producto['id']) . '"> <img src="' . IMAGE_PRODUCT . $imagen . '" class="img-responsive" alt="a" /> </a></div>
                                <div class="actions-links"><span class="add-to-links"> <a title="magik-btn-quickview" class="magik-btn-quickview" href="quick_view.html"><span>quickview</span></a> <a title="Add to Wishlist" class="link-wishlist" href="wishlist.html"><span>Add to Wishlist</span></a> <a title="Add to Compare" class="link-compare" href="compare.html"><span>Add to Compare</span></a></span> </div>
                                <div class="info">
                                    <div class="info-inner">
                                        <div class="item-title"> <a title=" Sample Product" href="' . $helper->urlProducto($producto['id']) . '"> ' . $producto['marca'] . ' - ' . $producto['nombre'] . ' </a> </div>
                                        <!--item-title-->
                                        <div class="item-content">
                                            <div class="ratings">
                                                <div class="rating-box">
                                                    ' . $helper->calcularValoracion($producto['id'], 1) . '
                                                </div>
                                            </div>
                                            <div class="price-box">';
                if ($producto['precio_oferta'] == 0) {
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
                                        <a href="' . URL . 'cart/agregar/' . $producto['id'] . '" type="button" title="Agregar al Carrito" class="button btn-cart"><span>Agregar al Carrito</span></a>
                                    </div>
                                    <!--actions-->

                                    <div class="clearfix"> </div>
                                </div>
                            </div>
                        </li>';
            }
            array_push($listado, $item);
        } else {
            $listado = array(
                'error' => '<h3><img src="' . IMAGES . 'signal.png" alt="">Oops! No se han encontrado resultados para su busqueda!</h3>');
        }
        return $listado;
    }

    public function share() {
        $redes = '';
        return $redes;
    }

    /**
     * Funcion que muestra todos los comentarios de un producto
     * @param int $idProducto
     * @return array con los comentarios de los clientes
     */
    public function getResenas($idProducto) {
        $helper = new Helper();
        $sqlResenas = $this->db->select("select po.valorizacion,
                                c.id as cliente,
				c.nombre,
				c.apellido,
				po.opinion,
				po.titulo,
				po.fecha_valorizacion
                        from producto_opinion po
                        LEFT JOIN cliente c on c.id = po.id_cliente
                        where id_producto = $idProducto
                        and po.aprobado = 1
                        ORDER BY po.id DESC
                        LIMIT 10"
        );
        $review = array();
        foreach ($sqlResenas as $item) {
            $idCliente = $item['cliente'];
            $resenas = '<li>
                        <table class="ratings-table">
                            <tbody>
                                <tr>
                                    <td>
                                        ' . $helper->calcularValoracion($idProducto, 1, $idCliente) . '
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="review">
                            <h6><a href="#/catalog/product/view/id/61/">' . $item{'titulo'} . '</a></h6>
                            <small>Reseña dejada por <span>' . $item['nombre'] . ' ' . $item['apellido'][0] . '</span> el ' . date('d-m-Y', strtotime($item['fecha_valorizacion'])) . ' </small>
                            <div class="review-txt">' . utf8_encode($item['opinion']) . '</div>
                        </div>
                    </li>';
            array_push($review, $resenas);
        }
        return $review;
    }

    public function verificaComentario($idProducto) {
        $idCliente = (!empty($_SESSION['cliente']['id'])) ? $_SESSION['cliente']['id'] : '';
        $sqlCompra = $this->db->select("select 	p.id,
				po.opinion 
                        from pedido p
                        LEFT JOIN pedido_detalle pe on pe.id_pedido = p.id
                        LEFT JOIN producto_opinion po on po.id_cliente = p.id_cliente and po.id_producto = pe.id_producto
                        where p.id_cliente = $idCliente
                        and pe.id_producto = $idProducto
                        and p.estado_pedido = 'Confirmado'
                        and p.estado_pago = 'Pago Confirmado'");
        $productosOpinion = array();
        foreach ($sqlCompra as $item) {
            array_push($productosOpinion, $item);
        }
        return $productosOpinion;
    }

    public function agregar_comentario($data) {
        $this->db->insert('producto_opinion', array(
            'id_cliente' => $data['id_cliente'],
            'id_producto' => $data['id_producto'],
            'valorizacion' => $data['valorizacion'],
            'opinion' => $data['opinion'],
            'fecha_valorizacion' => $data['fecha_valorizacion'],
            'titulo' => $data['titulo'],
            'aprobado' => $data['aprobado']
        ));
    }

    /**
     * Funcion que muestra las formas disponibles por producto
     */
    public function formasdePago() {
        $sqlPagos = $this->db->select("select descripcion, img from forma_pago where estado = 1");
    }

    /**
     * Funcion que inserta la solicitud de credito
     * @param array $datos
     */
    public function solicitud($datos) {
        $fecha = date('Y-m-d H:i:s');
        $this->db->insert('financiacion', array(
            'nombre' => $datos['nombre'],
            'email' => $datos['email'],
            'telefono' => $datos['telefono'],
            'cuotas' => $datos['cuotas'],
            'cantidad' => $datos['cantidad'],
            'monto_cuota' => $datos['monto_cuota'],
            'id_producto' => $datos['id_producto'],
            'fecha' => $fecha
        ));
    }

    public function liveVideo() {
        #incluimos el liveVideo
        require 'public/pluggins/youtube-live-embed/EmbedYoutubeLiveStreaming.php';
        $return = '';
        $YouTubeLive = new EmbedYoutubeLiveStreaming(CHANNELID, YOUTUBEAPIKEY);
        if (!$YouTubeLive->isLive) {
            $return .= "noLive";
        } else {
            $return .= $YouTubeLive->embed_code;
        }
        return $return;
    }

}
