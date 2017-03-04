<?php $helper = new Helper(); ?>
<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="my-account">
                    <div class="page-title">
                        <h2>Mis Direcciones</h2>
                    </div>
                    <div class="my-wishlist">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <div class="table-responsive">
                            <fieldset>
                                <input type="hidden" value="ROBdJO5tIbODPZHZ" name="form_key">
                                <table id="wishlist-table" class="clean-table linearize-table data-table">
                                    <thead>
                                        <tr class="first last">
                                            <th class="customer-wishlist-item-info"></th>
                                            <th class="customer-wishlist-item-cart"></th>
                                            <th class="customer-wishlist-item-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($this->getAllDirections)): ?>
                                            <?php
                                            foreach ($this->getAllDirections as $item) {
                                                echo $item;
                                            }
                                            ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="4">
                                                    <?php echo $helper->messageAlert('info', 'Aún no ha ingresado ninguna dirección de envío'); ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                                <div class="buttons-set buttons-set2">
                                    <a href="<?php echo URL; ?>cliente/agregarDireccion/" class="button btn-add" title="Agregar nueva Dirección" type="button"><span>Agregar Nueva Dirección</span></a>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </section>
            <?php echo $this->acountSidebar; ?>
        </div>
    </div>
</div>