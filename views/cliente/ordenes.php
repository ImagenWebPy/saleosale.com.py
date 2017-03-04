<?php
$helper = new Helper();
$orden = $this->cargarDatosOrden;
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow bounceInUp animated">
                <div class="page-title">
                    <h2>Orden #<?php echo $_SESSION['orden']['id']; ?></h2>
                </div>
                <div class="table-responsive">
                    <form method="post" action="#updatePost/">
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
                                            <!--<button class="button btn-update" title="Update Cart" value="update_qty" name="update_cart_action" type="submit"><span><span>Volver a Comprar</span></span></button>-->
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <?php foreach ($orden['productos'] as $item): ?>
                                        <?php $imagenes = explode('|', $item['imagen']); ?>
                                        <tr class="first odd">
                                            <td class="image"><a class="product-image" href="<?php echo $helper->urlProducto($item['id_producto']); ?>"><img width="75" alt="<?php echo $imagenes[0]; ?>" src="<?php echo IMAGE_PRODUCT . $imagenes[0]; ?>"></a></td>
                                            <td><h2 class="product-name"> <a href="<?php echo $helper->urlProducto($item['id_producto']); ?>"><?php echo $item['nombre']; ?></a> </h2></td>
                                            <td class="a-center">&nbsp;</td>
                                            <td class="a-right"><span class="cart-price"> <span class="price"><?php echo $helper->getUnitPrice($item['id_producto'], $item['cantidad']); ?></span> </span></td>
                                            <td class="a-center movewishlist"><input maxlength="12" class="input-text qty" title="Cant." size="4" value="<?php echo $item['cantidad']; ?>"></td>
                                            <td class="a-right movewishlist"><span class="cart-price"> <span class="price"><?php echo $helper->getPrecioTotalItem($item['precio'], $item['cantidad']); ?></span> </span></td>
                                            <td class="a-center last">&nbsp;</td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>
                <!-- BEGIN CART COLLATERALS -->
                <div class="cart-collaterals row">
                    <div class="col-sm-8">
                        <form method="post" action="http://newsmartwave.net/magento/kallyas/index.php/checkout/cart/couponPost/">
                            <div class="discount">
                                <h3>Datos del pedido</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="text-muted"><strong>Fecha del Pedido:</strong> <?php echo date('d-m-Y H:i:s', strtotime($orden['fecha_pedido'])); ?></p> 
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-muted"><strong>Estado del Pago:</strong> <?= $helper->estadoPago($orden['estado_pago']); ?></p>
                                        <p class="text-muted"><strong>Estado del Pedido:</strong> <?= $helper->estadoPedido($orden['estado_pedido']); ?></p>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <div class="totals col-sm-4">
                        <h3>Total del carrito de compras</h3>
                        <div class="inner">
                            <table class="table shopping-cart-table-total" id="shopping-cart-totals-table">

                                <tfoot>
                                    <tr>
                                        <td colspan="1" class="a-left"><strong>Total Orden</strong></td>
                                        <td class="a-right pull-right"><strong><span class="price"><?php echo $helper->getPrecioCarrito($orden['monto_total']); ?></span></strong></td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr>
                                        <td colspan="1" class="a-left"> Monto Productos </td>
                                        <td class="a-right pull-right"><span class="price"><?php echo $helper->getPrecioCarrito($orden['monto_pedido']); ?></span></td>
                                    </tr>
                                    <tr>
                                        <td colspan="1" class="a-left"> Gastos de Envío </td>
                                        <td class="a-right pull-right"><span class="price"><?php echo $helper->getPrecioCarrito($orden['monto_envio']); ?></span></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!--inner--> 
                    </div>
                </div>
                <!--cart-collaterals--> 
            </div>
        </div>
    </div>
</section>