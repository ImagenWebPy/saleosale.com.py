<?php

class Admin_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function iniciarSession($data) {
        $helper = new Helper();
        $sth = $this->db->prepare("SELECT id, email, usuario, nombre, nivel FROM admin_usuario WHERE 
                email = :email AND contrasena = :password");
        $sth->execute(array(
            ':email' => $data['email'],
            ':password' => Hash::create('sha256', $data['password'], HASH_PASSWORD_KEY)
        ));
        $dato = $sth->fetch();
        $count = $sth->rowCount();
        if ($count > 0) {
            Session::set('admin', array(
                'id' => $dato['id'],
                'nombre' => $dato['nombre'],
                'nivel' => $dato['nivel'],
                'email' => $dato['email']));
            header('location: ' . URL . 'admin/index/');
        } else {
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'El usuario ingresado no existe o la contraseña ingresada no coincide'));
            header('location: ' . URL . 'admin/login');
        }
    }

    public function cantProductos() {
#funcion que obtiene la cantidad de productos activos en la tienda
        $sqlCantidad = $this->db->select("select count(*) as cantidad from producto where estado = 1");
        $cantidad = $sqlCantidad[0]['cantidad'];
        return $cantidad;
    }

    public function cantVentas() {
#funcion que obtiene la cantidad de ventas de la tienda
        $sqlCantidad = $this->db->select("select count(*) as cantidad from pedido");
        $cantidad = $sqlCantidad[0]['cantidad'];
        return $cantidad;
    }

    public function cantClientes() {
#funcion que obtiene la cantidad de clientes de la tienda
        $sqlCantidad = $this->db->select("select count(*) as cantidad from cliente");
        $cantidad = $sqlCantidad[0]['cantidad'];
        return $cantidad;
    }

    public function ultimasOrdenes() {
        $sqlPedidos = $this->db->select("select p.id, p.estado_pedido, p.estado_pago, p.estado_pago, p.fecha_pedido, (select GROUP_CONCAT(pr.nombre) from pedido_detalle pd LEFT JOIN producto pr on pr.id = pd.id_producto where pd.id_pedido = p.id) as productos from pedido p ORDER BY id DESC LIMIT 10");
        $listado = array();
        foreach ($sqlPedidos as $pedidos) {
            array_push($listado, array(
                'id' => $pedidos['id'],
                'estado_pedido' => $pedidos['estado_pedido'],
                'estado_pago' => $pedidos['estado_pago'],
                'fecha_pedido' => $pedidos['fecha_pedido'],
                'producto' => $pedidos['productos']
            ));
        }
        return $listado;
    }

    public function ultimosProductos() {
        $sqlProductos = $this->db->select("select id,nombre, descripcion, precio, id_moneda, imagen from producto ORDER BY id DESC limit 6");
        return $sqlProductos;
    }

    public function totalProductos($busqueda = null) {
        $search = '';
        if (!empty($busqueda)) {
            $search = "where nombre like '%$busqueda%' or tags like '%$busqueda%'";
        }
        $productos = $this->db->select("select count(*) as cantidad from producto $search");
        return $productos[0]['cantidad'];
    }

    public function totalClientes() {
        $productos = $this->db->select("select count(*) as cantidad from cliente");
        return $productos[0]['cantidad'];
    }

    public function totalPedidos() {
        $productos = $this->db->select("select count(*) as cantidad from pedido");
        return $productos[0]['cantidad'];
    }

    public function productosPaginados($cantProductos, $pagina = NULL, $busqueda = NULL) {
        $search = '';
        if (!empty($busqueda)) {
            $search = "where nombre like '%$busqueda%' or tags like '%$busqueda%'";
        }
        $num_total_registros = $cantProductos;
//Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
//examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
//calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $consulta = $this->db->select("select p.id, p.nombre, m.descripcion, p.imagen, CASE p.estado when 1 then 'Activo' when 0 then 'Deshabilitado' end as estado from producto p LEFT JOIN marca m on m.id = p.id_marca $search ORDER BY p.nombre ASC LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $consulta;
    }

    public function clientesPaginados($cantClientes, $pagina = NULL) {
        $num_total_registros = $cantClientes;
//Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
//examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
//calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $consulta = $this->db->select("select c.id, c.nombre, c.apellido, c.telefono, c.email, c.fecha_registro, c.facebook_email from cliente c ORDER BY c.nombre asc, c.apellido asc LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $consulta;
    }

    public function pedidosPaginados($cantPedidos, $pagina = NULL) {
        $num_total_registros = $cantPedidos;
//Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
//examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
//calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $consulta = $this->db->select("select p.id, CONCAT_WS(' ',c.nombre, c.apellido) as cliente, fp.descripcion as forma_pago, p.fecha_pedido, p.monto_pedido, p.monto_envio, p.monto_total, p.estado_pedido, p.estado_pago, (select GROUP_CONCAT(pr.nombre) from pedido_detalle pd LEFT JOIN producto pr on pr.id = pd.id_producto where pd.id_pedido = p.id) as producto from pedido p LEFT JOIN cliente c on c.id = p.id_cliente LEFT JOIN forma_pago fp on fp.id = p.id_forma_pago order by p.id desc LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $consulta;
    }

    public function paginacion($pagina, $totalProductos) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalProductos / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/productos/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
//si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
//si el índice no corresponde con la página mostrada actualmente,
//coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/productos/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/productos/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function clientesPaginacion($pagina, $totalClientes) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalClientes / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/clientes/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
//si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
//si el índice no corresponde con la página mostrada actualmente,
//coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/clientes/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/clientes/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function pedidosPaginacion($pagina, $totalPedidos) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalPedidos / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/pedidos/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
//si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
//si el índice no corresponde con la página mostrada actualmente,
//coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/pedidos/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/pedidos/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function getMarca($idProducto) {
        $marca = $this->db->select("select m.id, m.descripcion from marca m LEFT JOIN producto p on p.id_marca = m.id where p.id = $idProducto");
        $data = array('id' => $marca[0]['id'], 'descripcion' => $marca[0]['descripcion']);
        return $data;
    }

    public function getMarcas($idProducto = NULL) {
        if (!empty($idProducto)) {
            $marca = $this->db->select("select m.id, m.descripcion from marca m LEFT JOIN producto p on p.id_marca = m.id where p.id != $idProducto order by m.descripcion asc");
        } else {
            $marca = $this->db->select("select m.id, m.descripcion from marca m order by m.descripcion asc");
        }
        $data = array();
        foreach ($marca as $item) {
            array_push($data, array('id' => $item['id'], 'descripcion' => $item['descripcion']));
        }
        return $data;
    }

    public function getCategoriaPadre($idProducto) {
        $sql = $this->db->select("select cat.id, cat.descripcion from categoria cat where cat.id = (select c.padre_id from categoria c LEFT JOIN producto p on p.id_categoria = c.id where p.id = $idProducto)");
        $data = array('id' => $sql[0]['id'], 'descripcion' => $sql[0]['descripcion']);
        return $data;
    }

    public function getCategoriasPadre($idPadre = NULL) {
        if (!empty($idPadre)) {
            $sql = $this->db->select("select c.id, c.descripcion from categoria c where c.padre_id = 0 and c.id != 71 and c.id != $idPadre ORDER BY c.descripcion ASC");
        } else {
            $sql = $this->db->select("select c.id, c.descripcion from categoria c where c.padre_id = 0 and c.id != 71 ORDER BY c.descripcion ASC");
        }
        $data = array();
        foreach ($sql as $item) {
            array_push($data, array('id' => $item['id'], 'descripcion' => $item['descripcion']));
        }
        return $data;
    }

    public function getDatosProductos($idProducto) {
        $dato = $this->db->select("select * from producto where id = $idProducto");
        $data = array(
            'id' => $dato[0]['id'],
            'nombre' => $dato[0]['nombre'],
            'descripcion' => $dato[0]['descripcion'],
            'contenido' => $dato[0]['contenido'],
            'imagen' => $dato[0]['imagen'],
            'precio' => $dato[0]['precio'],
            'precio_oferta' => $dato[0]['precio_oferta'],
            'stock' => $dato[0]['stock'],
            'tags' => $dato[0]['tags'],
            'nuevo' => $dato[0]['nuevo'],
            'estado' => $dato[0]['estado'],
            'codigo' => $dato[0]['codigo']
        );
        return $data;
    }

    public function loadDatosSub($idPadre) {
#Se establece el tipo de contenido a json y la codificación
        header('Content-type: application/json; charset=utf-8');
        $sqlCategorias = $this->db->select("select c.id, c.descripcion from categoria c where c.padre_id = $idPadre");
        $data = array();
        foreach ($sqlCategorias as $item) {
            array_push($data, array('id' => $item['id'], 'descripcion' => utf8_encode($item['descripcion'])));
        }
        $data = json_encode($data);
        echo $data;
    }

    public function getSubCategoria($idProducto) {
        $sqlSubCategoria = $this->db->select("select c.id, c.descripcion from categoria c LEFT JOIN producto p on p.id_categoria = c.id where p.id = $idProducto");
        $data = array('id' => $sqlSubCategoria[0]['id'], 'descripcion' => $sqlSubCategoria[0]['descripcion']);
        return $data;
    }

    public function getMoneda($idProducto) {
        $sql = $this->db->select("select m.id, m.simbolo, m.descripcion from moneda m LEFT JOIN producto p on p.id_moneda = m.id where p.id = $idProducto");
        $data = array('id' => $sql[0]['id'], 'simbolo' => $sql[0]['simbolo'], 'descripcion' => $sql[0]['descripcion']);
        return $data;
    }

    public function getMonedas($idMoneda = NULL) {
        if (!empty($idMoneda)) {
            $sql = $this->db->select("select m.id, m.simbolo, m.descripcion from moneda m WHERE m.id != $idMoneda");
        } else {
            $sql = $this->db->select("select m.id, m.simbolo, m.descripcion from moneda m");
        }
        $data = array();
        foreach ($sql as $item) {
            array_push($data, array('id' => $item['id'], 'simbolo' => $item['simbolo'], 'descripcion' => $item['descripcion']));
        }
        return $data;
    }

    public function saveProduct($data) {
        $id = $data['id'];
        unset($data['id']);
        #obtenemos la imagen
        $sqlImagen = $this->db->select("select imagen from producto where id = $id");
        $oldImage = $sqlImagen[0]['imagen'];
        if (!empty($oldImage)) {
            $data['imagen'] = $oldImage . '|' . $data['imagen'];
        }
        #datos a actualizar
        $datoa = array(
            'id_categoria' => $data['subcategoria'],
            'id_marca' => $data['marca'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'contenido' => $data['contenido'],
            'imagen' => $data['imagen'],
            'id_moneda' => $data['moneda'],
            'precio' => $data['precio'],
            'precio_oferta' => $data['precio_oferta'],
            'stock' => $data['stock'],
            'tags' => $data['tags'],
            'nuevo' => $data['nuevo'],
            'estado' => $data['estado']);
        $this->db->update('producto', $datoa, "`id` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Los datos han sido modificados con exito'));
    }

    public function addProduct($data) {
        $this->db->insert('producto', array(
            'id_categoria' => $data['subcategoria'],
            'id_marca' => $data['marca'],
            'codigo' => $data['codigo'],
            'nombre' => $data['nombre'],
            'descripcion' => $data['descripcion'],
            'contenido' => $data['contenido'],
            'imagen' => $data['imagen'],
            'id_moneda' => $data['moneda'],
            'precio' => $data['precio'],
            'precio_oferta' => $data['precio_oferta'],
            'stock' => $data['stock'],
            'tags' => $data['tags'],
            'nuevo' => $data['nuevo'],
            'estado' => $data['estado']
        ));
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'El producto se ha agregado correctamente'));
    }

    public function getCliente($idCliente) {
        $sqlCliente = $this->db->select("select * from cliente where id = $idCliente");
        return $sqlCliente[0];
    }

    public function getDocumento($idCliente) {
        $sqlDocumento = $this->db->select("select c.id_tipo_documento, td.descripcion from cliente c LEFT JOIN tipo_documento td on td.id = c.id_tipo_documento where c.id = $idCliente");
        return $sqlDocumento[0];
    }

    public function getDocumentos($id_tipo_documento = NULL) {
        if (!empty($id_tipo_documento)) {
            $sqlTipoDocumento = $this->db->select("select td.id, td.descripcion from tipo_documento td where td.id != $id_tipo_documento");
        } else {
            $sqlTipoDocumento = $this->db->select("select td.id, td.descripcion from tipo_documento td");
        }
        return $sqlTipoDocumento;
    }

    public function getPedido($idPedido) {
        $sqlPedido = $this->db->select("select p.id, c.id as id_cliente, CONCAT_WS(' ',c.nombre, c.apellido) as cliente, dc.barrio, dc.calle_principal, dc.calle_lateral1, dc.telefono, dc.tipo_vivienda, p.map_latitude, p.map_longitude, cy.descripcion as ciudad, d.descripcion as departamento, fp.descripcion as forma_pago, p.fecha_pedido, p.monto_pedido, p.monto_envio, p.monto_descuento, p.monto_total, p.observacion_pedido, p.estado_pedido, p.estado_pago, p.fecha_pago, p.img_canje, (select GROUP_CONCAT(pd.id) from pedido_detalle pd where pd.id_pedido = p.id ) as detalle from pedido p LEFT JOIN cliente c on c.id = p.id_cliente LEFT JOIN direccion_cliente dc on dc.id = p.id_direccion_cliente LEFT JOIN ciudad cy on cy.id = dc.id_ciudad LEFT JOIN departamento d on d.id = cy.id_departamento LEFT JOIN forma_pago fp on fp.id = p.id_forma_pago WHERE p.id = $idPedido");
        return $sqlPedido[0];
    }

    public function getItemsPedido($producto) {
        $productos = explode(',', $producto);
        $items = array();
        foreach ($productos as $item) {
            $sqlDetalle = $this->db->select("select pd.cantidad, pd.precio, p.nombre as producto, p.codigo from pedido_detalle pd LEFT JOIN producto p on p.id = pd.id_producto where pd.id = $item");
            foreach ($sqlDetalle as $detalle) {
                array_push($items, $detalle);
            }
        }
        return $items;
    }

    public function secciones() {
        $sqlSecciones = $this->db->select("select id, descripcion from seccion_producto where estado = 1");
        return $sqlSecciones;
    }

    public function getTableSeccion($idSeccion) {
        header('Content-type: application/json; charset=utf-8');
        $tabla = '';
        $sqlNombreSeccion = $this->db->select("select descripcion from seccion_producto where id = $idSeccion");
        $sqlGroupNotIn = $this->db->select("select GROUP_CONCAT(ps.id_producto) as grupo from producto_seleccionado ps WHERE ps.id_seccion_producto = $idSeccion");
        $group = $sqlGroupNotIn[0]['grupo'];
        if (!empty($group))
            $sqlProductosNoSeleccionado = $this->db->select("select p.id, CONCAT_WS(' - ',m.descripcion, p.nombre) as nombre from producto p LEFT JOIN marca m on m.id = p.id_marca where p.id NOT IN ($group) and p.estado = 1 ORDER BY m.descripcion asc, p.nombre asc;");
        else
            $sqlProductosNoSeleccionado = $this->db->select("select p.id, CONCAT_WS(' - ',m.descripcion, p.nombre) as nombre from producto p LEFT JOIN marca m on m.id = p.id_marca where p.estado = 1 ORDER BY m.descripcion asc, p.nombre asc");
        $sqlProductosSeleccionado = $this->db->select("select ps.id_producto, CONCAT_WS(' - ',m.descripcion, p.nombre) as nombre from producto_seleccionado ps LEFT JOIN producto p on p.id = ps.id_producto LEFT JOIN marca m on m.id = p.id_marca WHERE ps.id_seccion_producto = $idSeccion ORDER BY ps.orden asc");
        $tabla .= '<div class="box"><div class="box-header with-border"><h3 class="box-title">' . utf8_encode($sqlNombreSeccion[0]['descripcion']) . '</h3></div><!-- /.box-header --><form role="form" method="post" action="' . URL . 'admin/guardarDestacados">';
        $tabla .= '<select multiple="multiple" id="my-select" name="my-select[]">';
        foreach ($sqlProductosSeleccionado as $item) {
            $tabla .='<option value="' . $item['id_producto'] . '" selected>' . utf8_encode($item['nombre']) . '</option>';
        }
        foreach ($sqlProductosNoSeleccionado as $item) {
            $tabla .='<option value="' . $item['id'] . '">' . utf8_encode($item['nombre']) . '</option>';
        }
        $tabla .="</select>
                <script>$('#my-select').multiSelect();</script>";
        $tabla .= '<input type="hidden" value="' . $idSeccion . '" name="id_seccion" />';
        $tabla .= '<div class="box-footer"><button type="submit" class="btn btn-primary">Guardar Cambios</button></div></div><!-- /.box -->';
        $tabla = json_encode($tabla);
        echo $tabla;
    }

    public function modificarSeleccionados($id_seccion, $seleccionados) {
        //$this->db->delete("producto_seleccionado", "id_seccion_producto = $id_seccion");
        $sth = $this->db->prepare("delete from producto_seleccionado where id_seccion_producto = :idSeccion");
        $sth->execute(array(
            ':idSeccion' => $id_seccion
        ));
        foreach ($seleccionados as $item) {
            $this->db->insert('producto_seleccionado', array(
                'id_producto' => $item['id_producto'],
                'id_seccion_producto' => $id_seccion,
                'orden' => $item['orden']
            ));
        }
    }

    public function updateEstadoPedido($data) {
        $id = $data['id'];
        unset($data['id']);
        $datos = array(
            'estado_pedido' => $data['estado_pedido']
        );
        $this->db->update('pedido', $datos, "`id` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'El estado del pedido ha sido modificado con exito'));
    }

    public function updateEstadoPago($data) {
        $id = $data['id'];
        unset($data['id']);
        $datos = array(
            'estado_pago' => $data['estado_pago']
        );
        $this->db->update('pedido', $datos, "`id` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'El estado del pago ha sido modificado con exito'));
    }

    public function getPadres() {
        $sqlPadres = $this->db->select("select id, descripcion from categoria where padre_id = 0 ORDER BY orden asc");
        return $sqlPadres;
    }

    public function getSectionHijos($idPadre) {
        header('Content-type: application/json; charset=utf-8');
        $hijos = $this->db->select("select id, descripcion, url_rewrite from categoria where padre_id = $idPadre order by descripcion asc");
        $div = '<div class="box-header"><button class="btn btn-primary pull-right" data-toggle="modal" data-target="#agregarHijo">Agregar Item</button></div><!-- /.box-header --><div class="box-body no-padding">';
        $div .= '<table class="table table-striped"><tr><th style="width: 10px">#</th><th>Nombre Categoría</th><th>Acción</th></tr>';
        $i = 1;
        foreach ($hijos as $item) {
            $div .= '<tr><td>' . $i . '</td><td>' . utf8_encode($item['descripcion']) . '</td><td>
                                            <a href="#" class="btn btn-app" data-toggle="modal" data-target="#editar' . $item['id'] . '"><i class="fa fa-edit"></i>Editar</a>
                                            <a href="#" class="btn btn-app" data-toggle="modal" data-target="#eliminar' . $item['id'] . '"><i class="fa fa-trash-o"></i>Eliminar</a></td></tr>';
            $div .='<div class="modal fade" id="editar' . $item['id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                          <h4 class="modal-title" id="myModalLabel">Modificar</h4>
                        </div>
                        <div class="modal-body">
                        <form class="form-horizontal" method="POST" action="' . URL . 'admin/modificarHijo/"  id="frm-modificar-' . $item['id'] . '">
                            <div class="form-group">
                              <label class="col-sm-2 control-label">Descripción</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Nombre Categoria" value="' . utf8_encode($item['descripcion']) . '" name="descripcion" id="descripcion' . $item['id'] . '">
                              </div>
                            </div>
                            <div class="form-group">
                              <label class="col-sm-2 control-label">URL Amigable</label>
                              <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="URL Amigable" value="' . $item['url_rewrite'] . '" name="url_rewrite" id="url_rewrite' . $item['id'] . '">
                              </div>
                            </div>
                            <input type="hidden" value="' . $item['id'] . '" name="id" id="id' . $item['id'] . '" >
                            <button type="submit" class="btn btn-primary" id="btn-mod' . $item['id'] . '" style=" margin-top:15px; margin-left: 15px;">Guardar Cambios</button>
                        </form>
                        <script>
                        $( "#btn-mod' . $item['id'] . '" ).click(function() {
                            var url = "' . URL . 'admin/modificarHijo/";
                            var descripcion = $("#descripcion' . $item['id'] . '").val(); 
                            var url_rewrite = $("#url_rewrite' . $item['id'] . '").val();
                            var id = $("#id' . $item['id'] . '").val();
                                $.ajax({
                                    url: url,
                                    type: "post",
                                    dataType: "json",
                                    data: {descripcion: descripcion, url_rewrite: url_rewrite, id: id},
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                          });
                          $( "#btn-eliminar' . $item['id'] . '" ).click(function() {
                            var url = "' . URL . 'admin/eliminarHijo/";
                            var id = $("#id' . $item['id'] . '").val();
                                $.ajax({
                                    url: url,
                                    type: "post",
                                    dataType: "json",
                                    data: {id: id},
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                        });
                        </script>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        </div>
                      </div>
                    </div>
                  </div>';
            $div .= '<div class="modal fade" id="eliminar' . $item['id'] . '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header bg-danger">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title" id="myModalLabel">Eliminar</h4>
                            </div>
                            <div class="modal-body">
                              ¿Esta seguro que desea eliminar la categoría "' . utf8_encode($item['descripcion']) . '"?
                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                              <button type="button" class="btn btn-danger" id="btn-eliminar' . $item['id'] . '">Eliminar</button>
                            </div>
                          </div>
                        </div>
                    </div>';
            $i++;
        }
        $div .= '</table>';
        $div .= '<div class="modal fade" id="agregarHijo" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header bg-success">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Agregar Item</h4>
                          </div>
                          <div class="modal-body">
                            <div class="form-group">
                              <label>Nombre Item</label>
                              <input type="text" class="form-control" id="descripcion" placeholder="Agrege una Descripcion">
                            </div>
                            <div class="form-group">
                              <label>Url Amigable</label>
                              <input type="text" class="form-control" id="url_rewrite" placeholder="Url_Amigable">
                            </div>
                          </div>
                          <input type="hidden" id="padre_id" value="' . $idPadre . '">
                          <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="button" class="btn btn-primary" id="btn-agregarHijo">Agregar</button>
                          </div>
                        </div>
                    </div>
                </div>
                <script>
                    $( "#btn-agregarHijo" ).click(function() {
                            var url = "' . URL . 'admin/modificarHijo/";
                            var descripcion = $("#descripcion").val(); 
                            var url_rewrite = $("#url_rewrite").val();
                            var padre_id = $("#padre_id").val();
                                $.ajax({
                                    url: url,
                                    type: "post",
                                    dataType: "json",
                                    data: {descripcion: descripcion, url_rewrite: url_rewrite, padre_id: padre_id},
                                    success: function(data) {
                                        location.reload();
                                    }
                                });
                    });
                </script>';
        $div .= '</div><!-- /.box-body --></div><!-- /.box -->';
        $div = json_encode($div);
        echo $div;
    }

    public function guardarHijo($datos) {
        header('Content-type: application/json; charset=utf-8');
        $data = false;
        if (array_key_exists('id', $datos) == true) {
            $id = $datos['id'];
            unset($datos['id']);
            $this->db->update('categoria', $datos, "`id` = $id");
            $data = true;
        } else {
            $this->db->insert('categoria', $datos);
        }
        return json_encode($data);
    }

    public function eliminarHijo($id) {
        header('Content-type: application/json; charset=utf-8');
        $sth = $this->db->prepare("delete from categoria where id = :idCategoria");
        $sth->execute(array(
            ':idCategoria' => $id
        ));
        $result = true;
        return json_encode($result);
    }

    public function zonas() {
        $sqlZonas = $this->db->select("select id, descripcion, costo from costo_envio ORDER BY descripcion asc");
        return $sqlZonas;
    }

    public function modificarZona($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('costo_envio', $datos, "`id` = $id");
    }

    public function getDepartamentos() {
        $departamentos = $this->db->select("select DISTINCT d.id, d.descripcion as departamento from ciudad c LEFT JOIN departamento d on d.id = c.id_departamento where c.id_costo_envio is null ORDER BY d.descripcion asc");
        return $departamentos;
    }

    public function saveCity($datos) {
        $id = $datos['id_ciudad'];
        unset($datos['id_ciudad']);
        $update = array('id_costo_envio' => $datos['id_zona']);
        $this->db->update('ciudad', $update, "`id` = $id");
    }

    public function delCity($id_ciudad) {
        $id = $id_ciudad;
        $update = array('id_costo_envio' => null);
        $this->db->update('ciudad', $update, "`id` = $id");
    }

    public function getBanners($posicion) {
        $items = $this->db->select("select b.id, b.orden, b.imagen, b.id_categoria, c.descripcion as categoria, b.id_producto,b.texto_1, b.texto_2, b.texto_3, b.texto_enlace, b.enlace, b.imagen, b.estado from banner b LEFT JOIN posicion_banner pb on pb.id = b.id_posicion LEFT JOIN categoria c on c.id = b.id_categoria where pb.id = $posicion order by orden asc");
        return $items;
    }

    public function editarSlider($datos) {
        if (empty($datos['imagen'])) {
            unset($datos['imagen']);
        }
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('banner', $datos, "`id` = $id");
    }

    public function editarLateral($datos) {
        if (empty($datos['imagen'])) {
            unset($datos['imagen']);
        }
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('banner', $datos, "`id` = $id");
    }

    public function editarInferior($datos) {
        if (empty($datos['imagen'])) {
            unset($datos['imagen']);
        }
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('banner', $datos, "`id` = $id");
    }

    public function agregarSlider($datos) {
        $posicion = 1;
        $this->db->insert('banner', array(
            'id_posicion' => $posicion,
            'texto_1' => $datos['texto_1'],
            'texto_2' => $datos['texto_2'],
            'texto_3' => $datos['texto_3'],
            'texto_enlace' => $datos['texto_enlace'],
            'orden' => $datos['orden'],
            'enlace' => $datos['enlace'],
            'imagen' => $datos['imagen']
        ));
    }

    public function eliminarSlider($id) {
        $ruta = UPLOAD;
        $imagen = $this->db->select("select imagen from banner where id = $id");
        $eliminar = $ruta . $imagen[0]['imagen'];
        unlink($eliminar);
        $sth = $this->db->prepare("delete from banner where id = :id");
        $sth->execute(array(
            ':id' => $id
        ));
    }

    public function editarBannerCategoria($datos) {
        if (empty($datos['imagen'])) {
            unset($datos['imagen']);
        }
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('banner', $datos, "`id` = $id");
    }

    public function agregarBannerCategoria($datos) {
        $posicion = 6;
        $this->db->insert('banner', array(
            'id_posicion' => $posicion,
            'id_categoria' => $datos['id_categoria'],
            'enlace' => $datos['enlace'],
            'imagen' => $datos['imagen'],
            'orden' => $datos['orden'],
            'imagen' => $datos['imagen']
        ));
    }

    public function agregarMenuBanner($datos) {
        $posicion = 8;
        $this->db->insert('banner', array(
            'id_posicion' => $posicion,
            'id_categoria' => $datos['id_categoria'],
            'enlace' => $datos['enlace'],
            'imagen' => $datos['imagen'],
            'orden' => $datos['orden'],
            'imagen' => $datos['imagen'],
            'estado_menu' => $datos['estado_menu']
        ));
    }

    public function eliminarCategoriaSlider($id) {
        $ruta = UPLOAD_CATEGORIAS;
        $imagen = $this->db->select("select imagen from banner where id = $id");
        $eliminar = $ruta . $imagen[0]['imagen'];
        unlink($eliminar);
        $sth = $this->db->prepare("delete from banner where id = :id");
        $sth->execute(array(
            ':id' => $id
        ));
    }

    public function getUsuarios() {
        $usuarios = $this->db->select("select * from admin_usuario order by nombre asc");
        return $usuarios;
    }

    public function agregarUsuario($datos) {
        $this->db->insert('admin_usuario', array(
            'email' => $datos['email'],
            'nombre' => $datos['nombre'],
            'contrasena' => Hash::create('sha256', $datos['contrasena'], HASH_PASSWORD_KEY),
            'nivel' => $datos['nivel']
        ));
    }

    public function verificaEmail($email) {
        $sqlEmail = $this->db->select("select email from admin_usuario where email = '$email'");
        $data = true;
        if (empty($sqlEmail))
            $data = false;
        return $data;
    }

    public function editarUsuario($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('admin_usuario', $datos, "`id` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'Los datos del usuario han sido modificados satisfactoriamente'));
    }

    public function eliminarUsuario($id) {
        $sth = $this->db->prepare("delete from admin_usuario where id = :idUsuario");
        $sth->execute(array(
            ':idUsuario' => $id
        ));
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'El usuario ha sido eliminado satisfactoriamente'));
    }

    public function eliminarImagenProducto($datos) {
        $id = $datos['id'];
        $imagen = $datos['imagen'];
        $posicion = $datos['posicion'] - 1;
        $ruta = UPLOAD_IMAGE;
        $imagenes = $this->db->select("select imagen from producto where id = $id");
        $arrImagenes = explode('|', $imagenes[0]['imagen']);
        $primerElemento = reset($arrImagenes);
        $ultimoElemento = end($arrImagenes);
        $quitarImagen = $arrImagenes[$posicion];
        $data = false;
        if ($imagen == $quitarImagen) {
            $eliminar = $ruta . $quitarImagen;
            unlink($eliminar);
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
            $this->db->update('producto', $update, "`id` = $id");
            Session::set('message', array(
                'type' => 'success',
                'mensaje' => 'Se ha eliminado correctamente la imagen seleccionada'));
            $data = true;
        }
        return $data;
    }

    public function eliminarImagenSubasta($datos) {
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
            unlink($eliminar);
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

    public function cambiarUserPass($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('admin_usuario', $datos, "`id` = $id");
    }

    public function totalResenas() {
        $productos = $this->db->select("select count(*) as cantidad from producto_opinion");
        return $productos[0]['cantidad'];
    }

    public function resenasPaginados($cantProductos, $pagina = NULL) {
        $num_total_registros = $cantProductos;
        //Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        //examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
        //calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $consulta = $this->db->select("select po.*, p.nombre, CONCAT_WS(' ',c.nombre, c.apellido) as cliente from producto_opinion po left JOIN cliente c on c.id = po.id_cliente LEFT JOIN producto p on p.id = po.id_producto ORDER BY po.id DESC LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $consulta;
    }

    public function resenasPaginacion($pagina, $totalResenas) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalResenas / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/resenas/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
                //si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
                //si el índice no corresponde con la página mostrada actualmente,
                //coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/resenas/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/resenas/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function modificarResena($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('producto_opinion', $datos, "`id` = $id");
    }

    public function totalSubastas() {
        $subastas = $this->db->select("select count(*) as cantidad from subasta");
        return $subastas[0]['cantidad'];
    }

    public function totalSolicitudes() {
        $solicitudes = $this->db->select("select count(*) as cantidad from financiacion");
        return $solicitudes[0]['cantidad'];
    }

    public function subastasPaginados($cantSubastas, $pagina = NULL) {
        $num_total_registros = $cantSubastas;
        //Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        //examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
        //calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $consulta = $this->db->select("select s.*,CONCAT_WS(' ',c.nombre, c.apellido) as cliente, sp.imagen, sp.marca, sp.nombre, sp.contenido, sp.descripcion_corta, sp.id_moneda from subasta s LEFT JOIN subasta_producto sp on sp.id_subasta = s.id LEFT JOIN cliente c on c.id = s.id_cliente ORDER BY s.id desc LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $consulta;
    }

    public function subastasPaginacion($pagina, $totalSubastas) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalSubastas / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/subastas/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
                //si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
                //si el índice no corresponde con la página mostrada actualmente,
                //coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/subastas/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/subastas/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function solcitudesPaginacion($pagina, $totalSolicitudes) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        $total_paginas = ceil($totalSolicitudes / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'admin/solicitudes/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
                //si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
                //si el índice no corresponde con la página mostrada actualmente,
                //coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'admin/solicitudes/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'admin/solicitudes/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function modificarSubasta($data) {
        $id = $data['id'];
        unset($data['id']);
        $datosSubasta = array(
            'estado' => utf8_decode($data['estado'])
        );
        unset($data['estado']);
        unset($data['categoria']);
        $imagenes = $this->db->select("select imagen from subasta_producto where id_subasta = $id");
        if (!empty($data['imagen'])) {
            $newImagen = $data['imagen'] . '|' . $imagenes[0]['imagen'];
            $data['imagen'] = $newImagen;
        } else {
            $data['imagen'] = $imagenes[0]['imagen'];
        }
        $this->db->update('subasta', $datosSubasta, "`id` = $id");
        $this->db->update('subasta_producto', $data, "`id_subasta` = $id");
        Session::set('message', array(
            'type' => 'success',
            'mensaje' => 'La subasta ha sido modificada correctamente'));
    }

    public function getSolicitudes($cantSolicitudes, $pagina = NULL) {
        $num_total_registros = $cantSolicitudes;
        //Limite la busqueda
        $TAMANO_PAGINA = CANT_REG_PAGINA_ADMIN;
        //examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
        //calculo el total de páginas
        $total_paginas = ceil($num_total_registros / $TAMANO_PAGINA);
        $sqlSolicitudes = $this->db->select("select f.*, p.nombre as producto, m.descripcion as marca from financiacion f LEFT JOIN producto p on p.id = f.id_producto LEFT JOIN marca m on m.id = p.id_marca ORDER BY fecha desc LIMIT " . $inicio . "," . $TAMANO_PAGINA);
        return $sqlSolicitudes;
    }

    public function getConfigCms() {
        $sqlEmails = $this->db->select("select * from cms_config_sitio");
        return $sqlEmails;
    }

    public function editarConfig($datos) {
        $id = $datos['id'];
        unset($datos['id']);
        $this->db->update('cms_config_sitio', $datos, "`id` = $id");
    }

    public function getDatosClientePedido($idPedido) {
        $sqlDatos = $this->db->select("SELECT CONCAT_WS(' ',c.nombre,c.apellido) as cliente,
                                            c.email
                                    from cliente c
                                    LEFT JOIN pedido p on p.id_cliente = c.id
                                    where p.id = $idPedido");
        return $sqlDatos[0];
    }
    
    public function getSubastaCliente($idSubasta){
        $sqlCliente = $this->db->select("select id_cliente from subasta where id = $idSubasta");
        return $sqlCliente[0]['id_cliente'];
    }
}
