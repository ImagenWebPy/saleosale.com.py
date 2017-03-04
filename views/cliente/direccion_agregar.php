<?php $helper = new Helper(); ?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="my-account">
                    <div class="page-title">
                        <h2>Agregar Direccion</h2>
                    </div>
                    <div class="my-wishlist">
                        <div class="table-responsive">
                            <form class="form-inline" method="POST" action="<?php echo URL; ?>cliente/frmAddDirection/">
                                <fieldset>
                                    <table id="wishlist-table" class="clean-table linearize-table data-table">
                                        <thead>
                                            <tr class="first last">
                                                <th>&nbsp;</th>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr class="first odd">
                                                <td>
                                                    <table cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td>
                                                                <label for="barrio">Departamento</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="direccion[id_departamento]" id="id_departamento" required>
                                                                        <option value="0">Seleccione un Departamento</option>
                                                                        <?php foreach ($this->loadDepartamentos as $items): ?>
                                                                            <option value="<?php echo $items['id']; ?>"><?php echo utf8_encode($items['descripcion']); ?></option>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="barrio">Ciudad</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="direccion[id_ciudad]" id="id_ciudad" required>
                                                                        <option value="0">Seleccione una Ciudad</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="barrio">Barrio</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="barrio" name="direccion[barrio]">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="calle_principal">Calle Principal</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">

                                                                    <input type="text" class="form-control" id="calle_principal" name="direccion[calle_principal]">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="calle_lateral1">Calle Secundaria</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="calle_lateral1" name="direccion[calle_lateral1]">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="telefono">Teléfono</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="telefono" name="direccion[telefono]">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="tipo_vivienda">Tipo de Vivienda</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <select class="form-control" name="direccion[tipo_vivienda]">
                                                                        <option value="0">Seleccione una Opción</option>
                                                                        <option value="Particular">Particular</option>
                                                                        <option value="Laboral">Laboral</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label for="horario">Horario en el que se lo puede encontrar</label>
                                                            </td>
                                                            <td>
                                                                <div class="form-group">
                                                                    <input type="text" class="form-control" id="telefono" name="direccion[telefono]">
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>
                                                                <label>Predeterminada </label>
                                                            </td>
                                                            <td>
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox" name="direccion[predeterminada]" id="predeterminada" value="1" aria-label=" Predeterminada">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td>
                                                    <p>Busca tu ubicación en el mapa y has un clic sobre el mismo, para posicionar un marcador sobre el mapa y así poder localizar mejor tu ubicación para el envío.</p>
                                                    <div id="map" class="maps"></div>
                                                    <input type="hidden" name="direccion[latitude]" id="lat">
                                                    <input type="hidden" name="direccion[longitude]" id="lng">
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="buttons-set buttons-set2">
                                        <input type="hidden" name="direccion[id_cliente]" value="<?php echo $_SESSION['cliente']['id']; ?>" />
                                        <button class="button btn-add" title="Agregar nueva Dirección" type="submit"><span>Guardar Dirección</span></button>
                                    </div>
                                </fieldset>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>
