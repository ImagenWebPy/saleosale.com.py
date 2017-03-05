<?php

class Cart_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion utilizada para agregar productos al carrito
     * @param array $datos
     * @param int $cantidad
     */
    public function agregar($datos, $cantidad = 1) {
        $helper = new Helper();
        $carrito = new Carrito();
        #array que crea un producto para agregarlo al carrito
        $imagen = explode('|', $datos['imagen']);
        #el primer elemento siempre va a ser la imagen principal
        $imagen = $imagen[0];
        #validamos la moneda para convertirla si dolares
        $moneda = $datos['id_moneda'];
        if ($moneda == 2) {
            $precio = $this->convertirMoneda($this->getPrecio($datos['precio'], $datos['precio_oferta']));
        } else {
            $precio = $this->getPrecio($datos['precio'], $datos['precio_oferta']);
        }
        $articulo = array(
            "id" => $datos['id'],
            "cantidad" => $cantidad,
            "precio" => $precio,
            "nombre" => $datos['nombre'],
            "imagen" => $imagen
        );
        #añadir el producto al carrito
        $carrito->add($articulo);

        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }

    /**
     * Funcion que retorna el precio del producto (Precio normal o el de la oferta)
     * @param float $precio
     * @param float $precioOferta
     * @return float precio del producto
     */
    private function getPrecio($precioSO, $precioOferta) {
        #verificamos que precio oferta no este vacio
        if ($precioOferta != 0) {
            $precio = $precioOferta;
        } else {
            $precio = $precioSO;
        }
        return $precio;
    }

    /**
     * Funcion utilizada para convertir la moneda dolares a guaranies
     * @param float $valor
     * @param int $idMoneda
     * @return float con el precio convertido
     */
    public function convertirMoneda($valor) {
        $precio = "";
        #siempre traemos la ultima cotizacion ingresada
        $cambio = $this->db->select("select cotizacion from cotizacion_moneda where fecha_cotizacion = (SELECT MAX(fecha_cotizacion) FROM cotizacion_moneda)");
        /**
         * convertimos la moneda a guaranies
         * tipo de cambio del dia por el precio
         */
        $precio = (float) $valor * (float) $cambio[0]['cotizacion'];
        return $precio;
    }

    /**
     * Funcion utilizada para eliminar un producto del carrito
     * @param int $unique_id
     */
    public function eliminar($unique_id) {
        $helper = new Helper();
        $carrito = new Carrito();

        #eliminamos el producto
        $carrito->remove_producto($unique_id);

        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }

    /**
     * Funcion que elimina todos los productos del carrito
     */
    public function borrarCarrito() {
        $helper = new Helper();
        $carrito = new Carrito();
        #eliminamos el carrito
        $carrito->destroy();
        #redireccionamos a la url desde la cual fue llamada el metodo
        header('location: ' . $helper->getUrlAnterior());
    }

    public function getAdrressClient($idCliente) {
        $result = $this->db->select("select * from direccion_cliente where id_cliente = :id_cliente", array(':id_cliente' => $idCliente));
        #recorremos las direcciones
        $adress = '';
        foreach ($result as $item) {
            #obtenemos el nombre de la ciudad
            $id_ciudad = $item['id_ciudad'];
            $ciudad = $this->db->select("select descripcion from ciudad where id = :id", array(':id' => $id_ciudad));
            $adress .= '
                        <option value="' . $item['id'] . '" selected="selected">' . utf8_encode($item['calle_principal']) . ' ' . utf8_encode($item['calle_lateral1']) . ' | ' . utf8_encode($item['barrio']) . ' - ' . utf8_encode($ciudad[0]['descripcion']) . '</option>';
        }
        $direcciones = $adress;
        return $direcciones;
    }

    /**
     * Funcion que retorna todos los metodos de pagos habilitados para la tienda
     * @return array
     */
    public function getPaymentsMethods() {
        $metodos = array();
        $habilitado = 1;
        $result = $this->db->select("select id, descripcion, icon from forma_pago where estado = :estado", array(':estado' => $habilitado));
        $metodo = '';
        foreach ($result as $item) {
            $metodo .= '<dt>
                            <input type="radio" value="' . $item['id'] . '" name="forma_pago" title="' . utf8_encode($item['descripcion']) . '" class="radio" id="radio_metodoPago' . $item['id'] . '">
                            <label for="forma_pago"><img src="' . IMAGES . $item["icon"] . '" style="width:35px;" /> ' . utf8_encode($item['descripcion']) . '</label>
                      </dt>';
            if ($item['id'] == 5) {
                $metodo .= '<div class="progress" id="progress_div">
                           <div class="bar" id="bar1"></div>
                            <div class="percent" id="percent1">0%</div>
                      </div>
                      <div id="output_image"></div>';
            }
            $metodo .= '<script type="text/javascript">
                        $(document).ready(function () {
                            $("#radio_metodoPago' . $item['id'] . '").change(function () {
                                if($("input:radio[name=forma_pago]:checked").val() == 5){
                                    $("#img-entrega").css("display","block");
                                    $("#btn-paso2").attr("onclick", "upload_image();");
                                }else{
                                    $("#img-entrega").css("display","none");
                                    $("#btn-paso2").attr("onclick", "");
                                }
                            });
                        });
                    </script>  
                    ';
        }
        array_push($metodos, $metodo);
        return $metodos;
    }

    /**
     * Funcion que retorna el resumen final con los productos del carrito
     * @return array con los productos del carrito
     */
    public function loadCartReview() {
        $carrito = new Carrito();
        $helper = new Helper();
        $resumen = array();
        $contenido = $carrito->get_content();
        $filas = '';
        foreach ($contenido as $item) {
            $filas .= '<tr class="first odd">
                            <td class="image"><a class="product-image" href="' . $helper->urlProducto($item['id']) . '"><img width="75" alt="' . $item['imagen'] . '" src="' . IMAGE_PRODUCT . $item['imagen'] . '"></a></td>
                            <td><h3 class="product-name"> <a href="' . $helper->urlProducto($item['id']) . '">' . $item['nombre'] . '</a> </h3></td>
                            <td class="a-center">&nbsp;</td>
                            <td class="a-right"><span class="cart-price"> <span class="price">' . $helper->getUnitPrice($item['id'], $item['cantidad']) . '</span> </span></td>
                            <td class="a-center movewishlist"><input maxlength="12" class="input-text qty" title="Cant." size="4" value="' . $item['cantidad'] . '"></td>
                            <td class="a-right movewishlist"><span class="cart-price"> <span class="price">' . $helper->getPrecioTotalItem($item['precio'], $item['cantidad']) . '</span> </span></td>
                            <td class="a-center last"><a class="button remove-item" title="Remove item" href="' . URL . 'cart/eliminar/' . $item['unique_id'] . '"><span><span>Remover Producto</span></span></a></td>
                        </tr>';
        }
        array_push($resumen, $filas);
        return $resumen;
    }

    /**
     * Funcion que retorna el costo de envio de la ciudad seleccionada para
     * el envio del pedido
     * @return float costo de envio
     */
    public function getCostoEnvio() {
        $costo = (float) 0;
        $id = $_SESSION['checkout']['id_direccion_cliente'];
        $result = $this->db->select("select ce.costo from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad LEFT JOIN costo_envio ce on ce.id = c.id_costo_envio where dc.id = :id", array(':id' => $id));
        $costo = $result[0]['costo'];
        return $costo;
    }

    /**
     * Funcion que retorna la sumatoria de precios de todos los productos que han sido
     * añadidos al carrito
     * @return float sumatoria de todos los precios de productos añadidos al carrito
     */
    public function getSubTotal() {
        $subTotal = (float) 0;
        $carrito = new Carrito();
        $articulos = $carrito->get_content();
        foreach ($articulos as $item) {
            $subTotal += $item['precio'] * $item['cantidad'];
        }
        return $subTotal;
    }

    /**
     * Funcion que retorna el resumen del proceso de compra
     * @return string resumen 
     */
    public function suPedido() {
        $helper = new Helper();
        $carrito = new Carrito();
        $resumen = '';
        $resumen .= '<div class="block block-progress">
                        <div class="block-title ">Su Pedido</div>
                        <div class="block-content">
                            <dl>';
        if (!empty($_SESSION['checkout'])) {
            if (!empty($_SESSION['checkout']['id_direccion_cliente'])) {
                $id_direccion_cliente = $_SESSION['checkout']['id_direccion_cliente'];
                $dir = $this->db->select("select dc.barrio, dc.calle_principal, dc.calle_lateral1, dc.telefono, c.descripcion as ciudad from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad where dc.id = $id_direccion_cliente");
                $resumen .= '<dt class="complete"> Dirección de envío </dt>
                                <dd class="complete">
                                    <address>
                                        ' . utf8_encode($dir[0]['calle_principal']) . '<br>
                                        ' . utf8_encode($dir[0]['calle_lateral1']) . '<br>
                                        ' . utf8_encode($dir[0]['barrio']) . ' - ' . utf8_encode($dir[0]['ciudad']) . '<br>
                                        ' . $dir[0]['telefono'] . '<br>
                                    </address>
                                </dd>';
            }
            if (!empty($_SESSION['checkout']['forma_pago'])) {
                $id_forma_pago = $_SESSION['checkout']['forma_pago'];
                $pago = $this->db->select("select descripcion from forma_pago where id = $id_forma_pago");
                $resumen .= '<dt class="complete"> Forma de Pago </dt>
                                <dd class="complete">
                                    <address>
                                        ' . utf8_encode($pago[0]['descripcion']) . '
                                    </address>
                                </dd>
                                <dd><hr></dd>
                                <dd class="complete">
                                Sub Total: ' . $helper->getPrecioCarrito($this->getSubTotal()) . ' <br>
                                
                                Total: <span class="price">' . $helper->getPrecioCarrito($carrito->precio_total()) . '</span> </dd>';
            }
        }
        $resumen .= ' </dl>

                        </div>
                    </div>';
        return $resumen;
    }

    /**
     * Funcion que inserta los datos de la compra realizada en la BD
     */
    public function insertCompra() {
        #definimos la hora de Paraguay
        date_default_timezone_set('America/Asuncion');
        #datos para la cabecera del pedido
        $id_cliente = $_SESSION['cliente']['id'];
        //$id_direccion_cliente = $_SESSION['checkout']['id_direccion_cliente'];
        $id_forma_pago = $_SESSION['checkout']['forma_pago'];
        $id_cotizacion_moneda = $_SESSION['checkout']['id_cotizacion_moneda'];
        $fecha_pedido = date('Y-m-d H:i:s');
        $monto_pedido = $_SESSION['checkout']['monto_pedido'];
        $monto_envio = $_SESSION['checkout']['monto_envio'];
        $monto_descuento = $_SESSION['checkout']['monto_descuento'];
        $monto_total = $_SESSION['carrito']['precio_total'];
        $observacion_pedido = $_SESSION['checkout']['observacion_pedido'];
        $estado_pedido = 'Confirmado';
        $estado_pago = 'Pendiente';
        $helper = new Helper();
        #buscamos las latitudes de la direccion seleccioanada
        //$coordenada = $this->db->select("select map_latitude, map_longitude, map_zoom from direccion_cliente where id = $id_direccion_cliente");
        #insertamos los datos del pedido
        $this->db->insert('pedido', array(
            'id_cliente' => $id_cliente,
            //'id_direccion_cliente' => $id_direccion_cliente,
            'id_forma_pago' => $id_forma_pago,
            'id_cotizacion_moneda' => $id_cotizacion_moneda,
            'fecha_pedido' => $fecha_pedido,
            'monto_pedido' => $monto_pedido,
            'monto_envio' => $monto_envio,
            'monto_descuento' => $monto_descuento,
            'monto_total' => $monto_total,
            'observacion_pedido' => $observacion_pedido,
            'estado_pedido' => $estado_pedido,
            'estado_pago' => $estado_pago,
                //'map_latitude' => $coordenada[0]['map_latitude'],
                //'map_longitude' => $coordenada[0]['map_longitude'],
                //'map_zoom' => $coordenada[0]['map_zoom']
        ));
        #detalle del pedido
        $id_pedido = $this->db->lastInsertId('id');
        $carrito = new Carrito();
        $carro = $carrito->get_content();
        #session del cupon
        Session::set('cupon', array(
            'datos' => array()
        ));
        foreach ($carro as $producto) {
            $idProducto = $producto["id"];
            $cantidad = $producto["cantidad"];
            $this->db->insert('pedido_detalle', array(
                'id_pedido' => $id_pedido,
                'id_producto' => $idProducto,
                'cantidad' => $cantidad,
                'precio' => $producto["precio"]
            ));
            $lastID = $this->db->lastInsertId();
            #obtenemos el id del cupon
            $id = $this->db->select("SELECT id, fecha_sorteo FROM cupon WHERE id_producto = $idProducto and fecha_finalizacion >= NOW() and estado = 'ACTIVO'");
            #INSERTAMOS EN LA TABLA CUPON la cantSELECT id FROM cupon WHERE id_producto = $idProducto and fecha_finalizacion >= NOW() and estado = 'ACTIVO'idad de veces que se compro

            for ($i = 1; $i <= $cantidad; $i++) {
                $nroCupon = $this->getCuponNumber($id[0]['id']);
                if ($nroCupon == 1) {
                    #numero cupon = fecha_sorteo + id_producto + 0000 + 1
                    $nroC = $idProducto . '00000' . $nroCupon;
                } else {
                    $nroC = $nroCupon;
                }
                $this->db->insert('cupon_cliente', array(
                    'id_cupon' => $id[0]['id'],
                    'id_cliente' => $id_cliente,
                    'fecha_compra' => date('Y-m-d H:i:s'),
                    'nro_cupon' => $nroC,
                    'id_pedido' => $id_pedido,
                    'estado' => 'FALTA PAGO',
                    'id_pedido_detalle' =>$lastID
                ));
                array_push($_SESSION['cupon']['datos'], array(
                    'id_producto' => $idProducto,
                    'nro_cupon' => $nroC
                ));
            }
        }

        #insertamos la imagen de canje si esta cargada
        $imgCanje = (!empty($_SESSION['checkout']['img_canje'])) ? $_SESSION['checkout']['img_canje'] : '';
        if (!empty($imgCanje)) {
            $postData = array(
                'img_canje' => $id_pedido . '_' . $imgCanje
            );
            $this->db->update('pedido', $postData, "`id` = {$id_pedido}");
            #renombramos el archivo
            rename(IMAGE_CANJE . $imgCanje, IMAGE_CANJE . $id_pedido . '_' . $imgCanje);
        }
        #guardamos los datos del pedido para enviarlos por mail
        Session::set('pedido_finalizado', array(
            'id' => $id_pedido,
            'fecha' => $fecha_pedido
        ));
    }

    /**
     * Funcion que obtiene el ultimo nro del cupon generado para ese producto y le suma 1
     * @param int $idCupon
     * @return int
     */
    private function getCuponNumber($idCupon) {
        $cupon = $this->db->select("select nro_cupon
                                        from cupon_cliente
                                        WHERE id_cupon = $idCupon
                                        ORDER BY id desc limit 1");
        if (!empty($cupon[0]['nro_cupon'])) {
            $nro = $cupon[0]['nro_cupon'] + 1;
        } else {
            $nro = 1;
        }
        return $nro;
    }

}
