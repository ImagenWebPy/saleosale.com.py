<?php
$condicion = $this->selectCondicion;
$idCliente = $_SESSION['cliente']['id'];
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="page-title">
                    <h2>Agregar Subasta</h2>
                </div>
                <div class="static-contain">
                    <form method="POST" action="<?= URL; ?>cliente/addNewSubasta" enctype="multipart/form-data">
                        <fieldset class="group-select">
                            <ul>
                                <li>
                                    <fieldset>
                                        <ul>
                                            <li>
                                                <div class="input-box">
                                                    <label for="subasta[nombre]">Nombre del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" name="subasta[nombre]" value="" title="Nomrbe del Producto" class="input-text" required>
                                                </div>
                                                <div class="input-box">
                                                    <label for="subasta[marca]">Marca del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" name="subasta[marca]" value="" title="Marca del Producto" class="input-text" required>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="customer-name">
                                                    <div class="input-box name-firstname">
                                                        <label for="subasta[oferta_minima]"> Oferta Minima<span class="required">*</span></label>
                                                        <br>
                                                        <div class="input-group">
                                                            <div class="input-group-addon">Gs.</div>
                                                            <input type="number" class="form-control subasta-input" name="subasta[oferta_minima]" placeholder="Oferta Minima">
                                                        </div>
                                                    </div>
                                                    <div class="input-box name-lastname">
                                                        <label for="subasta[fecha_inicio]">Fecha de Inicio <span class="required">*</span> </label>
                                                        <br>
                                                        <input type="text" id="fecha_inicio" name="subasta[fecha_inicio]" value="" class="input-text subasta">
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="input-box">
                                                    <label for="subasta[fecha_fin]">Fecha Fin</label>
                                                    <br>
                                                    <input type="text" id="fecha_fin" name="subasta[fecha_fin]" value="" title="Fecha Fin" class="input-text subasta">
                                                </div>
                                                <div class="input-box">
                                                    <label for="subasta[condicion]">Condicion del Producto <span class="required">*</span></label>
                                                    <br>
                                                    <select class="form-control subasta" name="subasta[condicion]">
                                                        <?php foreach ($condicion as $item): ?>
                                                            <option value="<?= utf8_encode($item); ?>"><?= utf8_encode($item); ?></option>
                                                        <?php endforeach; ?>
                                                    </select>
                                                </div>
                                            </li>
                                            <li class="">
                                                <label for="subasta:descripcion_corta">Descripcion Corta<em class="required">*</em></label>
                                                <br>
                                                <div class="">
                                                    <textarea name="subasta[descripcion_corta]" id="descripcion_corta" title="Descripcion Corta" class="required-entry input-text" cols="5" rows="3"></textarea>
                                                </div>
                                            </li>
                                            <li class="">
                                                <label for="subasta[descripcion_corta]">Contenido<em class="required">*</em></label>
                                                <br>
                                                <div class="">
                                                    <textarea name="subasta[contenido]" id="contenido" title="Contenido" class="required-entry input-text" cols="5" rows="3"></textarea>
                                                </div>
                                            </li>
                                        </ul>
                                    </fieldset>
                                </li>
                                <li>
                                    <div class="form-group">
                                        <label for="exampleInputFile">Imagenes</label>
                                        <input type="file" id="imagen" name="imagen[]" accept="image/jpg,image/jpeg,image/pjpeg,image/x-jps,image/gif,image/png">
                                        <p class="help-block">JPG, PNG, GIF</p>
                                        <button id="add_more<?= $idCliente; ?>">Agregar más archivos</button>
                                    </div>
                                </li>
                                <li> 
                                    <input type="hidden" value="<?= $idCliente; ?>" name="subasta[id_cliente]" />
                                    <span class="require"><em class="required">* </em>Campos Requeridos</span>
                                    <div class="buttons-set">
                                        <button type="submit" title="Submit" class="button submit"> <span> Envíar para revisión </span> </button>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_more<?= $idCliente; ?>').click(function (e) {
            e.preventDefault();
            $(this).before("<input name='imagen[]' accept='image/jpg,image/jpeg,image/pjpeg,image/x-jps,image/gif,image/png' type='file'/>");
        });
    });
</script>
