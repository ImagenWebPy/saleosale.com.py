<?php

class Cliente_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion para obtener las ordenes recientes del cliente
     * @param int $limit
     * @return array con las ordenes recientes
     */
    public function getRecentOrdes($limit = 5) {
        $orders = array();
        $id_cliente = (int) $_SESSION['cliente']['id'];
        $ordenes = $this->db->select("SELECT p.id, p.fecha_pedido, CONCAT_WS(' ',dc.calle_principal,dc.calle_lateral1) as direccion, dc.barrio, c.descripcion as ciudad, p.monto_total, p.estado_pago, p.estado_pedido FROM pedido p LEFT JOIN direccion_cliente dc on dc.id = p.id_direccion_cliente LEFT JOIN ciudad c on c.id = dc.id_ciudad where p.id_cliente = :id_cliente ORDER BY id DESC LIMIT $limit", array(':id_cliente' => $id_cliente));
        $orders = $ordenes;
        return $orders;
    }

    /**
     * Funcion que retorna los datos de la direccion principal del cliente
     * @return array con la direccion principal
     */
    public function getMainDirection() {
        $helper = new Helper();
        $direccion = '';
        $id_cliente = (int) $_SESSION['cliente']['id'];
        $predeterminada = 1;
        $result = $this->db->select("SELECT dc.*, c.descripcion as ciudad from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad where dc.id_cliente = :id_cliente and dc.predeterminada = :predeterminada LIMIT 1", array(':id_cliente' => $id_cliente, ':predeterminada' => $predeterminada));
        if (!empty($result)) {
            $direccion = '<address>
                        ' . utf8_encode($result[0]['calle_principal']) . '<br>
                        ' . utf8_encode($result[0]['calle_lateral1']) . '<br>
                        ' . utf8_encode($result[0]['barrio']) . ' - ' . utf8_encode($result[0]['ciudad']) . '<br>
                        T: ' . $result[0]['telefono'] . ' <br>
                        <a href="' . URL . '/cliente/editar_direccion/' . $result[0]['id'] . '">Editar Dirección</a>
                    </address>';
        } else {
            $direccion = $helper->messageAlert('info', 'Aún no has cargado ninguna dirección de envío.');
        }
        return $direccion;
    }

    /**
     * Funcion que retorna el sidebar de navegacion del cliente
     * @param array $pagina
     * @return string con el sidebar de cliente
     */
    public function acountSidebar($pagina) {
        $seccion = $pagina[1];
        $panel = '';
        $cuenta = '';
        $direccion = '';
        $compras = '';
        $revisiones = '';
        $lista = '';
        $newsletter = '';
        $subasta = '';
        switch ($seccion) {
            case 'dashboard':
                $panel = 'class="current"';
                break;
            case 'direcciones':
            case 'agregarDireccion':
            case 'editar_direccion':
                $direccion = 'class="current"';
                break;
            case 'cuenta':
                $cuenta = 'class="current"';
                break;
            case 'compras':
                $compras = 'class="current"';
                break;
            case 'revisiones':
                $revisiones = 'class="current"';
                break;
            case 'lista_deseos':
                $lista = 'class="current"';
                break;
            case 'newsletter':
                $newsletter = 'class="current"';
                break;
            case 'subasta':
                $subasta = 'class="current"';
                break;
        }
        $aside = '<aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
                <div class="block block-account">
                    <div class="block-title">Mi Cuenta</div>
                    <div class="block-content">
                        <ul>
                            <li ' . $panel . ' ><a href="' . URL . 'cliente/dashboard/">Panel de la Cuenta</a></li>
                            <li ' . $cuenta . ' ><a href="' . URL . 'cliente/cuenta/">Informacion de la Cuenta</a></li>
                            <!--<li ' . $direccion . ' ><a href="' . URL . 'cliente/direcciones/">Direcciones</a></li>-->
                            <li ' . $compras . ' ><a href="' . URL . 'cliente/compras/">Mis Cupones</a></li>
                            <!--<li ' . $revisiones . ' ><a href="' . URL . 'cliente/revisiones/">Mis Revisiones</a></li>-->
                            <!--<li ' . $lista . ' ><a href="' . URL . 'cliente/lista_deseos/">Mi Lista de Deseos</a></li>-->
                            <li ' . $newsletter . ' ><a href="' . URL . 'cliente/newsletter/">Subscripción al Newsletter</a></li>
                            <!--<li ' . $subasta . ' class="btn btn-success btn-block"><a href="' . URL . 'cliente/subasta/" style=" color: #fff; font-weight:bold;">Subasta</a></li>-->
                        </ul>
                    </div>
                </div>
            </aside>';
        return $aside;
    }

    /**
     * Función que retorna el lisrado de las direcciones ingresadas por el cliente
     * @return array con el listado de direcciones del cliente
     */
    public function getAllDirections() {
        $direcciones = array();
        $id_cliente = (int) $_SESSION['cliente']['id'];
        $result = $this->db->select("SELECT dc.id, dc.barrio, dc.calle_principal,dc.calle_lateral1,dc.telefono,dc.map_latitude, dc.map_longitude, c.descripcion as ciudad from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad where dc.id_cliente = $id_cliente");
        $var = '';
        foreach ($result as $item) {
            $var .='<tr class="first odd">
                                            <td class="wishlist-cell1 customer-wishlist-item-info"><h3 class="product-name"><a title="" href="product_detail.html">' . utf8_encode($item['barrio']) . ' ' . utf8_encode($item['ciudad']) . '</a></h3>
                                                <div class="description std">
                                                    <div class="inner">' . utf8_encode($item['calle_principal']) . ' ' . utf8_encode($item['calle_lateral1']) . ' </div>
                                                </div>
                                                <div class="description std">
                                                    <div class="inner">' . $item['telefono'] . ' </div>
                                                </div>
                                            <td class="wishlist-cell4 customer-wishlist-item-cart">
                                                <div class="edit-bnt">
                                                    <a href="' . URL . 'cliente/editar_direccion/' . $item['id'] . '" class="">Editar</a>
                                                </div>
                                            </td>
                                        </tr>';
        }
        array_push($direcciones, $var);
        return $direcciones;
    }

    /**
     * Funcion que retorna el listado de departamentos
     * @return type
     */
    public function loadDepartamentos() {
        $estado = 1;
        $departamentos = array();
        $result = $this->db->select("select id, descripcion from departamento where estado = :estado ", array(':estado' => $estado));
        $departamentos = $result;
        return $departamentos;
    }

    /**
     * Funcion que retorna el listado de departamentos
     * @return type
     */
    public function loadDepartamentosEdit($idDireccion) {
        $estado = 1;
        $descDepartamento = $this->db->select("select d.id, d.descripcion from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad LEFT JOIN departamento d on d.id = c.id_departamento where dc.id = $idDireccion");
        $id_departamento = (int) $descDepartamento[0]['id'];
        $departamentos = array();
        $result = $this->db->select("select id, descripcion from departamento where estado = :estado and id != :id", array(':estado' => $estado, ':id' => $id_departamento));
        $departamentos = $result;
        return $departamentos;
    }

    /**
     * Funcion que retorna el departamento cargado en la BD que fue seleccionado para editar
     * @param int $idDireccion
     * @return array
     */
    public function loadSelectedDepartamento($idDireccion) {
        $descDepartamento = $this->db->select("select d.id, d.descripcion from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad LEFT JOIN departamento d on d.id = c.id_departamento where dc.id = $idDireccion");
        $departamento = array(
            'id' => $descDepartamento[0]['id'],
            'descripcion' => $descDepartamento[0]['descripcion']
        );
        return $departamento;
    }

    /**
     * Funcion que retorna la ciudad cargada en la BD que fue seleccionada para editar
     * @param int $idDireccion
     * @return array
     */
    public function loadSelectedCiudad($idDireccion) {
        $descDepartamento = $this->db->select("select c.id, c.descripcion from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad where dc.id = $idDireccion");
        $ciudad = array(
            'id' => $descDepartamento[0]['id'],
            'descripcion' => $descDepartamento[0]['descripcion']
        );
        return $ciudad;
    }

    /**
     * Funcion que imprime el listado de ciudades de acuerdo al departamento
     */
    public function getCities() {
        $id_departamento = (int) $_POST['id'];
        $estado = 1;
        $result = $this->db->select("select id, descripcion from ciudad where id_departamento = :id_departamento and estado = :estado", array(':id_departamento' => $id_departamento, ':estado' => $estado));
        $cant = count($result);
        $cant = $cant - 1;
        $ciudades = '';
        for ($i = 0; $i <= $cant; $i++) {
            $ciudades .= '<option value="' . $result[$i]['id'] . '">' . utf8_encode($result[$i]['descripcion']) . '</option>';
        }
        echo $ciudades;
    }

    /**
     * Funcion que inserta una nueva direccion
     */
    public function crearDireccion($data) {
        $this->db->insert('direccion_cliente', array(
            'id_cliente' => $data['id_cliente'],
            'id_ciudad' => $data['id_ciudad'],
            'barrio' => $data['barrio'],
            'telefono' => $data['telefono'],
            'calle_principal' => $data['calle_principal'],
            'calle_lateral1' => $data['calle_lateral1'],
            'telefono' => $data['telefono'],
            'tipo_vivienda' => $data['tipo_vivienda'],
            'predeterminada' => $data['predeterminada'],
            'map_latitude' => $data['latitude'],
            'map_longitude' => $data['longitude']
        ));
    }

    /**
     * Funcion que retorna los datos del cliente para editarlos
     * @param int $id
     * @return array con los datos del cliente
     */
    public function getClientData($id) {
        $datos = array();
        $result = $this->db->select("select td.descripcion as tipo_documento,id_tipo_documento, c.id_tipo_documento, c.nombre, c.apellido, c.documento_nro, c.telefono, c.celular, c.fecha_registro, c.email from cliente c LEFT JOIN tipo_documento td on td.id = c.id_tipo_documento where c.id = $id");
        Session::set('client_data', array(
            'nombre' => $result[0]['nombre'],
            'apellido' => $result[0]['apellido'],
            'id_tipo_documento' => $result[0]['id_tipo_documento'],
            'tipo_documento' => $result[0]['tipo_documento'],
            'documento_nro' => $result[0]['documento_nro'],
            'telefono' => $result[0]['telefono'],
            'celular' => $result[0]['celular'],
            'fecha_registro' => $result[0]['fecha_registro'],
            'email' => $result[0]['email']
        ));
        return $datos;
    }

    /**
     * Funcion que retorna el select box armado de los tipos de documentos
     * @return array
     */
    public function getTiposDocumentos($id_tipo_documento) {
        $datos = array();
        $documentos = $this->db->select("Select * from tipo_documento where id != $id_tipo_documento");
        $id_tipo = $_SESSION['client_data']['id_tipo_documento'];
        $tipo_descripcion = $_SESSION['client_data']['tipo_documento'];
        $select = '<select name="cliente[documento_tipo]" class="input-sm required-entry selectbox" required>';
        $select .= ' <option value="' . $id_tipo . '">' . $tipo_descripcion . '</option>';
        foreach ($documentos as $item) {
            $select .= ' <option value="' . $item['id'] . '">' . utf8_encode($item['descripcion']) . '</option>';
        }
        $select .= '</select>';
        $datos = $select;
        return $datos;
    }

    /**
     * Funcion que actualiza los datos de la cuenta del cliente
     * @param array $data
     */
    public function updateClientData($data) {
        $datos = array(
            'id_tipo_documento' => $data['documento_tipo'],
            'nombre' => $data['nombre'],
            'apellido' => $data['apellido'],
            'documento_nro' => $data['documento_nro'],
            'telefono' => $data['telefono'],
            'celular' => $data['celular'],
            'email' => $data['email']
        );
//$id = $data['id_cliente'];
        $id = $_SESSION['cliente']['id'];
        $this->db->update('cliente', $datos, "`id` = $id");
    }

    /**
     * Funcion que actualiza la contraseña del cliente
     * @param array $data
     */
    public function cambiarPass($data) {
        $datos = array(
            'contrasena' => Hash::create('sha256', $data['pass1'], HASH_PASSWORD_KEY)
        );
        $id = $_SESSION['cliente']['id'];
        $this->db->update('cliente', $datos, "`id` = $id");
    }

    /**
     * Funcion que retorna los datos de la direccion del cliente a editar
     * @param int $idDireccion
     */
    public function datosDireccion($idDireccion) {
        $direccion = $this->db->select("SELECT dc.id, dc.barrio, dc.id_ciudad, dc.calle_principal,dc.calle_lateral1,dc.telefono,dc.map_latitude, dc.map_longitude, c.descripcion as ciudad, dc.predeterminada, dc.tipo_vivienda from direccion_cliente dc LEFT JOIN ciudad c on c.id = dc.id_ciudad where dc.id = $idDireccion");
        Session::set('datos_dir', array(
            'id' => $direccion[0]['id'],
            'barrio' => $direccion[0]['barrio'],
            'calle_principal' => $direccion[0]['calle_principal'],
            'calle_lateral1' => $direccion[0]['calle_lateral1'],
            'telefono' => $direccion[0]['telefono'],
            'map_latitude' => $direccion[0]['map_latitude'],
            'map_longitude' => $direccion[0]['map_longitude'],
            'id_ciudad' => $direccion[0]['id_ciudad'],
            'predeterminada' => $direccion[0]['predeterminada'],
            'tipo_vivienda' => $direccion[0]['tipo_vivienda'],
            'ciudad' => $direccion[0]['ciudad']));
    }

    /**
     * Funcion que retorna el select con el tipo de vivienda seleccionada
     * @param int $idDireccion
     * @return string con el select armado
     */
    public function tipoVivienda($idDireccion) {
        $tipo = $this->db->select("select tipo_vivienda from direccion_cliente where id = $idDireccion");
        $tipoVivienda = $tipo[0]['tipo_vivienda'];
        if ($tipoVivienda == 'Particular') {
            $vivienda = '<select class="form-control" name="direccion[tipo_vivienda]">
                            <option value="Particular">Particular</option>
                            <option value="Laboral">Laboral</option>
                        </select>';
        } else {
            $vivienda = '<select class="form-control" name="direccion[tipo_vivienda]">
                            <option value="Laboral">Laboral</option>
                            <option value="Particular">Particular</option>
                        </select>';
        }
        return $vivienda;
    }

    /**
     * Funcion que actualiza los datos enviados desde el formuario de editar direecion
     * del cliente
     */
    public function editarDireccion($data) {
        $latidude = $data['latitude'];
        $longitude = $data['longitude'];
        if ((!empty($latidude)) && (!empty($longitude))) {
            $datos = array(
                'id_departamento' => $data['id_departamento'],
                'id_ciudad' => $data['id_ciudad'],
                'barrio' => $data['barrio'],
                'calle_principal' => $data['calle_principal'],
                'calle_lateral1' => $data['calle_lateral1'],
                'telefono' => $data['telefono'],
                'tipo_vivienda' => $data['tipo_vivienda'],
                'predeterminada' => $data['predeterminada'],
                'latitude' => $latidude,
                'longitude' => $longitude,
            );
        } else {
            $datos = array(
                'id_ciudad' => $data['id_ciudad'],
                'barrio' => $data['barrio'],
                'calle_principal' => $data['calle_principal'],
                'calle_lateral1' => $data['calle_lateral1'],
                'telefono' => $data['telefono'],
                'tipo_vivienda' => $data['tipo_vivienda'],
                'predeterminada' => $data['predeterminada']
            );
        }
        $id = $data['id_direccion'];

        $this->db->update('direccion_cliente', $datos, "`id` = $id");
    }

    /**
     * Funcion que retorna los datos de la orden del cliente
     * @param int $idOrden
     * @return array con los datos del pedido
     */
    public function cargarDatosOrden($idOrden) {
        $orden = array();
        $result = $this->db->select("SELECT pe.monto_total, pe.monto_pedido, pe.monto_envio, pd.cantidad, p.nombre, pd.precio, p.imagen, p.id as id_producto, pe.estado_pago, pe.estado_pedido, pe.fecha_pedido, pe.fecha_pedido, pe.fecha_pago from pedido pe LEFT JOIN pedido_detalle pd on pd.id_pedido = pe.id LEFT JOIN producto p on p.id = pd.id_producto where pe.id = $idOrden");
        $orden = array(
            'monto_total' => $result[0]['monto_total'],
            'monto_pedido' => $result[0]['monto_pedido'],
            'monto_envio' => $result[0]['monto_envio'],
            'estado_pago' => $result[0]['estado_pago'],
            'estado_pedido' => $result[0]['estado_pedido'],
            'fecha_pedido' => $result[0]['fecha_pedido'],
            'fecha_pago' => $result[0]['fecha_pago'],
            'productos' => array()
        );
        foreach ($result as $item) {
            array_push($orden['productos'], array(
                'cantidad' => $item['cantidad'],
                'nombre' => $item['nombre'],
                'precio' => $item['precio'],
                'imagen' => $item['imagen'],
                'id_producto' => $item['id_producto']));
        }
        return $orden;
    }

    /**
     * Funcion para obtener todas las ordenes del cliente
     * @param int $limit
     * @return array con las ordenes recientes
     */
    public function getOrders() {
        $orders = array();
        $id_cliente = (int) $_SESSION['cliente']['id'];
        $ordenes = $this->db->select("SELECT p.id, p.fecha_pedido, CONCAT_WS(' ',dc.calle_principal,dc.calle_lateral1) as direccion, dc.barrio, c.descripcion as ciudad, p.monto_total, p.estado_pago, p.estado_pedido FROM pedido p LEFT JOIN direccion_cliente dc on dc.id = p.id_direccion_cliente LEFT JOIN ciudad c on c.id = dc.id_ciudad where p.id_cliente = $id_cliente ORDER BY id DESC");
        $orders = $ordenes;
        return $orders;
    }

    /**
     * Funcion que verifica si el cliente existe en la tabla newsletter
     * @return array con los datos del cliente si no existe en la tabla newsletter
     */
    public function getSuscripcion() {
        $datos = array();
        $email_s = $_SESSION['cliente']['email'];
        $nombre_completo = $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'];
        $result = $this->db->select("select email from newsletter where email = '$email_s' and estado = 1");
        $email = (!empty($result)) ? $result[0]['email'] : '';
        if (empty($email)) {
            $datos = array(
                'existe' => 0,
                'email' => $_SESSION['cliente']['email'],
                'nombre_completo' => $nombre_completo
            );
        } else {
            $datos = array(
                'email' => $_SESSION['cliente']['email'],
                'existe' => 1
            );
        }
        return $datos;
    }

    /**
     * Funcion que verifica e actualiza la suscripcion al newsletter
     * @param array $datos
     */
    public function verificaNewsletter($datos) {
        $helper = new Helper();
        $existe = $datos['existe'];
        $email = $datos['email'];
        $nombre_completo = $datos['nombre_completo'];
        if (($existe == 1) && ($nombre_completo == '')) {
#damos de baja al cliente
            $data = array(
                'estado' => 0
            );
            $this->db->update('newsletter', $data, "email = '$email'");
            Session::set('message', array(
                'type' => 'danger',
                'mensaje' => 'Ha cancelado satisfactoriamente su suscripción a nuestro newsletter. '));
#redireccionamos
            header('location: ' . $helper->getUrlAnterior());
            exit();
        } else if (($existe == 0) && ($nombre_completo != '')) {
#verificamos si el email ya existe
            $result = $this->db->select("select email from newsletter where email = '$email'");
            $existe = (!empty($result)) ? 1 : 0;
            if ($existe == 1) {
#Actualizamos el estado del cliente
                $data = array(
                    'estado' => 1
                );
                $this->db->update('newsletter', $data, "email = '$email'");
                header('location: ' . $helper->getUrlAnterior());
                exit();
            } else {
#Insertamos un nuevo registro
                $this->db->insert('newsletter', array(
                    'nombre_completo' => $nombre_completo,
                    'email' => $email,
                    'estado' => 1
                ));
            }
            Session::set('message', array(
                'type' => 'success',
                'mensaje' => 'Se ha suscripto a nuestro newsletter. ¡Muchas Gracias!'));
        }
    }

    /**
     * Funcion que agrega un producto a la lsta de deseo del cliente,
     * primer verifica si el producto ya existe en la lista.
     * @param int $idCliente
     * @param int $idProducto
     * @return boolean
     */
    public function agregarListaDeseo($idCliente, $idProducto) {
        $deseo = false;
        $fecha = date('Y-m-d H:i:s');
#verificamos si el producto existe en la lista
        $verifica = $this->db->select("select id_cliente from lista_deseo where id_cliente = $idCliente and id_producto = $idProducto");
        if (empty($verifica)) {
#insertamos el producto en la lista
            $this->db->insert('lista_deseo', array(
                'id_cliente' => $idCliente,
                'id_producto' => $idProducto,
                'fecha_add' => $fecha
            ));
            $deseo = true;
        }
        return $deseo;
    }

    /**
     * Funcion que retorna los productos de la lista de deseos
     * @return array con la lista de deseos
     */
    public function loadLista() {
        $idCliente = $_SESSION['cliente']['id'];
        $result = $this->db->select("SELECT ld.id_producto, p.nombre, p.precio, p.imagen from lista_deseo ld LEFT JOIN producto p on p.id = ld.id_producto where ld.id_cliente = $idCliente");
        $datos = array();
        foreach ($result as $item) {
            $imagenes = explode('|', $item['imagen']);
            array_push($datos, array(
                'id_producto' => $item['id_producto'],
                'nombre' => $item['nombre'],
                'precio' => $item['precio'],
                'imagen' => array_shift($imagenes)
            ));
        }
        return $datos;
    }

    /**
     * Funcion que elimina el producto de la lista de deseos del cliente
     * @param int $idCliente
     * @param int $idProducto
     */
    public function removeProductoFromList($idCliente, $idProducto) {
        $this->db->delete("lista_deseo", "id_cliente = $idCliente and id_producto = $idProducto");
    }

    public function cargarSubastas($id_cliente) {
        $subastas = array();
        $sqlDatos = $this->db->select("select s.id,
			s.oferta_minima,
			s.fecha_inicio,
			s.fecha_fin,
			s.condicion,
			s.estado,
			sp.nombre as producto,
			sp.imagen,
			sp.marca,
			sp.descripcion_corta
                    from subasta s
                    LEFT JOIN subasta_producto sp on sp.id_subasta = s.id
                    where s.id_cliente = $id_cliente");
        foreach ($sqlDatos as $item) {
            $css = $this->estadoSubasta($item['id']);
            array_push($subastas, array(
                'id' => $item['id'],
                'oferta_minima' => $item['oferta_minima'],
                'fecha_inicio' => $item['fecha_inicio'],
                'fecha_fin' => $item['fecha_fin'],
                'condicion' => $item['condicion'],
                'estado' => utf8_encode($item['estado']),
                'producto' => $item['producto'],
                'imagen' => $item['imagen'],
                'marca' => $item['marca'],
                'descripcion_corta' => $item['descripcion_corta'],
                'css' => $css,
                'ofertas' => $this->getOfertasSubasta($item['id'])
            ));
        }
        return $subastas;
    }

    private function estadoSubasta($idSubasta) {
        $sqlGetEstado = $this->db->select("select estado from subasta WHERE id = $idSubasta");
        $estado = utf8_encode($sqlGetEstado[0]['estado']);
        $css = '';
        switch ($estado) {
            case 'Revisión':
                $css = 'revision';
                break;
            case 'Habilitada':
                $css = 'habilitada';
                break;
            case 'Deshabilitada':
                $css = 'deshabilitada';
                break;
            case 'Incumple':
                $css = 'incumple';
                break;
            case 'Finalizada':
                $css = 'finalizada';
                break;
        }
        return $css;
    }

    public function getOfertasSubasta($idSubasta) {
        $ofertas = array();
        $sqlOfertas = $this->db->select("select so.monto_oferta,
                                                so.fecha_oferta,
                                                CONCAT_WS(' ',c.nombre, c.apellido) as cliente
                                        from subasta_oferta so 
                                        LEFT JOIN cliente c on c.id = so.id_cliente
                                        where id_subasta = $idSubasta
                                        ORDER BY so.fecha_oferta DESC
                                        LIMIT 3");

        foreach ($sqlOfertas as $item) {
            array_push($ofertas, array(
                'monto_oferta' => $item['monto_oferta'],
                'fecha_oferta' => $item['fecha_oferta'],
                'cliente' => $item['cliente']
            ));
        }
        return $ofertas;
    }

    public function addNewSubasta($datos) {
        $helper = new Helper();
        $this->db->insert('subasta', array(
            'id_cliente' => $datos['id_cliente'],
            'oferta_minima' => $datos['oferta_minima'],
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin'],
            'condicion' => $datos['condicion'],
            'estado' => utf8_encode($datos['estado']),
            'fecha_creacion' => date('Y-m-d H:i:s')
        ));
        $id_subasta = $this->db->lastInsertId();
        $this->db->insert('subasta_producto', array(
            'id_subasta' => $id_subasta,
            'marca' => $datos['marca'],
            'nombre' => $datos['nombre'],
            'descripcion_corta' => $datos['descripcion_corta'],
            'contenido' => $datos['contenido'],
            'imagen' => $datos['imagen'],
            'id_moneda' => 1
        ));
        $mensaje = array(
            'id_subasta' => $id_subasta,
            'marca' => $datos['marca'],
            'nombre' => $datos['nombre'],
            'imagen' => $datos['imagen'],
            'fecha_inicio' => $datos['fecha_inicio'],
            'fecha_fin' => $datos['fecha_fin'],
            'oferta_minima' => $datos['oferta_minima'],
            'condicion' => $datos['condicion'],
        );
        #enviamos el mail de confirmacion
        $destinatario = $_SESSION['cliente']['email'];
        $asunto = '¡Su subasta ha sido cargada con éxito!';
        $helper->sendMail($destinatario, $asunto, 'subasta[finalizada]', $mensaje, $destinatarioNombre);
        $adminEmails = $helper->getEmailsAdmin('SUBASTA');
        $asuntoAdmin = 'Se ha agregado una nueva Subasta desde el sitio web';
        $destinatarioAdmin = 'SaleoSale Web';
        $helper->sendMail($adminEmails, $asuntoAdmin, 'subasta[admin]', $mensaje, $destinatarioAdmin);
    }

    public function getDatosSubasta($idSubasta) {
        $sqlDatos = $this->db->select("select s.id,
			s.oferta_minima,
			s.fecha_inicio,
			s.fecha_fin,
			s.condicion,
			s.estado,
			sp.nombre as producto,
			sp.imagen,
			sp.marca,
			sp.descripcion_corta,
			sp.contenido
                    from subasta s
                    LEFT JOIN subasta_producto sp on sp.id_subasta = s.id
                    where s.id = $idSubasta");
        return $sqlDatos[0];
    }

    public function eliminarImagenProducto($datos) {
        $id = $datos['id'];
        $imagen = $datos['imagen'];
        $posicion = $datos['posicion'] - 1;
        $ruta = UPLOAD_SUBASTA;
        $imagenes = $this->db->select("select imagen from subasta_producto where id_subasta = $id");
        $arrImagenes = explode('|', $imagenes[0]['imagen']);
        $primerElemento = reset($arrImagenes);
        $ultimoElemento = end($arrImagenes);
        $quitarImagen = $arrImagenes[$posicion];
        $data = false;
        if ($imagen == $quitarImagen) {
            $eliminar = $ruta . $quitarImagen;
            try {
                unlink($eliminar);
            } catch (Exception $e) {
                echo 'Excepción capturada: ', $e->getMessage(), "\n";
            }
            $strImagenes = implode('|', $arrImagenes);
            $result = '';
            switch (true) {
                case ($quitarImagen == $primerElemento) && ($quitarImagen == $ultimoElemento):
                    $result = str_replace($imagen, '', $strImagenes);
                    break;
                case $quitarImagen == $primerElemento:
                    $result = str_replace($imagen . '|', '', $strImagenes);
                    break;
                case $quitarImagen == $ultimoElemento:
                    $result = str_replace('|' . $imagen, '', $strImagenes);
                    break;
                default :
                    $result = str_replace($imagen . '|', '', $strImagenes);
                    break;
            }
            $update = array('imagen' => $result);
            $this->db->update('subasta_producto', $update, "`id_subasta` = $id");
            Session::set('message', array(
                'type' => 'success',
                'mensaje' => 'Se ha eliminado correctamente la imagen seleccionada'));
            $data = true;
        }
        return $data;
    }

    public function modificarSubasta($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $sqlImagen = $this->db->select("select imagen from subasta_producto where id_subasta = $id");
        $oldImage = $sqlImagen[0]['imagen'];
        if (!empty($datos['imagen'])) {
            $imagen = $oldImage . '|' . $datos['imagen'];
        } else {
            $imagen = $oldImage;
        }
        $datosSubasta = array(
            'oferta_minima' => $datos['oferta_minima'],
            'fecha_inicio' => date('Y-m-d', strtotime($datos['fecha_inicio'])),
            'fecha_fin' => date('Y-m-d', strtotime($datos['fecha_fin'])),
            'condicion' => utf8_decode($datos['condicion'])
        );
        $this->db->update('subasta', $datosSubasta, "`id` = $id");
        $datosSubastaProducto = array(
            'marca' => $datos['marca'],
            'nombre' => $datos['nombre'],
            'descripcion_corta' => $datos['descripcion_corta'],
            'contenido' => $datos['contenido'],
            'imagen' => $imagen,
            'id_moneda' => 1
        );
        $this->db->update('subasta_producto', $datosSubastaProducto, "`id_subasta` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Se ha modificado correctamente la subasta'));
    }

}
