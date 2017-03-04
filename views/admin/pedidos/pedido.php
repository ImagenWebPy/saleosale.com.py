<?php
$helper = new Helper();
$pedido = $this->getPedido;
$items = $this->getItemsPedido;
$estadoPago = $this->getEstadoPago;
$estadoPedido = $this->getEstadoPedido;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Pedido
            <small>#<?php echo $pedido['id']; ?></small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="<?php echo URL; ?>admin/pedidos">Pedidos</a></li>
            <li class="active">Pedido</li>
        </ol>
        <?php
        if (isset($_SESSION['message'])) {
            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
        }
        ?>
    </section>
    <!-- Main content -->
    <section class="invoice">
        <!-- title row -->
        <div class="row">
            <div class="col-xs-12">
                <h2 class="page-header">
                    <i class="fa fa-globe"></i> Datos del Pedido
                    <small class="pull-right">Fecha y Hora: <?php echo date('d-m-Y H:i:s', strtotime($pedido['fecha_pedido'])); ?></small>
                </h2>
            </div><!-- /.col -->
        </div>
        <!-- info row -->
        <div class="row invoice-info">
            <div class="col-sm-4 invoice-col">
                <strong>Datos de envío</strong>
                <address>
                    <?php echo utf8_encode($pedido['calle_principal']) . ', ' . utf8_encode($pedido['calle_lateral1']) ?><br>
                    <?php echo utf8_encode($pedido['barrio']) . ', ' . utf8_encode($pedido['ciudad']) . ' - ' . utf8_encode($pedido['departamento']) ?><br>
                    Tipo de Vivienda: <?php echo $pedido['tipo_vivienda'] ?><br>
                    Teléfono: <?php echo $pedido['telefono'] ?>

                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <strong>Cliente</strong>
                <address>
                    <a href="<?php echo URL; ?>admin/cliente/<?php echo $pedido['id_cliente']; ?>"><?php echo $pedido['cliente']; ?></a>
                </address>
            </div><!-- /.col -->
            <div class="col-sm-4 invoice-col">
                <b>Pedido #<?php echo $pedido['id']; ?></b><br>
                <br>
                <b>Estado Pedido:</b> <?php echo utf8_encode($pedido['estado_pedido']); ?><br>
                <b>Estado Pago:</b> <?php echo utf8_encode($pedido['estado_pago']); ?><br>
                <b>Fecha de Pago:</b> <?php echo date('d-m-Y H:i:s', strtotime($pedido['fecha_pago'])); ?><br>

            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Table row -->
        <div class="row">
            <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Cantidad</th>
                            <th>Codigo</th>
                            <th>Producto</th>
                            <th>Precio</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?php echo $item['cantidad']; ?></td>
                                <td><?php echo utf8_encode($item['codigo']); ?></td>
                                <td><?php echo utf8_encode($item['producto']); ?></td>
                                <td><?php echo $helper->getPrecioCarrito($item['precio']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div><!-- /.col -->
        </div><!-- /.row -->

        <div class="row">
            <!-- accepted payments column -->
            <div class="col-xs-6">
                <p class="lead">Metodo de Pago seleccionado:</p>
                <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                    <?php echo utf8_encode($pedido['forma_pago']); ?>
                </p>
            </div><!-- /.col -->
            <div class="col-xs-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Monto Pedido:</th>
                            <td><?php echo $helper->getPrecioCarrito($pedido['monto_pedido']); ?></td>
                        </tr>
                        <tr>
                            <th>Monto Envío:</th>
                            <td><?php echo $helper->getPrecioCarrito($pedido['monto_envio']); ?></td>
                        </tr>
                        <tr>
                            <th>Monto Total:</th>
                            <td><?php echo $helper->getPrecioCarrito($pedido['monto_total']); ?></td>
                        </tr>
                    </table>
                </div>
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="row">
            <div class="col-xs-6">
                <div id="map"></div>
            </div>
        </div><!-- /.row -->
        <!-- this row will not appear when printing -->
        <div class="row no-print" style="margin-top: 10px;">
            <div class="col-xs-12">
                <!--<a href="invoice-print.html" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Imprmir</a>-->
                <button class="btn btn-success pull-right" data-toggle="modal" data-target="#pagos"><i class="fa fa-credit-card"></i> Modificar Pago</button>
                <button class="btn btn-primary pull-right" style="margin-right: 5px;" data-toggle="modal" data-target="#pedidos"><i class="fa fa-download"></i> Modificar Pedido</button>
            </div>
        </div>
    </section><!-- /.content -->
    <div class="clearfix"></div>
</div>
<!-- Modal PAGOS -->
<div class="modal fade" id="pagos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modificar Estado Pago</h4>
            </div>
            <form method="post" action="<?php echo URL; ?>admin/modificarEstadoPago">
                <div class="modal-body">
                    <h4>Estado Actual: <?php echo utf8_encode($pedido['estado_pago']); ?></h4>
                    <div class="form-group">
                        <label>Estados</label>
                        <select class="form-control" name="pedido[estado_pago]">
                            <?php foreach ($estadoPago as $item): ?>
                                <option value="<?php echo utf8_encode($item); ?>"><?php echo utf8_encode($item); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" value="<?php echo $pedido['id']; ?>" name="pedido[id]" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Modificar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- END Modal PAGOS -->
<!-- Modal PEDIDOS -->
<div class="modal fade" id="pedidos" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modificar Estado Pedido</h4>
            </div>
            <form method="post" action="<?php echo URL; ?>admin/modificarEstadoPedido">
                <div class="modal-body">
                    <h4>Estado Actual: <?php echo utf8_encode($pedido['estado_pedido']); ?></h4>
                    <div class="form-group">
                        <label>Estados</label>
                        <select class="form-control" name="pedido[estado_pedido]">
                            <?php foreach ($estadoPedido as $item): ?>
                                <option value="<?php echo utf8_encode($item); ?>"><?php echo utf8_encode($item); ?></option>
                            <?php endforeach; ?>
                        </select>
                        <input type="hidden" value="<?php echo $pedido['id']; ?>" name="pedido[id]" />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Modificar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div><!-- END Modal PEDIDOS -->
<script>
    /* <![CDATA[ */
    jQuery(document).ready(function ($) {
        'use strict';

        // GOOGLE MAPS START
        window.marker = null;

        function initialize() {
            var map;
            var myLatLng = {lat: <?php echo $pedido['map_latitude']; ?>, lng: <?php echo $pedido['map_longitude']; ?>};
            var style = [
                {"featureType": "road",
                    "elementType":
                            "labels.icon",
                    "stylers": [
                        {"saturation": 1},
                        {"gamma": 0},
                        {"visibility": "on"},
                        {"hue": "#e6ff00"}

                    ]
                },
                {"elementType": "geometry", "stylers": [
                        {"saturation": -100},
                        {"lightness": 25}
                    ]
                }
            ];

            var mapOptions = {
                // SET THE CENTER
                center: myLatLng,
                // SET THE MAP STYLE & ZOOM LEVEL
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                zoom: 16,
                // SET THE BACKGROUND COLOUR
                backgroundColor: "#ccc",
                // REMOVE ALL THE CONTROLS EXCEPT ZOOM
                panControl: true,
                zoomControl: true,
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                overviewMapControl: true,
                scrollwheel: false,
                zoomControlOptions: {
                    style: google.maps.ZoomControlStyle.SMALL
                }

            };
            map = new google.maps.Map(document.getElementById('map'), mapOptions);

            // SET THE MAP TYPE
            var mapType = new google.maps.StyledMapType(style, {name: "Grayscale"});
            map.mapTypes.set('grey', mapType);
            map.setMapTypeId('grey');

            //CREATE A CUSTOM PIN ICON
            var marker_image = '<?php echo IMAGES; ?>/markbig.png';
            var pinIcon = new google.maps.MarkerImage(marker_image, null, null, null, new google.maps.Size(78, 111));


            var marker = new google.maps.Marker({
                position: myLatLng,
                map: map,
                icon: pinIcon,
                title: 'Casa Central!'
            });

            var center;
            function calculateCenter() {
                center = map.getCenter();
            }
            google.maps.event.addDomListener(map, 'idle', function () {
                calculateCenter();
            });
            google.maps.event.addDomListener(window, 'resize', function () {
                map.setCenter(center);
            });
        }

        google.maps.event.addDomListener(window, 'load', initialize);
    });
    /* ]]> */
</script>