<?php
$helper = new Helper();
$carrito = new Carrito();
$items = $carrito->get_content();
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow bounceInUp animated">
                <div class="page-title">
                    <h2>Carrito de Compras</h2>
                </div>

                <div class="table-responsive">
                    <fieldset>
                        <table class="data-table cart-table" id="shopping-cart-table">
                            <thead>
                                <tr class="first last">
                                    <th rowspan="1">&nbsp;</th>
                                    <th rowspan="1"><span class="nobr">Nombre del Producto</span></th>
                                    <th rowspan="1">&nbsp;</th>
                                    <th colspan="1" class="a-center"><span class="nobr">Precio Unitario</span></th>
                                    <th class="a-center" rowspan="1">Cant.</th>
                                    <th colspan="1" class="a-center">Subtotal</th>
                                    <th class="a-center" rowspan="1">&nbsp;</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr class="first last">
                                    <td class="a-right last" colspan="7"><button onclick="window.location = '<?php echo URL; ?>';" class="button btn-continue" title="Continuar Comprando en la Tienda" type="button"><span><span>Continuar Comprando en la Tienda</span></span></button>
                                        <!--<button class="button btn-update" title="Update Cart" value="update_qty" name="update_cart_action" type="submit"><span><span>Update Cart</span></span></button>-->
                                        <a class="button btn-empty" href="<?php echo URL; ?>cart/borrarCarrito/" title="Borrar Carrito"><span>Borrar Carrito</span></a></td>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php if (!empty($items)): ?>
                                    <?php foreach ($items as $item): ?>
                                        <tr class="first odd">
                                            <td class="image"><a class="product-image" href="<?php echo $helper->urlProducto($item['id']); ?>"><img width="75" alt="<?php echo $item['imagen']; ?>" src="<?php echo IMAGE_PRODUCT . $item['imagen']; ?>"></a></td>
                                            <td><h2 class="product-name"> <a href="<?php echo $helper->urlProducto($item['id']); ?>"><?php echo $item['nombre']; ?></a> </h2></td>
                                            <td class="a-center">&nbsp;</td>
                                            <td class="a-right"><span class="cart-price"> <span class="price"><?php echo $helper->getUnitPrice($item['id'], $item['cantidad']); ?></span> </span></td>
                                            <td class="a-center movewishlist"><input maxlength="12" class="input-text qty" title="Cant." size="4" value="<?php echo $item['cantidad']; ?>"></td>
                                            <td class="a-right movewishlist"><span class="cart-price"> <span class="price"><?php echo $helper->getPrecioTotalItem($item['precio'], $item['cantidad']); ?></span> </span></td>
                                            <td class="a-center last"><a class="button remove-item" title="Remove item" href="<?php echo URL . 'cart/eliminar/' . $item['unique_id']; ?>"><span><span>Remover Producto</span></span></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr class="last even">
                                        <td class="image" colspan="7"><?php echo $helper->messageAlert('info', 'Su carrito se encuentra vacío') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </fieldset>
                </div>

                <!-- BEGIN CART COLLATERALS -->
                <div class="cart-collaterals row">
                    <div class="col-sm-8">
                        <?php if (empty($_SESSION['cliente'])): ?>
                            <div class="shipping">
                                <h3>Inicie Sesión o Regístrese para continuar con su Compra</h3>
                                <div class="shipping-form">
                                    <div class="account-login row">
                                        <fieldset>
                                            <div class="col-md-6 new-users">
                                                <strong>Nuevos Usuarios</strong>
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
                                            <div class="col-md-6">
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
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div class="totals col-sm-4">
                        <h3>Total del carrito de compras</h3>
                        <div class="inner">
                            <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                <tfoot>
                                    <tr>
                                        <td colspan="1" class="a-left"><strong>Total Producto</strong></td>
                                        <td class="a-right pull-right"><strong><span class="price"><?php echo $helper->getPrecioCarrito($carrito->precio_total()); ?></span></strong></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td colspan="1" class="a-left"> Subtotal </td>
                                        <td class="a-right pull-right"><span class="price"><?php echo $helper->getPrecioCarrito($carrito->precio_total()); ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <?php if ((!empty($_SESSION['cliente'])) && ($carrito->articulos_total() > 0)): ?>
                                <ul class="checkout">
                                    <li>
                                        <button onclick="window.location = '<?php echo URL; ?>cart/carrito_comprar/';" class="button btn-proceed-checkout" title="Continuar con la Compra" type="button"><span>Continuar con la Compra</span></button>
                                    </li>
                                </ul>
                            <?php endif; ?>
                        </div>
                        <!--inner--> 
                    </div>
                </div>
                <!--cart-collaterals--> 
            </div>
        </div>
    </div>
</section>