<?php $helper = new Helper(); ?>
<section class="main-container col2-left-layout">
    <?php if (!empty($this->mostrarBanner)): ?>
        <!-- category banner -->
        <div class="category-description std container">
            <div class="slider-items-products">
                <div id="category-desc-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col1"> 
                        <?php
                        $sliders = $this->mostrarBanner;
                        foreach ($sliders as $slider) {
                            echo $slider;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <!-- category banner -->
    <div class="main container">
        <div class="row">
            <div class="col-main col-sm-9 col-sm-push-3 wow bounceInUp animated">
                <div class="category-title">
                    <h1><?php echo $this->categoria; ?></h1>
                </div>

                <div class="category-products">
                    <?php
                    if (isset($_SESSION['message'])) {
                        echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                    }
                    ?>
                    <div class="toolbar">
                        <div class="pager">
                            <div class="pages">
                                <?php echo $this->paginas; ?>
                            </div>
                        </div>
                    </div>
                    <ul class="products-grid" id="listaProductos">
                        <?php
                        if (!empty($this->paginacion[0])) {
                            foreach ($this->paginacion as $lista) {
                                echo $lista;
                            }
                        } else {
                            echo $helper->messageAlert('info', 'Aún no hay productos para mostrar en esta categoría');
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <aside class="col-left sidebar col-sm-3 col-xs-12 col-sm-pull-9 wow bounceInUp animated">
                <div class="side-nav-categories">
                    <div class="block-title"> Categorías </div>
                    <div class="box-content box-category">
                        <ul id="magicat">
                            <?php
                            foreach ($this->categoriasHijas as $item) {
                                echo $item;
                            }
                            ?>

                        </ul>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>