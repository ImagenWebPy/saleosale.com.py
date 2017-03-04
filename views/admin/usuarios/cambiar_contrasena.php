<?php $helper = new Helper(); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Cambiar Contraseña
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Usuario</a></li>
            <li class="active">Cambiasr Contraseña</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="box box-primary">
                    <?php
                    if (!empty($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <!-- form start -->
                    <form role="form" action="<?= URL; ?>admin/cambiarUserPass" method="post" id="frm-cambiarPsss">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="contrasena">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
                            </div>
                            <div class="form-group">
                                <label for="repetir-contrasena">Repetir Contraseña</label>
                                <input type="password" class="form-control" id="repetir-contrasena" name="repetir-contrasena" placeholder="Repetir Contraseña">
                            </div>

                        </div><!-- /.box-body -->
                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?= $_SESSION['admin']['id']; ?>" />
                            <button type="button" class="btn btn-primary" id="btn-cambiarPass">Cambiar</button>
                        </div>
                    </form>
                </div><!-- /.box -->
            </div><!--/.col (left) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<script type="text/javascript">
    $(document).ready(function () {
        $("#btn-cambiarPass").click(function () {
            var pass1 = $('#contrasena').val();
            var pass2 = $('#repetir-contrasena').val();
            if (pass1 != '' && pass2 != '') {
                if (pass1 == pass2) {
                    $('#frm-cambiarPsss').submit();
                } else {
                    alert('Las contraseñas deben ser coincidir');
                }
            } else {
                alert('Las contraseñas no pueden permanecer vacías');
            }
        });
    });
</script>