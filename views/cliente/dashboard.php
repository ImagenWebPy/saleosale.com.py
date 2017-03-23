<?php $helper = new Helper(); ?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="my-account">
                    <div class="page-title">
                        <h2>Mi Panel</h2>
                    </div>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <div class="dashboard">
                        <div class="welcome-msg"> <strong>Hola <?php echo $_SESSION['cliente']['nombre'] . ' ' . $_SESSION['cliente']['apellido'] ?></strong>
                            <p>Desde el panel de su cuenta, usted tiene la posibilidad de ver toda la actividad de su cuenta y actualizar la información de la misma. Seleccionar un enlace a continuación para ver o editar la información.</p>
                        </div>
                        <div class="recent-orders">
                            <div class="title-buttons"><strong>Ordenes Recientes</strong> <a href="#">Ver Todas </a> </div>
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
                                        <?php $ordernes = $this->getRecentOrdes; ?>
                                        <?php if (!empty($ordernes)): ?>
                                            <?php foreach ($ordernes as $item): ?>
                                                <tr class="first odd">
                                                    <td><?php echo $item['id']; ?></td>
                                                    <td><?php echo date('d-m-Y H:i:s', strtotime($item['fecha_pedido'])); ?></td>
                                                    <td><?php echo utf8_encode($item['direccion']) . '<br>' . utf8_encode($item['barrio']) . ' - ' . utf8_encode($item['ciudad']); ?></td>
                                                    <td><span class="price"><?php echo $helper->getPrecioCarrito($item['monto_total']); ?></span></td>
                                                    <td><em></em></td>
                                                    <td class="a-center last"><span class="nobr"> <a href="<?php echo URL. 'cliente/ordenes/'.$item['id'];?>">Ver Orden</a></td>
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
                        <div class="box-account">
                            <div class="page-title">
                                <h2>Información de la cuenta</h2>
                            </div>
                            <div class="col2-set">
                                <div class="col-1">
                                    <h5 class="text-primary"><strong>Información de la Cuenta</strong></h5>
                                    <a href="<?php echo URL; ?>cliente/cuenta/">Editar</a>
                                    <p> <?php echo utf8_encode($_SESSION['cliente']['nombre']) . ' ' . utf8_encode($_SESSION['cliente']['apellido']); ?><br>
                                        <?php echo $_SESSION['cliente']['email']; ?><br>
                                        <a href="<?php echo URL; ?>cliente/cambiar_contrasena/">Cambiar Contraseña</a> </p>
                                </div>
                                <div class="col-2">
                                    <h5 class="text-primary"><strong>Newsletters</strong></h5>
                                    <a href="<?php echo URL; ?>cliente/newsletter">Editar Suscripción</a>
                                </div>
                            </div>
<!--                            <div class="col2-set">
                                <h4 class="text-primary"><strong>Direcciones</strong></h4>
                                <div class="manage_add"><a href="<?php echo URL; ?>cliente/direcciones/">Administrar Direcciones</a> </div>
                                <div class="col-1">
                                    <h5>Dirección Principal de Envío</h5>
                                    <?php $direcion = $this->getMainDirection; ?>
                                    <?php if (!empty($direcion)): ?>
                                        <?php echo $direcion; ?>
                                    <?php else: ?>
                                        <?php echo $helper->messageAlert('info', 'No tiene asignada ninguna dirección de envío'); ?>
                                    <?php endif; ?>
                                </div>
                            </div>-->
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>