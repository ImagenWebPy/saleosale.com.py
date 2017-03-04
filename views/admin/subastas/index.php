<?php
$helper = new Helper();
$subastas = $this->subastasPaginados;
$label = array();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Subastas
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?= URL; ?>"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Subastas</a></li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Cliente</th>
                                <th>Fecha Inicio</th>
                                <th>Fecha Fin</th>
                                <th>Descripcion Corta</th>
                                <th>Estado</th>
                                <th>Acción</th>
                            </tr>
                            <?php foreach ($subastas as $item): ?>
                                <?php
                                switch (utf8_encode($item['estado'])) {
                                    case 'Revisión':
                                        $label = array('Revisión', 'warning');
                                        break;
                                    case 'Habilitada':
                                        $label = array('Habilitada', 'success');
                                        break;
                                    case 'Incumple':
                                        $label = array('Incumple', 'danger');
                                        break;
                                    case 'Finalizada':
                                        $label = array('Finalizada', 'default');
                                        break;
                                }
                                $estado = $helper->getEnumOptions('subasta', 'estado');
                                ?>
                                <tr>
                                    <td><?= utf8_encode($item['cliente']); ?></td>
                                    <td><?= date('d-m-Y', strtotime($item['fecha_inicio'])); ?></td>
                                    <td><?= date('d-m-Y', strtotime($item['fecha_fin'])); ?></td>
                                    <td><?= $item['descripcion_corta'] ?></td>
                                    <td><?= $helper->showLabel($label[0], $label[1]); ?></td>
                                    <td>
                                        <a class = "btn btn-app" data-toggle = "modal" data-target = "#ver<?= $item['id']; ?>">
                                            <i class = "fa fa-edit"></i> Ver Subasta
                                        </a>
                                    </td>
                                </tr>
                                <!--Modal Subasta -->
                                <div class = "modal fade" id = "ver<?= $item['id']; ?>" tabindex = "-1" role = "dialog" aria-labelledby = "ver<?= $item['id']; ?>">
                                    <div class = "modal-dialog" role = "document">
                                        <div class = "modal-content">
                                            <div class = "modal-header bg-primary">
                                                <button type = "button" class = "close" data-dismiss = "modal" aria-label = "Close"><span aria-hidden = "true">&times;
                                                    </span></button>
                                                <h4 class = "modal-title" id = "myModalLabel" > Subasta #<?= $item['id']; ?></h4>
                                            </div>
                                            <form method="POST" action="<?= URL; ?>admin/modificarSubasta" enctype="multipart/form-data">
                                                <div class="modal-body">
                                                    <dl class="dl-horizontal">
                                                        <dt>Cliente:</dt>
                                                        <dd><?= utf8_encode($item['cliente']); ?></dd>
                                                        <dt>Fecha Inicio:</dt>
                                                        <dd><?= date('d-m-Y', strtotime($item['fecha_inicio'])); ?></dd>
                                                        <dt>Fecha de Fin:</dt>
                                                        <dd><?= date('d-m-Y', strtotime($item['fecha_fin'])); ?></dd>
                                                        <dt>Condicion:</dt>
                                                        <dd><?= utf8_encode($item['condicion']); ?>s</dd>
                                                    </dl>
                                                    <fieldset>
                                                        <input type="hidden" value="<?= $item['id']; ?>" name="subasta[id]" >
                                                        <div class="form-group">
                                                            <label for="subasta[marca]">Marca</label>
                                                            <input type="text" name="subasta[marca]" class="form-control" placeholder="Marca" value="<?= utf8_encode($item['marca']); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="subasta[nombre]">Nombre</label>
                                                            <input type="text" name="subasta[nombre]" class="form-control" placeholder="Nombre" value="<?= utf8_encode($item['nombre']); ?>">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="subasta[estado]">Estado</label>
                                                            <select class="form-control" name="subasta[estado]">
                                                                <?php foreach ($estado as $value): ?>
                                                                    <?php (utf8_encode($value) == utf8_encode($item['estado'])) ? $selected = 'selected' : $selected = ''; ?>
                                                                    <?php (utf8_encode($item['estado']) == $value) ? $selected = 'selected' : $selected; ?>
                                                                    <option value="<?= utf8_encode($value); ?>" <?= $selected; ?>><?= utf8_encode($value); ?></option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="subasta[descripcion_corta]">Descripción Corta</label>
                                                            <textarea class="form-control" rows="3" name="subasta[descripcion_corta]"><?= $item['descripcion_corta']; ?></textarea>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="subasta[contenido]">Contenido</label>
                                                            <textarea class="form-control" rows="3" name="subasta[contenido]"><?= $item['contenido']; ?></textarea>
                                                        </div>
                                                        <div class="row">
                                                            <div class="box-header">
                                                                <h3 class="box-title">Imagenes</h3>
                                                                <!-- tools box -->
                                                            </div><!-- /.box-header -->
                                                            <div class="row">
                                                                <?php
                                                                $imagenes = (!empty($item['imagen'])) ? explode('|', $item['imagen']) : '';
                                                                //$imagenes = '';
                                                                $i = 1;
                                                                ?>
                                                                <?php if (!empty($imagenes)): ?>
                                                                    <?php foreach ($imagenes as $value): ?>
                                                                        <?php $sinExtension = strstr($value, '.', true); ?>
                                                                        <div class="col-md-3">
                                                                            <button type="button" class="btn btn-danger btn-lg btn-xs" data-toggle="modal" data-target="#eliminar-<?= $sinExtension; ?>">
                                                                                <i class="fa fa-times-circle" aria-hidden="true"></i>Eliminar
                                                                            </button>
                                                                            <img src="<?php echo IMAGE_SUBASTA . $value; ?>" class="img-responsive" />
                                                                        </div>
                                                                        <div class="modal fade" id="eliminar-<?= $sinExtension; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                                            <div class="modal-dialog" role="document">
                                                                                <div class="modal-content">
                                                                                    <div class="modal-header bg-danger">
                                                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                                        <h4 class="modal-title" id="myModalLabel">Eliminar Imagen</h4>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        ¿Está seguro que desea la siguiente imagen?
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                        <input type="hidden" id="id-<?= $sinExtension; ?>" value="<?= $item['id']; ?>">
                                                                                        <input type="hidden" id="imagen-<?= $sinExtension; ?>" value="<?= $value; ?>">
                                                                                        <input type="hidden" id="posicion-<?= $sinExtension; ?>" value="<?= $i; ?>">
                                                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                                                        <button type="button" id="btn-delImagen-<?= $sinExtension; ?>" class="btn btn-danger">Eliminar</button>
                                                                                    </div>
                                                                                    <script type="text/javascript">
                                                                                        $(document).ready(function () {
                                                                                            $("#btn-delImagen-<?= $sinExtension; ?>").click(function () {
                                                                                                var id = $('#id-<?= $sinExtension; ?>').val();
                                                                                                var imagen = $('#imagen-<?= $sinExtension; ?>').val();
                                                                                                var posicion = $('#posicion-<?= $sinExtension; ?>').val();
                                                                                                $.ajax({
                                                                                                    url: '<?= URL; ?>admin/eliminarImagenSubasta',
                                                                                                    type: 'POST',
                                                                                                    data: {
                                                                                                        id: id,
                                                                                                        imagen: imagen,
                                                                                                        posicion: posicion
                                                                                                    },
                                                                                                    success: function (data) {
                                                                                                        location.reload();
                                                                                                    }
                                                                                                }); //END AJAX
                                                                                            });

                                                                                        });
                                                                                    </script>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php $i++; ?>
                                                                    <?php endforeach; ?>
                                                                <?php endif; ?>
                                                            </div>
                                                        </div><!-- /.box -->
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                <div class="form-group" id="img-entrega">
                                                                    <label class="text-info">Suba una imagenes del producto</label>
                                                                    <input type="file" name="upload_file[]">
                                                                    <p class="text-danger" style="font-size: 12px;">Solo se permiten imagenes(JPG, PNG, BMP, GIF)</p>
                                                                </div>
                                                                <div class='progress' id="progress_div">
                                                                    <div class='bar' id='bar1'></div>
                                                                    <div class='percent' id='percent1'>0%</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </fieldset>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                </div>
                                            </form>
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
</div>