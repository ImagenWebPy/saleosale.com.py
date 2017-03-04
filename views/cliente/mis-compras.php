<?php $helper = new Helper(); ?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="my-account">
                    <div class="page-title">
                        <h2>Mi Compras</h2>
                    </div>
                    <div class="dashboard">
                        <div class="recent-orders">
                            <div class="table-responsive">
                                <table class="data-table" id="my-orders-table">

                                    <thead>
                                        <tr class="first last">
                                            <th>Orden #</th>
                                            <th>Fecha</th>
                                            <th>Enviado a </th>
                                            <th><span class="nobr">Monto Total</span></th>
                                            <th>Estado</th>
                                            <th>&nbsp;</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $ordernes = $this->getOrders; ?>
                                        <?php if (!empty($ordernes)): ?>
                                            <?php foreach ($ordernes as $item): ?>
                                                <tr class="first odd">
                                                    <td><?php echo $item['id']; ?></td>
                                                    <td><?php echo date('d-m-Y H:i:s', strtotime($item['fecha_pedido'])); ?></td>
                                                    <td><?php echo utf8_encode($item['direccion']) . '<br>' . utf8_encode($item['barrio']) . ' - ' . utf8_encode($item['ciudad']); ?></td>
                                                    <td><span class="price"><?php echo $helper->getPrecioCarrito($item['monto_total']); ?></span></td>
                                                    <td><em></em></td>
                                                    <td class="a-center last"><span class="nobr"> <a href="<?php echo URL . 'cliente/ordenes/' . $item['id']; ?>">Ver Orden</a></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="6">
                                                    <?php echo $helper->messageAlert('info', 'Aún no ha realizado ningún pedido en el sitio'); ?>
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
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>