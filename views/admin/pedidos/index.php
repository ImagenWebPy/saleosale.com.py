<?php 
$helper = new Helper(); 
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de Pedidos
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Pedidos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <div class="col-md-12">
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
                        <?php echo $this->pedidosPaginacion; ?>
                        <div class="table-responsive">
                            <table class="table no-margin">
                                <thead>
                                    <tr>
                                        <th>Orden #</th>
                                        <th>Cliente</th>
                                        <th style="width: 250px;">Productos</th>
                                        <th>Forma Pago</th>
                                        <th>Estado Pago</th>
                                        <th>Estado Pedido</th>
                                        <th>Monto Pedido</th>
                                        <th>Fecha Pedido</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->pedidosPaginados as $item): ?>
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
                                            <td><a href="#"><?php echo $item['id']; ?></a></td>
                                            <td><?php echo utf8_encode($item['cliente']); ?></td>
                                            <td><?php echo utf8_encode($item['producto']); ?></td>
                                            <td><?php echo utf8_encode($item['forma_pago']); ?></td>
                                            <td><span class="label <?php echo $labelPago; ?>"><?php echo utf8_encode($item['estado_pago']); ?></span></td>
                                            <td><span class="label <?php echo $labelPedido; ?>"><?php echo utf8_encode($item['estado_pedido']); ?></span></td>
                                            <td><?php echo $helper->getPrecioCarrito($item['monto_total']); ?></td>
                                            <td><div class="sparkbar" data-color="#00a65a" data-height="20"><?php echo date('d-m-Y H:i:s', strtotime($item['fecha_pedido'])); ?></div></td>
                                            <td><a href="<?php echo URL; ?>admin/pedido/<?php echo $item['id']; ?>" class="btn btn-app"><i class="fa fa-inbox"></i> Ver Pedido</a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div><!-- /.table-responsive -->
                    </div><!-- /.box-body -->
                    <?php echo $this->pedidosPaginacion; ?>
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->