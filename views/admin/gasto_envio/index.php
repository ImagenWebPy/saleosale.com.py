<?php
$helper = new Helper();
$zonas = $this->zonas;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Gastos de envío
        </h1>
        <ol class="breadcrumb">
            <li><a href="/"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Gastos de Envíos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Zonas de Envío</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#zonas">Definir zonas de envío</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
            <div class="col-md-6">
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Zonas de Envío</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        </div><!-- /.box-tools -->
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <button class="btn btn-block btn-primary" data-toggle="modal" data-target="#ciudades">Cuidades</button>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
        <div class="modal fade" id="zonas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-primary">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Zonas de Envío</h4>
                    </div>
                    <div class="modal-body">
                        <div class="box-body">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <th style="width: 20%;">Descripción</th>
                                        <th style="width: 20%;">Costo</th>
                                        <th style="width: 60px">Acciones</th>
                                    </tr>
                                    <?php foreach ($zonas as $item): ?>
                                        <tr>
                                            <td><?php echo utf8_encode($item['descripcion']); ?></td>
                                            <td><?php echo $helper->getPrecioCarrito($item['costo']); ?></td>
                                            <td>
                                                <a class="btn btn-app" id="editar<?php echo $item['id']; ?>">
                                                    <i class="fa fa-edit"></i> Editar Zona
                                                </a>
                                                <a class="btn btn-app" id="agregar<?php echo $item['id']; ?>">
                                                    <i class="fa fa-plus"></i> Agregar Ciudad
                                                </a>
                                                <a class="btn btn-app" id="editar<?php echo $item['id']; ?>">
                                                    <i class="fa fa-times "></i> Quitar Ciudad
                                                </a>
                                            </td>
                                        </tr>
                                        <tr id="cellEditar<?= $item['id'] ?>" style="display: none;">
                                    <form method="POST" action="<?= URL ?>admin/modificarZona">
                                        <td>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Zona</label>
                                                <input type="text" class="form-control" name="txtDescripcion" value="<?php echo utf8_encode($item['descripcion']); ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <label for="exampleInputEmail1">Costo</label>
                                                <input type="text" class="form-control" name="txtCosto" value="<?php echo round($item['costo']); ?>">
                                            </div>
                                        </td>
                                        <td>
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>" >
                                            <input type="submit" class="btn btn-block btn-primary" value="Guardar">
                                        </td>
                                    </form>
                                    </tr>
                                    <script type="text/javascript">
                                        $(document).ready(function () {
                                            $("#editar<?php echo $item['id']; ?>").click(function () {
                                                $('#cellEditar<?= $item['id'] ?>').css("display", "");
                                            });
                                        });
                                    </script>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="button" class="btn btn-primary">Guardar</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ciudades" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Definir zona de envio por ciudad</h4>
                    </div>
                    <div class="modal-body">
                        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                            <?php foreach ($zonas as $item): ?>
                                <?php $ciudades = $helper->getCiudadesZonas($item['id']); ?>
                                <div class="panel panel-default">
                                    <div class="panel-heading" role="tab" id="heading<?= $item['id']; ?>">
                                        <h4 class="panel-title">
                                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?= $item['id']; ?>" aria-expanded="false" aria-controls="collapse<?= $item['id']; ?>">
                                                <?= utf8_encode($item['descripcion']); ?>
                                            </a>
                                        </h4>
                                    </div>
                                    <div id="collapse<?= $item['id']; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?= $item['id']; ?>">
                                        <div class="panel-body">
                                            <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#addCiudad<?= $item['id']; ?>"><i class="fa fa-plus-circle" aria-hidden="true"></i> Agregar Ciudad</button>
                                            <table class="table table-striped">
                                                <tr>
                                                    <th>Ciudad</th>
                                                    <th>Departamento</th>
                                                    <th>Acción</th>
                                                </tr>
                                                <?php if (!empty($ciudades)): ?>
                                                    <?php foreach ($ciudades as $value): ?>
                                                        <tr>
                                                            <td><?= utf8_encode($value['ciudad']); ?></td>
                                                            <td><?= utf8_encode($value['departamento']); ?></td>
                                                            <td><button class="btn btn-danger" data-toggle="modal" data-target="#quitarCiudad<?= $value['id']; ?>"><i class="fa fa-times-circle" aria-hidden="true"></i></button></td>
                                                        </tr>
                                                        <div class="modal fade" id="quitarCiudad<?= $value['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                            <div class="modal-dialog" role="document">
                                                                <div class="modal-content">
                                                                    <form method="post" action="<?= URL ?>admin/delCity">
                                                                        <div class="modal-header bg-danger">
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                                            <h4 class="modal-title" id="myModalLabel">Quitar Ciudad</h4>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            ¿Esta seguro que desea quitar la ciudad "<?= utf8_encode($value['ciudad']); ?>" de la zona "<?= utf8_encode($item['descripcion']); ?>"?
                                                                        </div>
                                                                        <input type="hidden" value="<?= $value['id']; ?>" name="id_ciudad" />
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
                                                                            <button type="submit" class="btn btn-danger" id="delCiudad<?= $value['id']; ?>">Quitar</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </table>
                                            <div class="modal fade" id="addCiudad<?= $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-primary">
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                            <h4 class="modal-title" id="myModalLabel">Agregar Ciudad</h4>
                                                        </div>
                                                        <form method="POST" action="<?= URL ?>admin/saveCity/">
                                                            <div class="modal-body">
                                                                <select class="form-control" name="ciudades">
                                                                    <?php foreach ($this->getDepartamentos as $departamentos): ?>
                                                                        <optgroup label="<?= utf8_encode($departamentos['departamento']) ?>">
                                                                            <?php
                                                                            $cities = $helper->getCiudadesDepartamentos($departamentos['id']);
                                                                            ?>
                                                                            <?php foreach ($cities as $data): ?>
                                                                                <option value="<?= $data['id']; ?>"><?= utf8_encode($data['ciudad']); ?></option>
                                                                            <?php endforeach; ?>
                                                                        </optgroup>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                                <input type="hidden" value="<?= $item['id']; ?>" name="zona" />
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-default" data-dismiss="modal" >Cerrar</button>
                                                                <button type="submit" class="btn btn-primary">Agregar</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->