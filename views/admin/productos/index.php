<?php $helper = new Helper(); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de Productos
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Listado de Productos</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="pull-left">
                            <?php echo $this->paginacion; ?>
                        </div>
                        <div class="box-tools">
                            <div class="input-group" style="width: 240px; position: relative; left: 50px;">
                                <form method="get" action="<?= URL; ?>admin/productos/">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="buscar" placeholder="Buscar...">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit">Buscar</button>
                                        </span>
                                    </div><!-- /input-group -->
                                </form>
                            </div>
                        </div>
                        <div class="pull-right">
                            <a href="<?php echo URL; ?>admin/producto_agregar/" class="btn btn-block btn-primary btn-flat">Agregar Producto</a>
                        </div>
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->productosPaginados as $item): ?>
                                    <?php
                                    $imagen = explode('|', $item['imagen']);
                                    if ($item['estado'] == 'Activo')
                                        $label = 'label-success';
                                    else
                                        $label = 'label-danger';
                                    ?>
                                    <tr>
                                        <td style=" width: 150px;"><img src="<?php echo IMAGE_PRODUCT . $imagen[0]; ?>" class="img-responsive" /></td>
                                        <td><?php echo utf8_encode($item['nombre']); ?></td>
                                        <td><?php echo utf8_encode($item['descripcion']); ?></td>
                                        <td><?php echo $helper->getProductoPrecio($item['id'])['precio']; ?></td>
                                        <td><span class="label <?php echo $label; ?>"><?php echo utf8_encode($item['estado']); ?></span></td>
                                        <td>
                                            <a href="<?php echo URL; ?>admin/producto/<?php echo $item['id']; ?>" class="btn btn-app"><i class="fa fa-edit"></i>Editar</a>
                                            <a class="btn btn-app"><i class="fa fa-trash-o"></i>Eliminar</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Imagen</th>
                                    <th>Nombre</th>
                                    <th>Marca</th>
                                    <th>Precio</th>
                                    <th>Estado</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo $this->paginacion; ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->