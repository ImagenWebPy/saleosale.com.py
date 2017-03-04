<?php

class Pagina_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    public function getDatosPagina($idPagina) {
        $result = $this->db->select("select nombre_pagina, contenido from pagina where id = $idPagina");
        $datos = array(
            'nombre_pagina' => $result[0]['nombre_pagina'],
            'contenido' => $result[0]['contenido']
        );
        return $datos;
    }

    public function sidebar($idPagina) {
        $helper = new Helper();
        $aside = '';
        $result = $this->db->select("select p.id_seccion_pagina, sp.descripcion as seccion from pagina p LEFT JOIN seccion_pagina sp on sp.id = p.id_seccion_pagina WHERE  p.id = $idPagina and p.estado = 1");
        if (!empty($result)) {
            $aside = '<aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
                <div class="block block-company">
                    <div class="block-title">' . utf8_encode($result[0]['seccion']) . '</div>
                    <div class="block-content">
                        ' . $helper->getPaginas($result[0]['id_seccion_pagina']) . '
                    </div>
                </div>
            </aside>';
        }
        return $aside;
    }

}
