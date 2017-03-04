<?php
$helper = new Helper();
$emails = $this->getConfigCms;
?>
<div class="content-wrapper">
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Correos Electrónicos</h3>
                        <?= $helper->messageAlert('info', 'Puede ingresar varias direcciones de correo separadas por coma (,)'); ?>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Sección</th>
                                <th>E-mails</th>
                                <th>Acción</th>
                            </tr>
                            <?php foreach ($emails as $item): ?>
                                <tr>
                                    <td><?= utf8_encode($item['clave']); ?></td>
                                    <td>
                                        <input type="text" id="valor<?= $item['id']; ?>" class=" block form-control" value="<?= utf8_encode($item['valor']); ?>">
                                        <input type="hidden" id="clave<?= $item['id']; ?>" value="<?= utf8_encode($item['id']); ?>">
                                    </td>
                                    <td><button class="btn btn-primary" id="guardar<?= $item['id']; ?>">Guardar Cambios</button></td>
                                </tr>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $("#guardar<?= $item['id']; ?>").click(function () {
                                            var valor = $('#valor<?= $item['id']; ?>').val();
                                            var id = $('#clave<?= $item['id']; ?>').val();
                                            $.ajax({
                                                type: 'POST',
                                                url: '<?= URL; ?>admin/editarConfig',
                                                data: {id: id, valor: valor},
                                                success: function (data) {
                                                    location.reload();
                                                },
                                            });
                                        });
                                    });
                                </script>
                            <?php endforeach; ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div>