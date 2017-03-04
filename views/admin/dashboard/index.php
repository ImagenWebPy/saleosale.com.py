<?php $helper = new Helper(); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Dashboard
            <small>Version 2.0</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Dashboard</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="ion ion-bag"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Productos Activos</span>
                        <span class="info-box-number"><?php echo $this->cantProductos; ?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="ion ion-ios-cart-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Ventas</span>
                        <span class="info-box-number"><?php echo $this->cantVentas; ?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
            <div class="col-md-3 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Clientes</span>
                        <span class="info-box-number"><?php echo $this->cantClientes; ?></span>
                    </div><!-- /.info-box-content -->
                </div><!-- /.info-box -->
            </div><!-- /.col -->
        </div><!-- /.row -->

        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-8">
                <!-- TABLE: LATEST ORDERS -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Pedidos recientes</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Orden #</th>
                                        <th>Productos</th>
                                        <th>Estado Pago</th>
                                        <th>Estado Pedido</th>
                                        <th>Fecha Pedido</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->ultimasOrdenes as $item): ?>
                                        <?php
                                        switch ($item['estado_pedido']) {
                                            case 'Pendiente':
                                                $labelPedido = 'label-warning';
                                                break;
                                            case 'Confirmado':
                                                $labelPedido = 'label-success';
                                                break;
                                            case 'Procesando':
                                                $labelPedido = 'label-info';
                                                break;
                                            case 'En camino al cliente':
                                                $labelPedido = 'label-primary';
                                                break;
                                            case 'Sin stock':
                                                $labelPedido = 'label-danger';
                                                break;
                                            case 'Devuelto':
                                                $labelPedido = 'label-danger';
                                                break;
                                            case 'Cancelado':
                                                $labelPedido = 'label-danger';
                                                break;
                                        }
                                        switch ($item['estado_pago']) {
                                            case 'Pendiente':
                                                $labelPago = 'label-warning';
                                                break;
                                            case 'Procesando Pago':
                                                $labelPago = 'label-info';
                                                break;
                                            case 'Pago Confirmado':
                                                $labelPago = 'label-success';
                                                break;
                                            case 'Error de Pago':
                                                $labelPago = 'label-danger';
                                                break;
                                            case 'Reembolsado':
                                                $labelPago = 'label-danger';
                                                break;
                                        }
                                        ?>
                                        <tr>
                                            <td><a href="<?= URL; ?>admin/pedido/<?php echo $item['id']; ?>"><?php echo $item['id']; ?></a></td>
                                            <td><?php echo utf8_encode($item['producto']); ?></td>
                                            <td><span class="label <?php echo $labelPago; ?>"><?php echo utf8_encode($item['estado_pago']); ?></span></td>
                                            <td><span class="label <?php echo $labelPedido; ?>"><?php echo utf8_encode($item['estado_pedido']); ?></span></td>
                                            <td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date('d-m-Y H:i:s', strtotime($item['fecha_pedido'])); ?></div></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <div class="box-footer clearfix">
                        <a href="<?= URL ?>admin/pedidos" class="btn btn-sm btn-default btn-flat pull-right">Ver todas las ordenes</a>
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col -->

            <div class="col-md-4">
                <!-- PRODUCT LIST -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Productos recientemente agregados</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                            <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <ul class="products-list product-list-in-box">
                            <?php
                            foreach ($this->ultimosProductos as $item):
                                $imagen = explode('|', $item['imagen']);
                                ?>
                                <li class="item">
                                    <div class="product-img">
                                        <img src="<?php echo IMAGE_PRODUCT . $imagen[0] ?>" alt="<?php echo utf8_encode($item['nombre']); ?>">
                                    </div>
                                    <div class="product-info">
                                        <a href="<?= URL; ?>admin/producto/<?= $item['id']; ?>" class="product-title"><?php echo utf8_encode($item['nombre']); ?> <span class="label label-warning pull-right"><?php echo $helper->getProductoPrecio($item['id'])['precio']; ?></span></a>
                                        <span class = "product-description">
                                            <?php echo strip_tags(substr(utf8_encode($item['descripcion']), 0, 160));
                                            ?>
                                        </span>
                                    </div>
                                </li><!-- /.item -->
                            <?php endforeach; ?>
                        </ul>
                    </div><!-- /.box-body -->
                    <div class="box-footer text-center">
                        <a href="<?= URL ?>/admin/productos" class="uppercase">Ver todos los productos</a>
                    </div><!-- /.box-footer -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->