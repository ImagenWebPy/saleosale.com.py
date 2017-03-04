<?php

class Subasta_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    /**
     * Funcion que retorna la cantidad de subastas activas
     * @return int
     */
    public function totalSubastas() {
        $sqlTotalSubastas = $this->db->select("select count(*) as cantidad from subasta where fecha_inicio <= NOW() and fecha_fin >= NOW() and estado = 'Habilitada' and finalizada = 0");
        return $sqlTotalSubastas[0]['cantidad'];
    }

    public function listarSubastas($totalSubastas, $pagina) {
        $datos = array();
        #Limite la busqueda
        $TAMANO_PAGINA = CANT_REGISTROS_PAGINA;
        #examino la página a mostrar y el inicio del registro a mostrar
        if (empty($pagina)) {
            $inicio = 0;
            $pagina = 1;
        } else {
            $inicio = ($pagina - 1) * $TAMANO_PAGINA;
        }
        #calculo el total de páginas
        $total_paginas = ceil($totalSubastas / $TAMANO_PAGINA);
        #consulta
        $consulta = $this->db->select("Select s.id AS id_subasta,
                                                s.oferta_minima,
                                                s.fecha_inicio,
                                                s.fecha_fin,
                                                s.condicion,
                                                sp.marca,
                                                sp.nombre,
                                                sp.descripcion_corta,
                                                sp.imagen,
                                                sp.id_moneda,
                                                (SELECT monto_oferta FROM subasta_oferta WHERE id_subasta = s.id ORDER BY id DESC LIMIT 1) AS monto_oferta, 
                                               s.estado 
                                       FROM subasta s
                                       LEFT JOIN subasta_producto sp ON sp.id_subasta = s.id 
                                       WHERE s.estado = 'Habilitada' 
                                       AND s.fecha_inicio <= NOW()
                                       AND s.fecha_fin >= NOW()
                                       AND finalizada = 0
                                        LIMIT  $inicio , $TAMANO_PAGINA");
        foreach ($consulta as $item) {
            $helper = new Helper();
            $idSubasta = $item['id_subasta'];
            $ofertas = $helper->getSubastaOfertas($idSubasta, 1);
            $monto_oferta = $item['oferta_minima'];
            if (!empty($ofertas[0]['monto_oferta'])) {
                if ($ofertas[0]['monto_oferta'] > $item['oferta_minima'])
                    $monto_oferta = $ofertas[0]['monto_oferta'];
            }
            array_push($datos, array(
                'id' => $idSubasta,
                'oferta_minima' => $item['oferta_minima'],
                'fecha_inicio' => $item['fecha_inicio'],
                'fecha_fin' => $item['fecha_fin'],
                'condicion' => $item['condicion'],
                'marca' => $item['marca'],
                'nombre' => $item['nombre'],
                'descripcion_corta' => $item['descripcion_corta'],
                'imagen' => $item['imagen'],
                'id_moneda' => $item['id_moneda'],
                'monto_oferta' => $item['monto_oferta'],
                'estado' => $item['estado']
            ));
        }
        return $datos;
    }

    public function paginacion($pagina, $totalProductos) {
        $paginador = '';
        $TAMANO_PAGINA = CANT_REGISTROS_PAGINA;
        $total_paginas = ceil($totalProductos / $TAMANO_PAGINA);
        if ($total_paginas > 1) {
            if ($pagina != 1)
                $paginador .= '<a href="' . URL . 'subasta/' . ($pagina - 1) . '"><i class="fa fa-angle-left" aria-hidden="true"></i></a>';
            for ($i = 1; $i <= $total_paginas; $i++) {
                if ($pagina == $i)
                #si muestro el índice de la página actual, no coloco enlace
                    $paginador .= $pagina;
                else
                #si el índice no corresponde con la página mostrada actualmente,
                #coloco el enlace para ir a esa página
                    $paginador .= '  <a href="' . URL . 'subasta/' . $i . '">' . $i . '</a>  ';
            }
            if ($pagina != $total_paginas)
                $paginador .= '<a href="' . URL . 'subasta/' . ($pagina + 1) . '"><i class="fa fa-angle-right" aria-hidden="true"></i></a>';
        }
        return $paginador;
    }

    public function getItemSubasta($idSubasta) {
        $sqlSubasta = $this->db->select("Select s.id as id_subasta,
                                              s.oferta_minima,
                                              s.fecha_inicio,
                                              s.fecha_fin,
                                              s.condicion,
                                              sp.marca,
                                              sp.nombre,
                                              sp.descripcion_corta,
                                              sp.contenido,
                                              sp.imagen,
                                              sp.id_moneda,
                                              so.monto_oferta,
                                              so.fecha_oferta,
                                              s.estado
                                        from subasta s
                                        LEFT JOIN subasta_producto sp on sp.id_subasta = s.id
                                        LEFT JOIN subasta_oferta so on so.id_subasta = s.id
                                        where s.id = $idSubasta
                                        and s.estado = 'Habilitada'");
        return $sqlSubasta[0];
    }

    public function ofertar($data) {
        $helper = new Helper();
        $datos = 'error';
        $idSubasta = $data['id_subasta'];
        $idCliente = $data['id_cliente'];
        #obtenmos el id del cliente que cargo la subsata
        $idSubastaCliente = $this->db->select("select id_cliente from subasta where id = $idSubasta");
        #obtenemos la ultima oferta
        $ofertaActual = round($helper->obtenerOfertaActual($idSubasta)[0]['oferta'], 0);
        if ($ofertaActual >= $data['monto_oferta']) {
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'Lo sentimos, pero el monto de su oferta tiene que ser mayor al de la actual'));
        } elseif ($idSubastaCliente[0]['id_cliente'] == $idCliente) {
            Session::set('message', array(
                'type' => 'error',
                'mensaje' => 'Lo sentimos, pero no puede ofertar en su misma publicación'));
        } else {
            #obtenemos el email del subastante anterior para notificarle que hay una oferta mayor a la suya
            $ofertaAnterior = $this->db->select("select so.id_cliente, CONCAT_WS(' ',c.nombre,c.apellido) as cliente, c.email from subasta_oferta so
                                                LEFT JOIN cliente c on c.id = so.id_cliente
                                                where so.id_subasta = $idSubasta 
                                                ORDER BY so.id desc limit 1");
            $this->db->insert('subasta_oferta', array(
                'id_subasta' => $idSubasta,
                'id_cliente' => $idCliente,
                'monto_oferta' => $data['monto_oferta'],
                'fecha_oferta' => date('Y-m-d H:i:s')
            ));
            $cantSubastas = count($helper->getSubastaOfertas($idSubasta));
            $datos = array(
                'cant' => $cantSubastas,
                'monto' => number_format($data['monto_oferta'], 0, ',', '.'),
                'monto_oferta' => 'Gs. ' . number_format($data['monto_oferta'], 0, ',', '.'),
                'fecha_oferta' => date('d-m-Y H:i:s', strtotime($data['fecha_oferta']))
            );
            #enviamos el email
            if ($ofertaAnterior[0]['id_cliente'] != $idCliente) {
                $destinatarioNombre = $ofertaAnterior[0]['cliente'];
                $asunto = "Hola $destinatarioNombre, han superado el monto de tu oferta";
                $email = $ofertaAnterior[0]['email'];
                $datosEmail = array(
                    'nombre' => $destinatarioNombre,
                    'id_subasta' => $idSubasta,
                    'monto_oferta' => 'Gs. ' . number_format($data['monto_oferta'], 0, ',', '.'),
                    'fecha_oferta' => date('d-m-Y H:i:s', strtotime($data['fecha_oferta']))
                );
                $helper->sendMail($email, $asunto, 'subasta[oferta]', $datosEmail, $destinatarioNombre);
            }
        }
        echo json_encode($datos);
    }

}
