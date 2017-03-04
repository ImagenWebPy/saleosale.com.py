<?php
$helper = new Helper();
$carrito = new Carrito();
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <?php if ($carrito->articulos_total() > 0): ?>
            <div class="row">
                <section class="col-main col-sm-9">
                    <div class="page-title">
                        <h1>Comprar</h1>
                    </div>
                    <ol class="one-page-checkout" id="checkoutSteps">
                        <li id="opc-billing" class="section allow active">
                            <div class="step-title"> <span class="number">1</span>
                                <h3>Información de envío</h3>
                                <!--<a href="#">Edit</a> --> 
                            </div>
                            <div id="checkout-step-billing" class="step a-item">
                                <?php if (!empty($_SESSION['cliente'])): ?>
                                    <?php if (!empty($this->getAdrressClient)): ?>
                                        <form action="<?php echo URL; ?>cart/carrito_paso2/" method="POST">
                                            <fieldset class="group-select">
                                                <ul>
                                                    <li>
                                                        <label for="id_direccion_cliente">Seleccione la dirección de envio</label>
                                                        <br>
                                                        <select name="id_direccion_cliente" id="billing-address-select" class="address-select">
                                                            <?php echo $this->getAdrressClient; ?>
                                                        </select>
                                                    </li>
                                                </ul>
                                                <button type="submit" class="button continue"><span>Continuar</span></button>
                                                <a href="<?php echo URL; ?>cliente/agregarDireccion/" type="button" class="button continue pull-right"><div class="icon-truck"></div><span> Agregar Nueva Dirección</span></a>
                                            </fieldset>
                                        </form>
                                    <?php else: ?>
                                        <p class="text-info">Para continuar con el proceso de compra necesitas definir una dirección de envio</p>
                                        <a href="<?php echo URL; ?>cliente/agregarDireccion/" type="button" class="button continue"><div class="icon-truck"></div><span> Agregar Dirección</span></a>
                                    <?php endif; ?>
                                <?php else: ?>
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
                                                        <div class="col-md-8">
                                                            <button onclick="window.location = '<?php echo URL; ?>login/registro/';" class="button create-account" type="button"><span>Crea tu cuenta</span></button>
                                                        </div>
                                                        <div class="col-md-8">
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
                                                        <p class="required">* Campos Requeridos</p>
                                                        <div class="buttons-set">
                                                            <button type="submit" class="button login"><span>Inicie Sesión</span></button>
                                                            <a class="forgot-word" href="#">Se olvido su contraseña?</a> </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </fieldset>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </li>
                        <li id="opc-shipping" class="section">
                            <div class="step-title"> <span class="number">2</span>
                                <h3 class="one_page_heading"> Metodo de Pago</h3>
                                <!--<a href="#">Edit</a>--> 
                            </div>
                        </li>
                        <li id="opc-shipping_method" class="section">
                            <div class="step-title"> <span class="number">3</span>
                                <h3 class="one_page_heading">Resumen de la Orden</h3>
                                <!--<a href="#">Edit</a>--> 
                            </div>
                        </li>
                    </ol>
                </section>
                <aside class="col-right sidebar col-sm-3">
                    <?php echo $this->suPedido; ?>
                </aside>
            </div>
        <?php else: ?>
            <div class="row">
                <?php echo $helper->messageAlert('warning', 'No ha añadido ningún producto a su carrito'); ?>
            </div>
        <?php endif; ?>
    </div>
</div>