<?php
$helper = new Helper;
$subastas = $this->cargarSubastas;
$id_cliente = (int) $_SESSION['cliente']['id'];
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="page-title">
                    <h2>Mis Subastas</h2>
                </div>
                <div class="my-wishlist">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <div class="table-responsive">
                        <div class="buttons-set buttons-set2">
                            <form method="post" action="<?= URL; ?>cliente/agregarSubasta">
                                <input type="hidden" value="<?= $id_cliente; ?>" name="idCliente" />
                                <button class="button btn-add" title="Agregar Subasta" type="submit"><span>Agregar Subasta</span></button>
                            </form>
                        </div>
                        <table id="wishlist-table" class="clean-table linearize-table data-table">
                            <thead>
                                <tr class="first last">
                                    <th class="customer-wishlist-item-image"></th>
                                    <th class="customer-wishlist-item-info"></th>
                                    <th class="customer-wishlist-item-quantity"></th>
                                    <th class="customer-wishlist-item-price"></th>
                                    <th class="customer-wishlist-item-cart"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($subastas)): ?>
                                    <?php foreach ($subastas as $item): ?>
                                        <?php
                                        $imagen = explode('|', $item['imagen']);
                                        $nombre = utf8_encode($item['marca'] . ' - ' . utf8_encode($item['producto']));
                                        ?>
                                        <tr>
                                            <td class = "wishlist-cell0 customer-wishlist-item-image"><a title = "Softwear Women's Designer" href = "product_detail.html" class = "product-image"> <img width = "150" alt = "" src = "<?= IMAGE_SUBASTA . $imagen[0]; ?>"> </a></td>
                                            <td class = "wishlist-cell1 customer-wishlist-item-info"><h3 class = "product-name"><a title = "<?= $nombre; ?>" href = "product_detail.html"><?= $nombre; ?></a></h3>
                                                <div class = "description std">
                                                    <?= utf8_encode($item['descripcion_corta']); ?><br>
                                                    Fecha Inicio: <?= date('d-m-Y', strtotime($item['fecha_inicio'])); ?><br>
                                                    Fecha Fin: <?= date('d-m-Y', strtotime($item['fecha_fin'])); ?><br>
                                                    Oferta Minima: <?= $helper->getPrecioCarrito($item['oferta_minima']); ?>
                                                </div>
                                            <td data-rwd-label = "Quantity" class = "wishlist-cell2 customer-wishlist-item-quantity">
                                                <p class="availability <?= $item['css'] ?>"><span><?= $item['estado'] ?></span></p>
                                            </td>
                                            <td data-rwd-label = "Price" class = "wishlist-cell3 customer-wishlist-item-price">
                                                <label>Ofertas</label><br>
                                                <?php foreach ($item['ofertas'] as $value): ?>
                                                    <span class="text-primary"><?= $helper->getPrecioCarrito($value['monto_oferta']) . ' - ' . date('d-m-Y H:i:s', strtotime($value['fecha_oferta'])); ?></span>
                                                <?php endforeach; ?>
                                            </td>
                                            <td class = "wishlist-cell4 customer-wishlist-item-cart">
                                                <a  href="<?= URL; ?>cliente/modificar/<?= $item['id']; ?>"class="button" role="button" title="Modificar" name="do" type="button"><span>Modificar</span></a>
                                        </tr>
                                    <?php endforeach;
                                    ?>
                                <?php else: ?>
                                    <?php echo $helper->messageAlert('info', 'Aún no tienes ninguna subasta cargada.'); ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>
