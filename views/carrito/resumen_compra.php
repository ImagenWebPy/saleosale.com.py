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
                        <li id="opc-billing" class="section">
                            <div class="step-title"> <span class="number">1</span>
                                <h3>Información de envío</h3>
                                <!--<a href="#">Edit</a> --> 
                            </div>
                        </li>
                        <li id="opc-shipping" class="section">
                            <div class="step-title"> <span class="number">2</span>
                                <h3 class="one_page_heading">Metodo de Pago</h3>
                                <!--<a href="#">Edit</a>--> 
                            </div>
                        </li>
                        <li id="opc-shipping_method" class="section active">
                            <div class="step-title"> <span class="number">3</span>
                                <h3 class="one_page_heading">Resumen de su pedido</h3>
                                <!--<a href="#">Edit</a>--> 
                            </div>
                            <div id="checkout-step-billing" class="step a-item">
                                <div class="order-review" id="checkout-review-load"> 
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
                                                    <td class="a-right last" colspan="7">
                                                        &nbsp;
                                                    </td>
                                                </tr>
                                            </tfoot>
                                            <tbody>
                                                <?php
                                                foreach ($this->loadCartReview as $item) {
                                                    echo $item;
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                </div>
                                <div class="row">
                                    <form action="<?php echo URL; ?>cart/confirmar_compra/" method="POST">
                                        <div class="col-md-6">
                                            <br>
                                            <label for="observacion_pedido"><strong>Agregue datos adicionales para su pedido:</strong></label>
                                            <div>
                                                <textarea name="observacion_pedido" title="Observacion del Pedido" class="input-text" cols="5" rows="3" style=" width: 100%;"></textarea>
                                            </div>
                                        </div>
                                        <div class="totals col-md-6 pull-right">
                                            <h3>Total del carrito de compras</h3>
                                            <div class="inner">
                                                <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="1" class="a-left"><strong>Total Pedido</strong></td>
                                                            <td class="a-right pull-right"><strong><span class="price"><?php echo $helper->getPrecioCarrito($carrito->precio_total()); ?></span></strong></td>
                                                        </tr>
                                                    </tfoot>
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="1" class="a-left"> Subtotal </td>
                                                            <td class="a-right pull-right"><span class="price"><?php echo $helper->getPrecioCarrito($this->getSubTotal); ?></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="1" class="a-left"> Costo de Envio </td>
                                                            <td class="a-right pull-right"><span class="price"><?php echo $helper->getPrecioCarrito($this->getCostoEnvio); ?></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                <ul class="checkout">
                                                    <li>
                                                        <button class="button btn-proceed-checkout" title="Confirmar Compra" type="submit"><span>Confirmar Compra</span></button>
                                                    </li>
                                                </ul>
                                            </div>
                                            <!--inner--> 
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </li>
                    </ol>
                </section>
                <aside class="col-right sidebar col-sm-3 wow bounceInUp animated">
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