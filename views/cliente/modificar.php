<?php
$helper = new Helper();
$subasta = $this->getDatosSubasta;
$condicion = $this->selectCondicion;
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="page-title">
                    <h2>Modificar Subasta</h2>
                </div>
                <?php
                if (isset($_SESSION['message'])) {
                    echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                }
                ?>
                <div class="static-contain">
                    <form method="POST" action="<?= URL; ?>cliente/modificarSubasta" enctype="multipart/form-data">
                        <fieldset class="group-select">
                            <ul>
                                <li>
                                    <fieldset>
                                        <ul>
                                            <li>
                                                <div class="input-box">
                                                    <label for="subasta[nombre]">Nombre del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" name="subasta[nombre]" value="<?= str_replace('"', ' ', utf8_encode($subasta['producto'])); ?>" title="Nomrbe del Producto" class="input-text" required>
                                                </div>
                                                <div class="input-box">
                                                    <label for="subasta[marca]">Marca del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" name="subasta[marca]" value="<?= str_replace('"', ' ', utf8_encode($subasta['marca'])); ?>" title="Marca del Producto" class="input-text" required>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="customer-name">
                                                    <div class="input-box name-firstname">
                                                        <label for="subasta[oferta_minima]"> Oferta Minima<span class="required">*</span></label>
                                                        <br>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">Gs.</div>
                                                            <input type="number" class="form-control subasta-input" name="subasta[oferta_minima]" placeholder="Oferta Minima" value="<?= round($subasta['oferta_minima'], 0); ?>">
                                                        </div>
                                                    </div>
                                                    <div class="input-box name-lastname">
                                                        <label for="subasta[fecha_inicio]">Fecha de Inicio <span class="required">*</span> </label>
                                                        <br>
                                                        <input type="text" id="fecha_inicio" name="subasta[fecha_inicio]" value="<?= date('d-m-Y', strtotime($subasta['fecha_inicio'])); ?>" class="input-text subasta">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-box">
                                                    <label for="subasta[fecha_fin]">Fecha Fin</label>
                                                    <br>
                                                    <input type="text" id="fecha_fin" name="subasta[fecha_fin]" value="<?= date('d-m-Y', strtotime($subasta['fecha_fin'])); ?>" title="Fecha Fin" class="input-text subasta">
                                                </div>
                                                <div class="input-box">
                                                    <label for="subasta[condicion]">Condicion del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <select class="form-control subasta" name="subasta[condicion]">
                                                        <?php foreach ($condicion as $item): ?>
                                                            <?php ($item == $subasta['condicion']) ? $selected = 'selected' : $selected = ''; ?>
                                                            <option value="<?= utf8_encode($item); ?>" <?= $selected; ?>><?= utf8_encode($item); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="">
                                                <label for="subasta:descripcion_corta">Descripcion Corta<em class="required">*</em></label>
                                                <br>
                                                <div class="">
                                                    <textarea name="subasta[descripcion_corta]" id="descripcion_corta" title="Descripcion Corta" class="required-entry input-text" cols="5" rows="3"><?= $subasta['descripcion_corta']; ?></textarea>
                                                </div>
                                            </li>
                                            <li class="">
                                                <label for="subasta[descripcion_corta]">Contenido<em class="required">*</em></label>
                                                <br>
                                                <div class="">
                                                    <textarea name="subasta[contenido]" id="contenido" title="Contenido" class="required-entry input-text" cols="5" rows="3"><?= $subasta['contenido']; ?></textarea>
                                                </div>
                                            </li>
                                        </ul>
                                    </fieldset>
                                </li>
                                <li>
                                    <div class="row">
                                        <?php
                                        $imagenes = explode('|', $subasta['imagen']);
                                        $i = 1;
                                        ?>
                                        <?php foreach ($imagenes as $item): ?>
                                            <?php $sinExtension = strstr($item, '.', true); ?>
                                            <div class="col-md-3">
                                                <button type="button" class="btn btn-danger btn-lg btn-xs" data-toggle="modal" id="btn-delImagen-<?= $sinExtension; ?>">
                                                    <i class="fa fa-times-circle" aria-hidden="true"></i>Eliminar
                                                </button>
                                                <input type="hidden" id="id-<?= $sinExtension; ?>" value="<?= $subasta['id']; ?>">
                                                <input type="hidden" id="imagen-<?= $sinExtension; ?>" value="<?= $item; ?>">
                                                <input type="hidden" id="posicion-<?= $sinExtension; ?>" value="<?= $i; ?>">
                                                <img src="<?php echo IMAGE_PRODUCT . $item; ?>" class="img-responsive" />
                                            </div>
                                            <script type="text/javascript">
                                                $(document).ready(function () {
                                                    $("#btn-delImagen-<?= $sinExtension; ?>").click(function () {
                                                        var id = $('#id-<?= $sinExtension; ?>').val();
                                                        var imagen = $('#imagen-<?= $sinExtension; ?>').val();
                                                        var posicion = $('#posicion-<?= $sinExtension; ?>').val();
                                                        $.ajax({
                                                            url: '<?= URL; ?>cliente/eliminarImagenSubasta',
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
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                    </div>
                                    <div class="form-group">
                                        <?php echo $helper->messageAlert('info', 'Solo si desea agregar más imagenes complete este campo'); ?>
                                        <label for="exampleInputFile">Imagenes</label>
                                        <input type="file" id="imagen" name="imagen[]" accept="image/jpg,image/jpeg,image/pjpeg,image/x-jps,image/gif,image/png">
                                        <p class="help-block">JPG, PNG, GIF</p>
                                        <button class="add_more">Agregar más archivos</button>
                                    </div>
                                </li>
                                <li> 
                                    <input type="hidden" value="<?= $subasta['id']; ?>" name="subasta[id_subasta]" />
                                    <span class="require"><em class="required">* </em>Campos Requeridos</span>
                                    <div class="buttons-set">
                                        <button type="submit" title="Submit" class="button submit"> <span> Modificar </span> </button>
                                    </div>
                                </li>
                            </ul>
                        </fieldset>
                    </form>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>
