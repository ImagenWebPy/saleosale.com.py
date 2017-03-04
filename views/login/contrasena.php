<?php $helper = new Helper(); ?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="account-login">
            <div class="page-title">
                <h2>Ingrese su nueva contraseña</h2>
            </div>
            <fieldset class="col2-set">
                <form action="<?php echo URL; ?>login/contrasena/" method="POST">
                    <div class="col-md-8 registered-users col-centered" style=" background: #f7f7f7; border: 1px solid #eaeaea;">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <div class="content">
                            <p>Por favor ingrese su dirección de e-mail y le enviaremos instrucciones para restablecer su contraseña</p>
                            <ul class="form-list">
                                <li>
                                    <label for="email">Dirección de E-mail <span class="required">*</span></label>
                                    <br>
                                    <input type="email" title="Dirección de Email" class="input-text required-entry" id="email" value="" name="recuperar[email]" required>
                                </li>
                            </ul>
                            <p class="required">* Campos Requeridos</p>
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