<?php $helper = new Helper(); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Listado de Clientes
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Listado de Clientes</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-body">
                        <div class="pull-left">
                            <?php echo $this->clientesPaginacion; ?>
                        </div>
                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Fecha Registro</th>
                                    <th>Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($this->clientesPaginados as $item): ?>
                                <?php $email = (!empty($item['email'])) ? utf8_encode($item['email']) : utf8_encode($item['facebook_email']); ?>
                                    <tr>
                                        <td><?php echo utf8_encode($item['nombre']); ?></td>
                                        <td><?php echo utf8_encode($item['apellido']); ?></td>
                                        <td><?php echo utf8_encode($item['telefono']); ?></td>
                                        <td><?php echo $email; ?></td>
                                        <td><?php echo date('m-d-Y H:i:s', strtotime($item['fecha_registro'])); ?></td>
                                        <td>
                                            <a class="btn btn-app"><i class="fa fa-inbox"></i> Pedidos</a>
                                            <a href="<?php echo URL; ?>admin/cliente/<?php echo $item['id']; ?>" class="btn btn-app"><i class="fa fa-edit"></i>Editar</a>
                                            <a class="btn btn-app"><i class="fa fa-trash-o"></i>Eliminar</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Teléfono</th>
                                    <th>Email</th>
                                    <th>Fecha Registro</th>
                                    <th>Acción</th>
                                </tr>
                            </tfoot>
                        </table>
                        <?php echo $this->clientesPaginacion; ?>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->