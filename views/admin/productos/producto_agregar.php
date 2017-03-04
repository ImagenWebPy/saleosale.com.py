<?php
$helper = new Helper();
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Agregar Producto
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Productos</a></li>
            <li class="active">Agregar</li>
        </ol>
        <?php
        if (isset($_SESSION['message'])) {
            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
        }
        ?>
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- SELECT2 EXAMPLE -->
        <div class="box box-default">
            <div class="box-header with-border">
                <div class="box-tools pull-right">
                    <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button class="btn btn-box-tool" data-widget="remove"><i class="fa fa-remove"></i></button>
                </div>
            </div><!-- /.box-header -->
            <div class="box-body">
                <form enctype="multipart/form-data" action="<?php echo URL; ?>admin/addProduct" method="post" id="addProducto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-control select2" id="categoria" style="width: 100%;" name="producto[categoria]">
                                    <?php foreach ($this->getCategoriasPadre as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo utf8_encode($item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Sub-Categoría</label>
                                <select class="form-control select2" id="sub-categoria" style="width: 100%;" name="producto[subcategoria]">
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca</label>
                                <select class="form-control select2" style="width: 100%;" name="producto[marca]">
                                    <?php foreach ($this->getMarcas as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo utf8_encode($item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre del Producto" value="" name="producto[nombre]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Moneda</label>
                                <select class="form-control select2" style="width: 100%;" name="producto[moneda]">
                                    <?php foreach ($this->getMonedas as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo utf8_encode($item['simbolo'] . ' - ' . $item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio</label>
                                        <input type="number" class="form-control" placeholder="Precio del Producto" value="" name="producto[precio]">
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio Oferta</label>
                                        <input type="number" class="form-control" placeholder="Precio Oferta del Producto" value="" name="producto[precio_oferta]">
                                    </div><!-- /.form-group -->
                                </div>
                            </div>
                        </div><!-- /.col -->
                        <hr>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" value="" placeholder="Stcok" name="producto[stock]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" class="form-control" value="" placeholder="Codigo del Producto" name="producto[codigo]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <?php $checked = 'checked="checked" '; ?>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="producto[nuevo]">
                                        Nuevo
                                    </label>
                                </div>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="producto[estado]">
                                        Estado
                                    </label>
                                </div>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Breve <small>Descripción</small></h3>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea class="textarea" id="descripcion" name="producto[descripcion]"></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Descripcion <small>Larga</small></h3>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea id="contenido" rows="10" cols="80" name="producto[contenido]"></textarea>                           
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Tags <small>Lista separada por comas(,)</small></h3>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea rows="10" cols="80" name="producto[tags]"></textarea>                           
                                </div>
                            </div>
                        </div>

                    </div><!-- /.box-body -->
                    <hr>

                    <div class="row">
                        <div class="box-header">
                            <h3 class="box-title">Imagenes</h3>
                            <!-- tools box -->
                        </div><!-- /.box-header -->
                    </div><!-- /.box -->
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group" id="img-entrega">
                                <label class="text-info">Suba una imagenes del producto</label>
                                <input type="file" name="upload_file[]">
                                <button class="add_more">Agregar más archivos</button>
                                <p class="text-danger" style="font-size: 12px;">Solo se permiten imagenes(JPG, PNG, BMP, GIF)</p>
                            </div>
                            <div class='progress' id="progress_div">
                                <div class='bar' id='bar1'></div>
                                <div class='percent' id='percent1'>0%</div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-primary btn-flat" type="submit">Agregar Producto</button>
                        </div>
                    </div>
                </form>
            </div>
    </section><!-- /.content -->
    <script type="text/javascript">
        $(document).ready(function () {
            //COMBO DEPENDIENTE
            $('#categoria').change(function () {
                $.ajax({
                    url: "<?php echo URL; ?>admin/loadSubCategoria",
                    type: 'get',
                    dataType: 'json',
                    data: {
                        idPadre: $(this).val()
                    },
                    success: function (data) {
                        var select = $('#sub-categoria');
                        select.html("");
                        $.each(data, function (index, data) {
                            select.append($('<option>', {
                                value: data['id'],
                                text: data['descripcion']
                            }));
                        })
                    }
                }); //END AJAX
            });
            //AGREGAR MAS IMAGENES
            $('.add_more').click(function (e) {
                e.preventDefault();
                $(this).before("<input name='upload_file[]' type='file'/>");
            });
        });
    </script>
</div><!-- /.content-wrapper -->