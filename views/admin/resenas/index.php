<?php
$helper = new Helper();
$resenas = $this->resenasPaginados;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Reseñas
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= URL; ?>admin/"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Reseñas</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <?php if (!empty($resenas)): ?>
                    <div class="box">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <div class="box-body table-responsive no-padding">
                            <?php echo $this->resenasPaginacion; ?>
                            <table class="table table-hover">
                                <tr>
                                    <th>Cliente</th>
                                    <th>Producto</th>
                                    <th>Reseña</th>
                                    <th>Fecha Reseña</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                                <?php foreach ($resenas as $item): ?>
                                    <?php ($item['aprobado'] == 1) ? $label = array('success', 'Aprovada') : $label = array('danger', 'No Aprovada'); ?>
                                    <tr>
                                        <td><?= utf8_encode($item['cliente']); ?></td>
                                        <td><?= utf8_encode($item['nombre']); ?></td>
                                        <td><?= substr(utf8_encode($item['opinion']), 0, 80); ?>...</td>
                                        <td><?= date('d-m-Y H:i:s', strtotime($item['fecha_valorizacion'])); ?></td>
                                        <td><span class="label label-<?= $label[0]; ?>"><?= $label[1]; ?></span></td>
                                        <td><a data-toggle="modal" data-target="#resena<?= $item['id']; ?>" style=" cursor: pointer;">Ver Reseña</a></td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="resena<?= $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-primary">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Reseña</h4>
                                                </div>
                                                <form method="POST" action="<?= URL; ?>admin/modificarResena">
                                                    <div class="modal-body">
                                                        <dl class="dl-horizontal">
                                                            <dt>Cliente</dt>
                                                            <dd><?= utf8_encode($item['cliente']); ?></dd>
                                                            <dt>Producto</dt>
                                                            <dd><?= utf8_encode($item['nombre']); ?></dd>
                                                            <dt>Titulo Reseña</dt>
                                                            <dd><?= utf8_encode($item['titulo']); ?></dd>
                                                            <dt>Opinion</dt>
                                                            <dd><?= utf8_encode($item['opinion']); ?></dd>
                                                            <dt>Fecha</dt>
                                                            <dd><?= date('d-m-Y H:i:s', strtotime($item['fecha_valorizacion'])); ?></dd>
                                                        </dl>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" value="<?= $item['id']; ?>" name="resena[id]" >
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <?php if ($item['aprobado'] == 1): ?>
                                                            <input type="hidden" value="0" name="resena[estado]" >
                                                            <button type="submit" class="btn btn-danger">No Aprobar</button>
                                                        <?php else: ?>
                                                            <input type="hidden" value="1" name="resena[estado]" >
                                                            <button type="submit" class="btn btn-success">Aprobar</button>
                                                        <?php endif; ?>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </table>
                        </div><!-- /.box-body -->
                    </div><!-- /.box -->
                <?php else: ?>
                    <?= $helper->messageAlert('info', 'Aún no se han cargado reseñas'); ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</div>