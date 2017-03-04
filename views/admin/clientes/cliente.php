<?php
$cliente = $this->getCliente;
$documento = $this->getDocumento;
$documentos = $this->getDocumentos;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cliente
            <small>Editar</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li><a href="#">Clientes</a></li>
            <li class="active">Editar</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-6">
                <!-- general form elements -->
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos del Cliente</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form role="form">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cliente[nombre]">Nombre</label>
                                <input type="text" class="form-control" name="cliente[nombre]"  placeholder="Ingrese el Nombre" value="<?php echo utf8_encode($cliente['nombre']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cliente[apellido]">Apellido</label>
                                <input type="text" class="form-control" name="cliente[apellido]"  placeholder="Ingrese el Apellido" value="<?php echo utf8_encode($cliente['apellido']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cliente[nombre]">Tipo Documento</label>
                                <select name="cliente[id_tipo_documento]" class="form-control">
                                    <?php if (!empty($documento['id_tipo_documento'])): ?>
                                        <option value="<?php echo $documento['id_tipo_documento']; ?>"><?php echo $documento['descripcion']; ?></option>
                                    <?php else: ?>
                                        <option value="0">Seleccione un tipo de Documento</option>
                                    <?php endif; ?>
                                    <?php foreach ($documentos as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo $item['descripcion']; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="cliente[documento_nro]">Documento Nro.</label>
                                <input type="text" class="form-control" name="cliente[documento_nro]"  placeholder="Ingrese el Nro de Documento" value="<?php echo utf8_encode($cliente['documento_nro']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cliente[email]">E-mail</label>
                                <input type="text" class="form-control" name="cliente[email]"  placeholder="Ingrese el E-mail" value="<?php echo utf8_encode($cliente['email']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cliente[telefono]">Teléfono</label>
                                <input type="text" class="form-control" name="cliente[telefono]"  placeholder="Ingrese el Teléfono" value="<?php echo utf8_encode($cliente['telefono']); ?>">
                            </div>
                            <div class="form-group">
                                <label for="cliente[celular]">Celular</label>
                                <input type="text" class="form-control" name="cliente[celular]"  placeholder="Ingrese el Celular" value="<?php echo utf8_encode($cliente['celular']); ?>">
                            </div>
                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
                <!-- Horizontal Form -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Cambiar Contraseña</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cliente[contrasena]" class="col-sm-2 control-label">Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="cliente[contrasena]" placeholder="Contraseña">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="cliente[contrasena2]" class="col-sm-2 control-label">Repetir Contraseña</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="cliente[contrasena2]" placeholder="Contraseña">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Cambiar</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->
                <div class="box box-info">
                    <div class="box-header with-border">
                        <h3 class="box-title">Datos Facebook</h3>
                    </div><!-- /.box-header -->
                    <!-- form start -->
                    <form class="form-horizontal">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="cliente[facebook_email]" class="col-sm-2 control-label">E-mail</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="cliente[facebook_email]" placeholder="Ingres una direccion de E-mail" value="<?php echo $cliente['facebook_email']; ?>">
                                </div>
                            </div>
                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <button type="submit" class="btn btn-info pull-right">Cambiar</button>
                        </div><!-- /.box-footer -->
                    </form>
                </div><!-- /.box -->
                <!-- general form elements disabled -->
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->