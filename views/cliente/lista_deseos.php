<?php
$helper = new Helper();
$productos = $this->loadLista;
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow bounceInUp animated">
                <div class="page-title">
                    <h2>Mi Lista de Deseos</h2>
                </div>
                <div class="table-responsive">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <table class="data-table cart-table" id="shopping-cart-table">
                        <thead>
                            <tr class="first last">
                                <th rowspan="1">&nbsp;</th>
                                <th rowspan="1"><span class="nobr">Nombre Producto</span></th>
                                <th colspan="1" class="a-center"><span class="nobr">Precio</span></th>
                                <th class="a-center" rowspan="1">&nbsp;</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr class="first last">
                                <td class="a-right last" colspan="5">&nbsp;</td>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php if (!empty($productos)): ?>
                                <?php foreach ($productos as $item): ?>
                                    <tr>
                                        <td class="image"><a class="product-image" title="<?php echo $item['nombre']; ?>" href="<?php echo $helper->urlProducto($item['id_producto']); ?>"><img width="75" alt="<?php echo $item['nombre']; ?>" src="<?php echo IMAGE_PRODUCT . $item['imagen']; ?>"></a></td>
                                        <td><h2 class="product-name"> <a href="<?php echo $helper->urlProducto($item['id_producto']); ?>"><?php echo $item['nombre']; ?></a> </h2></td>
                                        <td class="a-right"><span class="cart-price"> <span class="price"><?php echo $helper->getUnitPrice($item['id_producto']); ?></span> </span></td>
                                        <td class="a-center last">
                                            <a class="btn btn-success" title="Aagregar al Carrito" href="<?php echo URL . 'cart/agregar/' . $item['id_producto'] ?>"><span>Agregar al Carrito</span></a>
                                            <a class="btn btn-danger" href="<?php echo URL . 'cliente/removerLista/' . $_SESSION['cliente']['id'] . '/' . $item['id_producto'] ?>"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a> 
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                    <tr>
                                        <td colspan="4">
                                            <?php echo $helper->messageAlert('info', 'Su Lista de Deseos se encuentra vacía') ?>
                                        </td>
                                    </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>