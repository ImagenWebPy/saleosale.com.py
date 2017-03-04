<?php
$categorias = $this->getPadres;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Categorías
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li class="active">Categorías</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <!-- right column -->
            <div class="col-md-12">
                <!-- general form elements disabled -->
                <div class="box box-warning">
                    <div class="box-body">
                        <form role="form">
                            <!-- select -->
                            <div class="form-group">
                                <label>Categorías</label>
                                <select class="form-control" id="padre">
                                    <option value="0">Seleccione una Categoría</option>
                                    <?php foreach ($categorias as $item): ?>
                                        <option value="<?php echo URL.'_'.$item['id']; ?>"><?php echo utf8_encode($item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <!-- Select multiple-->
                        </form>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!--/.col (right) -->
            <div class="col-md-12" style=" display: none;" id="divHijos">
                <div class="box box-warning" id="tablaHijos">

                </div><!-- /.box-body -->
            </div><!--/.col (right) -->
        </div>   <!-- /.row -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->