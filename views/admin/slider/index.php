<?php
$sliders = $this->getSlider;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Slider
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Banners</a></li>
            <li class="active">Slider</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#agregarSlider">Agregar</button>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Orden</th>
                                <th>Imagen</th>
                                <th>Texto 1</th>
                                <th>Texto 2</th>
                                <th>Acción</th>
                            </tr>
                            <?php if (!empty($sliders)): ?>
                                <?php foreach ($sliders as $item): ?>
                                    <tr>
                                        <td><?= $item['orden']; ?></td>
                                        <td style="width: 145px;"><img src="<?= IMAGES . $item['imagen']; ?>" style="width: 100%;"></td>
                                        <td><?= utf8_encode($item['texto_1']); ?></td>
                                        <td><?= utf8_encode($item['texto_2']); ?></td>
                                        <td>
                                            <a class="btn btn-app"><i class="fa fa-edit" data-toggle="modal" data-target="#editar<?= $item['id'] ?>"></i>Editar</a>
                                            <a class="btn btn-app"><i class="fa fa-trash-o" data-toggle="modal" data-target="#eliminar<?= $item['id'] ?>"></i>Eliminar</a></td>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="editar<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                </div>
                                                <form method="post" action="<?= URL; ?>admin/editarSlider" enctype="multipart/form-data">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-3">
                                                                <img src="<?= IMAGES . $item['imagen']; ?>" style="width: 100%;" />
                                                            </div>
                                                            <div class="col-md-9">
                                                                <div class="alert alert-info alert-dismissible" role="alert">
                                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                    Solo suba una imagen si desea cambiarla
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="imagen">Imagen</label>
                                                                    <input type="file" name="imagen">
                                                                    <p class="help-block">jpg, gif, png</p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="texto_1">Texto 1</label>
                                                                    <textarea class="form-control" rows="3" name="texto_1"><?= utf8_encode($item['texto_1']); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="texto_2">Texto 2</label>
                                                                    <textarea class="form-control" rows="3" name="texto_2"><?= utf8_encode($item['texto_2']); ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="texto_3">Texto 3</label>
                                                                    <textarea class="form-control" rows="3" name="texto_3"><?= utf8_encode($item['texto_3']); ?></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="texto_enlace">Texto Enlace</label>
                                                                    <input type="text" name="texto_enlace" value="<?= utf8_encode($item['texto_enlace']); ?>" style="width: 100%;" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="form-group">
                                                                    <label for="orden">Orden</label><br>
                                                                    <input type="number" name="orden" value="<?= utf8_encode($item['orden']); ?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <label for="enlace">Enlace</label>
                                                                    <input type="text" name="enlace" value="<?= utf8_encode($item['enlace']); ?>" style="width: 100%;"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <input type="hidden" value="<?= $item['id']; ?>" name="id" />
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="eliminar<?= $item['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Modal title</h4>
                                                </div>
                                                <form method="POST" action="<?= URL; ?>admin/eliminarSlider">
                                                    <div class="modal-body">
                                                        ¿Esta seguro que desea eliminar este Slider? 
                                                        <input type="hidden" name="id" value="<?= $item['id']; ?>" />
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Eliminar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5">
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                            Aún no se han cargado items en esta categoría
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div><!-- /.box-body -->
                    <div class="modal fade" id="agregarSlider" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title" id="myModalLabel">Agregar Slider</h4>
                                </div>
                                <form method="post" action="<?= URL; ?>admin/agregarSlider" enctype="multipart/form-data">
                                    <div class="modal-body">
                                        <div class="row">
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="imagen">Imagen</label>
                                                    <input type="file" name="imagen">
                                                    <p class="help-block">jpg, gif, png</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="texto_1">Texto 1</label>
                                                    <textarea class="form-control" rows="3" name="texto_1"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="texto_2">Texto 2</label>
                                                    <textarea class="form-control" rows="3" name="texto_2"></textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="texto_3">Texto 3</label>
                                                    <textarea class="form-control" rows="3" name="texto_3"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="texto_enlace">Texto Enlace</label>
                                                    <input type="text" name="texto_enlace" value="" style="width: 100%;"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="orden">Orden</label><br>
                                                    <input type="number" name="orden" value="" />
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="enlace">Enlace</label>
                                                    <input type="text" name="enlace" value="" style="width: 100%;"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                        <button type="submit" class="btn btn-primary">Agregar Slider</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div><!-- /.box -->
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->