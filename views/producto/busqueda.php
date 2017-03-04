<?php $helper = new Helper(); ?>
<section class="main-container col2-left-layout">
    <!-- category banner -->
    <div class="main container">
        <div class="row">
            <div class="col-main col-sm-12 wow bounceInUp animated">
                <div class="category-title">
                    <h1><?php //echo $string;   ?></h1>
                </div>

                <div class="category-products">
                    <div class="toolbar">
                        <div class="pager">
                            <div class="pages">
                                <?php echo $this->paginas; ?>
                            </div>
                        </div>
                    </div>
                    <ul class="products-grid" id="listaProductos">
                        <?php
                        foreach ($this->searchResult as $lista) {
                            echo $lista;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="upsell-pro wow bounceInUp animated">
                <div class="slider-items-products">
                    <div class="new_title center">
                        <h2>Te recomendamos</h2>
                    </div>
                    <div id="upsell-products-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4"> 
                            <?php
                            $masVendidos = $helper->productoDestacado(7, 'ASC');
                            foreach ($masVendidos as $vendidos) {
                                echo $vendidos;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>