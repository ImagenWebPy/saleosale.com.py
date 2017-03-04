<?php
$helper = new Helper();
$usuarios = $this->getUsuarios;
$niveles = $helper->getEnumOptions('admin_usuario', 'nivel');
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Usuarios
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Usuarios</a></li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <?php
                        if (!empty($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <button class="btn btn-primary pull-right" data-toggle="modal" data-target="#agregarUsuario">Agregar</button>
                    </div><!-- /.box-header -->
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Nivel</th>
                                <th>Acciones</th>
                            </tr>
                            <?php foreach ($usuarios as $item): ?>
                                <tr>
                                    <td><?= utf8_encode($item['nombre']); ?></td>
                                    <td><?= utf8_encode($item['email']); ?></td>
                                    <td><?= utf8_encode($item['nivel']); ?></td>
                                    <td>
                                        <a class="btn btn-app" data-toggle="modal" data-target="#editarUsuario<?= $item['id']; ?>"><i class="fa fa-edit"></i> Editar</a>
                                        <a class="btn btn-app"><i class="fa fa-trash-o" data-toggle="modal" data-target="#eliminarUsuario<?= $item['id']; ?>"></i> Eliminar</a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editarUsuario<?= $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editarUsuario<?= $item['id']; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Editar Usuario</h4>
                                            </div>
                                            <form method="post" action="<?= URL ?>admin/modificarUsuario">
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="nombre">Nombre</label>
                                                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" required value="<?= utf8_encode($item['nombre']); ?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" placeholder="Email" name="email" required value="<?= utf8_encode($item['email']); ?>" disabled>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="nivel">Nivel</label>
                                                        <select class="form-control" required name="nivel">
                                                            <?php foreach ($niveles as $value): ?>
                                                                <?php
                                                                $selected = ($value == $item['nivel'] ? 'selected' : '');
                                                                ?>
                                                                <option value="<?= $value; ?>" <?= $selected; ?>><?= $value; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </div>
                                                    <hr>
                                                    <?php echo $helper->messageAlert('info', 'Solo complete los campos de contraseña si desea cambiarlas'); ?>
                                                    <div class="form-group">
                                                        <label for="contrasena">Contraseña</label>
                                                        <input type="password" id="contrasena" class="form-control" placeholder="Contraseña" name="contrasena">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="contrasena2">Repetir Contraseña</label>
                                                        <input type="password" id="contrasena2" class="form-control" placeholder="Contraseña" name="contrasena2">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?= $item['id']; ?>" name="id" />
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-primary" id="btn-agregar">Modificar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="eliminarUsuario<?= $item['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="eliminarUsuario<?= $item['id']; ?>">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <form method="post" action="<?= URL ?>admin/eliminarUsuario">
                                                <div class="modal-header bg-danger">
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                    <h4 class="modal-title" id="myModalLabel">Eliminar Usuario</h4>
                                                </div>
                                                <div class="modal-body">
                                                    ¿Está seguro que desea eliminar este usuario "<?= utf8_encode($item['nombre']); ?>"?
                                                </div>
                                                <div class="modal-footer">
                                                    <input type="hidden" value="<?= $item['id']; ?>" name="id" />
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
                <div class="modal fade" id="agregarUsuario" tabindex="-1" role="dialog" aria-labelledby="agregarUsuario">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header bg-primary">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Agregar Usuario</h4>
                            </div>
                            <form method="post" action="<?= URL ?>admin/agregarUsuario" id="frm-agregar">
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="nombre">Nombre</label>
                                        <input type="text" class="form-control" placeholder="Nombre" name="nombre" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" placeholder="Email" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="nivel">Nivel</label>
                                        <select class="form-control" required name="nivel">
                                            <?php foreach ($niveles as $item): ?>
                                                <option value="<?= $item; ?>"><?= $item; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                    <hr>
                                    <div class="form-group">
                                        <label for="contrasena">Contraseña</label>
                                        <input type="password" id="contrasena" class="form-control" placeholder="Contraseña" name="contrasena" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="contrasena2">Repetir Contraseña</label>
                                        <input type="password" id="contrasena2" class="form-control" placeholder="Contraseña" name="contrasena2" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" id="btn-agregar">Agregar</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->