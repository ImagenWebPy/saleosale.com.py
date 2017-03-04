<?php
$helper = new Helper();
$datos = $this->getSuscripcion;
?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">

                <div class="account-login">
                    <div class="page-title">
                        <h2>Newsletter</h2>
                    </div>
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <form method="POST" action="<?php echo URL; ?>cliente/suscripcion">
                        <fieldset class="col2-set">
                            <div class="col-3 registered-users">
                                <?php if ($datos['existe'] == 1): ?>
                                    <div class="content">
                                        <?php echo $helper->messageAlert('success', 'Ya estas registrado a nuestro newsletter'); ?>
                                        <div class="buttons-set">
                                            <input type="hidden" name="subscripcion[email]" value="<?php echo $datos['email']; ?>" />
                                            <input type="hidden" name="subscripcion[existe]" value="<?php echo $datos['existe']; ?>" />
                                            <button type="submit" class="btn btn-danger"><span>Cancelar Suscripción</span></button>
                                    </div>
                                <?php else: ?>
                                    <div class="content">
                                        <?php echo $helper->messageAlert('warning', 'Aún no estas registrado a nuestro Newsletter. ¿Qué estas esperando? '); ?>
                                        <div class="buttons-set">
                                            <input type="hidden" name="subscripcion[existe]" value="<?php echo $datos['existe']; ?>" />
                                            <input type="hidden" name="subscripcion[email]" value="<?php echo $datos['email']; ?>" />
                                            <input type="hidden" name="subscripcion[nombre_completo]" value="<?php echo $datos['nombre_completo']; ?>" />
                                            <button type="submit" class="btn btn-success"><span>SUSCRIBIRME</span></button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>