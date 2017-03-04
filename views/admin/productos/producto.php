<?php
$helper = new Helper();
$producto = $this->getDatosProductos;
?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Editar Producto
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
            <li><a href="#">Productos</a></li>
            <li class="active">Editar</li>
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
                <form enctype="multipart/form-data" action="<?php echo URL; ?>admin/uploadProduct" method="post" id="editarProducto">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Categoría</label>
                                <select class="form-control select2" id="categoria" style="width: 100%;" name="producto[categoria]">
                                    <option value="<?php echo $this->getCategoriaPadre['id']; ?>"><?php echo utf8_encode($this->getCategoriaPadre['descripcion']); ?></option>
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
                                    <option value="<?php echo $this->getSubCategoria['id']; ?>"><?php echo utf8_encode($this->getSubCategoria['descripcion']); ?></option>
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Marca</label>
                                <select class="form-control select2" style="width: 100%;" name="producto[marca]">
                                    <option value="<?php echo $this->getMarca['id']; ?>"><?php echo utf8_encode($this->getMarca['descripcion']); ?></option>
                                    <?php foreach ($this->getMarcas as $item): ?>
                                        <option value="<?php echo $item['id']; ?>"><?php echo utf8_encode($item['descripcion']); ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" class="form-control" placeholder="Nombre del Producto" value="<?php echo utf8_encode($producto['nombre']); ?>" name="producto[nombre]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->

                    </div><!-- /.row -->
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Moneda</label>
                                <select class="form-control select2" style="width: 100%;" name="producto[moneda]">
                                    <option value="<?php echo $this->getMoneda['id']; ?>"><?php echo utf8_encode($this->getMoneda['simbolo'] . ' - ' . $this->getMoneda['descripcion']); ?></option>
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
                                        <input type="number" class="form-control" placeholder="Nombre del Producto" value="<?php echo utf8_encode($producto['precio']); ?>" name="producto[precio]">
                                    </div><!-- /.form-group -->
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Precio Oferta</label>
                                        <input type="number" class="form-control" placeholder="Nombre del Producto" value="<?php echo utf8_encode($producto['precio_oferta']); ?>" name="producto[precio_oferta]">
                                    </div><!-- /.form-group -->
                                </div>
                            </div>
                        </div><!-- /.col -->
                        <hr>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Stock</label>
                                <input type="number" class="form-control" value="<?php echo utf8_encode($producto['stock']); ?>" name="producto[stock]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Codigo</label>
                                <input type="text" class="form-control" value="<?php echo utf8_encode($producto['codigo']); ?>" name="producto[codigo]">
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <?php $checked = 'checked="checked" '; ?>
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="producto[nuevo]" <?php if ($producto['nuevo'] == 1) echo $checked; ?>>
                                        Nuevo
                                    </label>
                                </div>
                            </div><!-- /.form-group -->
                        </div><!-- /.col -->
                        <div class="col-md-3">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" value="1" name="producto[estado]" <?php if ($producto['estado'] == 1) echo $checked; ?>>
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
                                    <textarea class="textarea" id="descripcion" name="producto[descripcion]"><?php echo utf8_encode($producto['descripcion']); ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Descripcion <small>Larga</small></h3>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea id="contenido" rows="10" cols="80" name="producto[contenido]"><?php echo utf8_encode($producto['contenido']); ?></textarea>                           
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="box-header">
                                    <h3 class="box-title">Tags <small>Lista separada por comas(,)</small></h3>
                                    <!-- tools box -->
                                </div><!-- /.box-header -->
                                <div class="box-body pad">
                                    <textarea rows="10" cols="80" name="producto[tags]"><?php echo utf8_encode($producto['tags']); ?></textarea>                           
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
                        <div class="row">
                            <?php
                            $imagenes = explode('|', $producto['imagen']);
                            $i = 1;
                            ?>
                            <?php foreach ($imagenes as $item): ?>
                                <?php $sinExtension = strstr($item, '.', true); ?>
                                <div class="col-md-3">
                                    <button type="button" class="btn btn-danger btn-lg btn-xs" data-toggle="modal" data-target="#eliminar-<?= $sinExtension; ?>">
                                        <i class="fa fa-times-circle" aria-hidden="true"></i>Eliminar
                                    </button>
                                    <img src="<?php echo IMAGE_PRODUCT . $item; ?>" class="img-responsive" />
                                </div>
                                <div class="modal fade" id="eliminar-<?= $sinExtension; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-danger">
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                                <h4 class="modal-title" id="myModalLabel">Eliminar Imagen</h4>
                                            </div>
                                            <div class="modal-body">
                                                ¿Está seguro que desea la siguiente imagen?
                                            </div>
                                            <div class="modal-footer">
                                                <input type="hidden" id="id-<?= $sinExtension; ?>" value="<?= $producto['id']; ?>">
                                                <input type="hidden" id="imagen-<?= $sinExtension; ?>" value="<?= $item; ?>">
                                                <input type="hidden" id="posicion-<?= $sinExtension; ?>" value="<?= $i; ?>">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <button type="button" id="btn-delImagen-<?= $sinExtension; ?>" class="btn btn-danger">Eliminar</button>
                                            </div>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $("#btn-delImagen-<?= $sinExtension; ?>").click(function () {
                                                        var id = $('#id-<?= $sinExtension; ?>').val();
                                                        var imagen = $('#imagen-<?= $sinExtension; ?>').val();
                                                        var posicion = $('#posicion-<?= $sinExtension; ?>').val();
                                                        $.ajax({
                                                            url: '<?= URL; ?>admin/eliminarImagenProducto',
                                                            type: 'POST',
                                                            data: {
                                                                id: id,
                                                                imagen: imagen,
                                                                posicion: posicion
                                                            },
                                                            success: function (data) {
                                                                location.reload();
                                                            }
                                                        }); //END AJAX
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </div>
                                <?php $i++; ?>
                            <?php endforeach; ?>
                        </div>
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
                    <input type="hidden" name="producto[id]" value="<?php echo utf8_encode($producto['id']); ?>" />
                    <div class="row">
                        <div class="col-md-6">
                            <button class="btn btn-block btn-primary btn-flat" type="submit">Guardar Cambios</button>
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