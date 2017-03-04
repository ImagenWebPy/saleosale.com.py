<?php
$helper = new Helper();
$solicitudes = $this->getSolicitudes;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Solicitudes
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= URL; ?>admin"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Solicitudes</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Solicitante</th>
                                <th>Teléfono</th>
                                <th>Marca</th>
                                <th>Producto</th>
                                <th>Fecha</th>
                                <th>Ver Solicitud</th>
                            </tr>
                            <?php foreach ($solicitudes as $item): ?>
                                <tr>
                                    <td><?= utf8_encode($item['nombre']); ?></td>
                                    <td><?= utf8_encode($item['telefono']); ?></td>
                                    <td><?= utf8_encode($item['marca']); ?></td>
                                    <td><?= utf8_encode($item['producto']); ?></td>
                                    <td><?= date('d-m-Y H:i:s', strtotime($item['fecha'])); ?></td>
                                    <td><a class="btn btn-app" data-toggle="modal" data-target="#solicitud<?= $item['id']; ?>"><i class="fa fa-eye"></i> Ver Solicitud</a></td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="solicitud<?= $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Solicitud #<?= $item['id']; ?></h4>
                                            </div>
                                            <div class="modal-body">
                                                <dl class="dl-horizontal">
                                                    <dt>Solicitante:</dt>
                                                    <dd><?= utf8_encode($item['nombre']); ?></dd>
                                                    <dt>Fecha Solicitud:</dt>
                                                    <dd><?= date('d-m-Y H:i:s', strtotime($item['fecha'])); ?></dd>
                                                    <dt>Teléfono:</dt>
                                                    <dd><?= $item['telefono']; ?></dd>
                                                    <dt>E-mail:</dt>
                                                    <dd><?= $item['email']; ?></dd>
                                                    <dt>Marca:</dt>
                                                    <dd><?= utf8_encode($item['marca']); ?></dd>
                                                    <dt>Producto:</dt>
                                                    <dd><?= utf8_encode($item['producto']); ?></dd>
                                                    <dt>Cantidad Solicitada:</dt>
                                                    <dd><?= utf8_encode($item['cantidad']); ?></dd>
                                                    <dt>Cantidad Cuotas:</dt>
                                                    <dd><?= utf8_encode($item['cuotas']); ?></dd>
                                                    <dt>Monto Cuota:</dt>
                                                    <dd><?= $item['monto_cuota']; ?></dd>
                                                </dl>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->