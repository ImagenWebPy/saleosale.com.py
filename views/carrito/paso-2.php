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
                        <li id="opc-shipping" class="section active">
                            <div class="step-title"> <span class="number">2</span>
                                <h3 class="one_page_heading">Metodo de Pago</h3>
                                <!--<a href="#">Edit</a>--> 
                            </div>
                            <div id="checkout-step-billing" class="step a-item">
                                <p>Seleccione un metodo de pago para continuar con el proceso de compra</p>
                                <form action="<?php echo URL; ?>cart/carrito_paso3/" method="POST" id="frm-paso2" enctype="multipart/form-data">
                                    <dl id="checkout-payment-method-load">
                                        <?php
                                        foreach ($this->getPaymentsMethods as $metodos) {
                                            echo $metodos;
                                        }
                                        ?>
                                    </dl>
                                    <div class="form-group" id="img-entrega" style=" display: none;">
                                        <label class="text-info">Por favor suba una imagen real del producto a ser tasado para su canje.</label>
                                        <input type="file" id="upload_file" name="upload_file">
                                        <p class="text-danger" style="font-size: 12px;">Solo se permiten imagenes(JPG, PNG, BMP, GIF)</p>
                                    </div>
                                    <button type="submit" class="button continue" id="btn-paso2"><span>Continuar</span></button>
                                </form>
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