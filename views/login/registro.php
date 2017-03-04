<section class="main-container col1-layout">
    <div class="main container">
        <div class="account-login">
            <div class="page-title">
                <h2>Registrarse en el Sitio</h2>
            </div>
            <form method="post" action="<?php echo URL; ?>login/crear">
                <fieldset class="col2-set">
                    <div class="col-1 registered-users">
                        <strong>Ingrese sus Datos</strong>
                        <div class="content">
                            <ul class="form-list">
                                <li>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="register:name">Nombre <span class="required">*</span></label>
                                            <br>
                                            <input type="text" title="Nombre" class="input-text required-entry" id="nombre" value="" name="register[nombre]" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="register:apellido">Apellido <span class="required">*</span></label>
                                            <br>
                                            <input type="text" title="Apellido" class="input-text required-entry" id="apellido" value="" name="register[apellido]" required>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="register:id_tipo_documento">Documento Tipo <span class="required">*</span></label>
                                            <br>
                                            <?php echo $this->loadDocumento; ?>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="register:documento_nro">Documento Nro. <span class="required">*</span></label>
                                            <br>
                                            <input type="text" title="Apellido" class="input-text required-entry" id="documento_nro" value="" name="register[documento_nro]">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="register:telefono">Teléfono Nro. <span class="required">*</span></label>
                                            <br>
                                            <input type="text" title="Telefono" class="input-text required-entry" id="telefono" value="" name="register[telefono]">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="register:celular">Celular Nro. <span class="required">*</span></label>
                                            <br>
                                            <input type="text" title="Celular" class="input-text required-entry" id="celular" value="" name="register[celular]">
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="register:email">Correo Electrónico <span class="required">*</span></label>
                                            <br>
                                            <input type="email" title="email" class="input-text required-entry" id="email" value="" name="register[email]" required>
                                        </div>
                                    </div>
                                </li>
                                <hr>
                                <li>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label for="register:pass">Contraseña <span class="required">*</span></label>
                                            <br>
                                            <input type="password" title="Contraseña" class="input-text required-entry" id="pass" value="" name="register[pass]" required minlength="6">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="register:pass_validate">Repita su Contraseña <span class="required">*</span></label>
                                            <br>
                                            <input type="password" title="Celular" class="input-text required-entry" id="pass_validate" value="" name="register[pass_validate]" required minlength="6">
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <p class="required">* Campos Requeridos</p>
                            <div class="buttons-set">
                                <button id="send2" name="send" type="submit" class="button login"><span>Crear Cuenta</span></button>
                                <a class="forgot-word" href="#">Se olvido su contraseña?</a> </div>
                        </div>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</section>