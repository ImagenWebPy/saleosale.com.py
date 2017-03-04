<?php $helper = new Helper(); ?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="account-login">
            <div class="page-title">
                <h2>Recuperar Contraseña</h2>
            </div>
            <fieldset class="col2-set">
                <form action="<?php echo URL; ?>login/cambiar_pass/" method="POST">
                    <div class="col-md-8 registered-users col-centered" style=" background: #f7f7f7; border: 1px solid #eaeaea;">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <div class="content">
                            <ul class="form-list">
                                <li>
                                    <label for="contrasena[pass1]">Contraseña <span class="required">*</span></label>
                                    <br>
                                    <input type="password" title="Contraseña" class="input-text required-entry" id="email" value="" name="contrasena[pass1]" required>
                                </li>
                                <li>
                                    <label for="contrasena[pass2]">Vuelva a ingresar su contraseña <span class="required">*</span></label>
                                    <br>
                                    <input type="password" title="Repita su Contraseña" class="input-text required-entry" id="email" value="" name="contrasena[pass2]" required>
                                </li>
                            </ul>
                            <p class="required">* Campos Requeridos</p>
                            <input type="hidden" value="<?php echo $_SESSION['forgotCliente']['id_cliente']; ?>" name="contrasena[id_cliente]" />
                            <div class="buttons-set">
                                <button type="submit" class="button login" name="generar"><span>Cambiar</span></button>
                        </div>
                    </div>
                </form>
            </fieldset>

        </div>
        <br>
        <br>
        <br>
        <br>
        <br>
    </div>
</section>