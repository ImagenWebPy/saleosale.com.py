<?php $helper = new Helper; ?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="page-title">
                    <h2>Mi Cuenta</h2>
                </div>
                <div class="static-contain">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <form method="post" action="<?php echo URL; ?>cliente/editar_cuenta/">
                        <fieldset class="col2-set">
                            <div class="col-1 registered-users">
                                <strong>Modificar Datos</strong>
                                <div class="content">
                                    <ul class="form-list">
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="cliente:name">Nombre <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Nombre" class="input-text required-entry" id="nombre" value="<?php echo $_SESSION['client_data']['nombre']; ?>" name="cliente[nombre]" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cliente:apellido">Apellido <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Apellido" class="input-text required-entry" id="apellido" value="<?php echo $_SESSION['client_data']['apellido']; ?>" name="cliente[apellido]" required>
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="cliente:id_tipo_documento">Documento Tipo <span class="required">*</span></label>
                                                    <br>
                                                    <?php echo $this->getTiposDocumentos; ?>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cliente:documento_nro">Documento Nro. <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Apellido" class="input-text required-entry" id="documento_nro" value="<?php echo $_SESSION['client_data']['documento_nro']; ?>" name="cliente[documento_nro]">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="cliente:telefono">Teléfono Nro. <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Telefono" class="input-text required-entry" id="telefono" value="<?php echo $_SESSION['client_data']['telefono']; ?>" name="cliente[telefono]">
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="cliente:celular">Celular Nro. <span class="required">*</span></label>
                                                    <br>
                                                    <input type="text" title="Celular" class="input-text required-entry" id="celular" value="<?php echo $_SESSION['client_data']['celular']; ?>" name="cliente[celular]">
                                                </div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label for="cliente:email">Correo Electrónico <span class="required">*</span></label>
                                                    <br>
                                                    <input type="email" title="email" class="input-text required-entry" value="<?php echo $_SESSION['client_data']['email']; ?>" name="cliente[email]" required>
                                                </div>
                                            </div>
                                        </li>
                                        <hr>
                                        <li>
                                            <p class="text-muted">Es cliente desde el <?php echo date('d-m-Y', strtotime($_SESSION['client_data']['fecha_registro'])); ?></p>
                                        </li>
                                    </ul>
                                    <p class="required">* Campos Requeridos</p>
                                    <div class="buttons-set">
                                        <input type="hidden" name="cliente[id_cliente]" name="<?php echo $_SESSION['cliente']['id']; ?>" />
                                        <button id="send2" name="send" type="submit" class="button login"><span>Modificar Datos</span></button>
                                    </div>
                                </div>
                        </fieldset>
                    </form>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>
