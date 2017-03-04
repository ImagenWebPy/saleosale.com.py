<?php
$helper = new Helper();
$secciones = $this->secciones;
?>
<div class="content-wrapper">
    <section class="content">
        <?php
        if (isset($_SESSION['message'])) {
            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
        }
        ?>
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sección</h3>
                    </div><!-- /.box-header -->
                    <div class="box-body">
                        <form role="form">
                            <!-- select -->
                            <div class="form-group">
                                <label>Seleccione una sección</label>
                                <select class="form-control" id="select-destacados">
                                    <option value="0_<?php echo URL; ?>">Secciones</option>
                                    <?php foreach ($secciones as $item): ?>
                                        <option value="<?php echo $item['id']; ?>_<?php echo URL; ?>"><?php echo utf8_encode($item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!--/.col (right) -->
            <div class="col-md-12" style=" display: none;" id="productos">
                <div class="box box-warning" id="displayTable">

                </div><!-- /.box-body -->
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->