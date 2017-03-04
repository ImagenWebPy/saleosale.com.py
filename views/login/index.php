<?php 
$helper = new Helper(); 
$urlAnterior = $helper->getUrlAnterior();
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="account-login">
            <div class="page-title">
                <h2>Inicie Sesión o Regístrese</h2>
            </div>

            <fieldset class="col2-set">
                <legend>Inicie Sesión o Regístrese</legend>
                <div class="col-1 new-users"><strong>Nuevos Usuarios</strong>
                    <div class="content">
                        <p>Al crear una cuenta en nuestra tienda, usted será capaz de comprar más rápidamente el producto que desea, podrá almacenar múltiples direcciones de envío, ver y rastrear sus pedidos en su cuenta y más.</p>
                        <div class="row">
                            <div class="col-md-5">
                                <button onclick="window.location = '<?php echo URL; ?>login/registro/';" class="button create-account" type="button"><span>Crea tu cuenta</span></button>
                            </div>
                            <div class="col-md-5">
                                <?php echo (!empty($this->fb_boton)) ? $this->fb_boton : ''; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="<?php echo URL; ?>login/iniciar/" method="POST">
                    <div class="col-2 registered-users"><strong>Usuarios Registrados</strong>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <div class="content">
                            <p>Si usted tiene una cuenta con nosotros, por favor inicie sesión</p>
                            <ul class="form-list">
                                <li>
                                    <label for="email">Dirección de E-mail <span class="required">*</span></label>
                                    <br>
                                    <input type="text" title="Dirección de Email" class="input-text required-entry" id="email" value="" name="login[email]">
                                </li>
                                <li>
                                    <label for="pass">Contraseña <span class="required">*</span></label>
                                    <br>
                                    <input type="password" title="Password" id="pass" class="input-text required-entry validate-password" name="login[password]">
                                </li>
                            </ul>
                            <input type="hidden" name="login[urlAnterior]" value="<?= $urlAnterior; ?>" >
                            <p class="required">* Campos Requeridos</p>
                            <div class="buttons-set">
                                <button type="submit" class="button login"><span>Inicie Sesión</span></button>
                                <a class="forgot-word" href="<?php echo URL; ?>login/contrasena/">¿Olvidaste tu contraseña?</a> </div>
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