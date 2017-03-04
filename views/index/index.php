<?php
$helper = new Helper();
?>
<!-- Slider -->
<?php
if (isset($_SESSION['message'])) {
    echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
}
?>
<div id="magik-slideshow" class="magik-slideshow">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-sm-12 col-md-8 wow bounceInUp animated">
                <div id='rev_slider_4_wrapper' class='rev_slider_wrapper fullwidthbanner-container' >
                    <div id='rev_slider_4' class='rev_slider fullwidthabanner'>
                        <ul>
                            <?php
                            $sliders = $helper->printBanner(1, 'ASC');
                            foreach ($sliders as $slider) {
                                echo $slider;
                            }
                            ?>
                        </ul>
                        <div class="tp-bannertimer"></div>
                    </div>
                </div>
            </div>
            <aside class="col-xs-12 col-sm-12 col-md-4 wow bounceInUp animated">
                <?php
                $leftBanners = $helper->printBanner(2, 'ASC');
                foreach ($leftBanners as $banner) {
                    echo $banner;
                }
                ?>
            </aside>
        </div>
    </div>
</div>
<!-- end Slider --> 
<!-- offer banner section -->
<div class="offer-banner-section">
    <div class="container">
        <div class="row">
            <?php
            $bottomBanners = $helper->printBanner(3, 'ASC');
            foreach ($bottomBanners as $bottom) {
                echo $bottom;
            }
            ?>
        </div>
    </div>
</div>
<!-- end offer banner section --> 
<!-- main container -->
<section class="main-container col1-layout home-content-container">
    <div class="container">
        <div class="std">
            <div class="best-seller-pro wow bounceInUp animated">
                <div class="slider-items-products">
                    <div class="new_title center">
                        <h2>Más Vistos</h2>
                    </div>
                    <div id="best-seller-slider" class="product-flexslider hidden-buttons">
                        <div class="slider-items slider-width-col4"> 
                            <?php
                            $masvistos = $helper->productoDestacado(1, 'ASC');
                            foreach ($masvistos as $vistos) {
                                echo $vistos;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End main container --> 
<!-- Featured Slider -->
<section class="featured-pro wow animated parallax parallax-2">
    <div class="container">
        <div class="std">
            <div class="slider-items-products">
                <div class="featured_title center">
                    <h2>Productos Destacados</h2>
                </div>
                <div id="featured-slider" class="product-flexslider hidden-buttons">
                    <div class="slider-items slider-width-col4"> 
                        <?php
                        $destacados = $helper->productoDestacado(2, 'ASC');
                        foreach ($destacados as $destacado) {
                            echo $destacado;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Slider --> 

<!-- middle slider -->
<section class="middle-slider container">
    <div class="row">
        <div class="col-sm-4 wow bounceInUp">
            <div class="inner-div">
                <h2 class="category-pro-title"><span>Electrodomesticos</span></h2>
                <div class="category-products">
                    <div class="products small-list">
                        <?php
                        $catDestacados = $helper->mostrarCatIndex(4);
                        foreach ($catDestacados as $categoria) {
                            echo $categoria;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 wow bounceInUp">
            <div class="inner-div">
                <h2 class="category-pro-title"><span>Climatización</span></h2>
                <div class="category-products">
                    <div class="products small-list">
                        <?php
                        $catDestacados = $helper->mostrarCatIndex(5);
                        foreach ($catDestacados as $categoria) {
                            echo $categoria;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4 wow bounceInUp">
            <div class="inner-div1">
                <h2 class="category-pro-title"><span>Varios</span></h2>
                <div class="category-products">
                    <div class="products small-list">
                        <?php
                        $catDestacados = $helper->mostrarCatIndex(6);
                        foreach ($catDestacados as $categoria) {
                            echo $categoria;
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End middle slider --> 
<!-- promo banner section -->
<!--<div class="promo-banner-section container wow bounceInUp animated">
    <div class="container">
        <div class="row"> <img alt="promo-banner3" src="<?php //echo URL; ?>public/images/pub-exclusiva-proteccion.jpg"></div>
    </div>
</div>-->
<!-- End promo banner section --> 
<!-- recommend slider -->
<section class="recommend container">
    <div class="recommend-product-slider small-pr-slider wow bounceInUp">
        <div class="slider-items-products">
            <div class="new_title center">
                <h2>Recomendados</h2>
            </div>
            <div id="recommend-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col3"> 
                    <?php
                    $recomendados = $helper->productoDestacado(3, 'ASC');
                    foreach ($recomendados as $recomendado) {
                        echo $recomendado;
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Recommend slider --> 
<!-- Latest Blog -->
<!--<section class="latest-blog container">
    <div class="blog-title">
        <h2><span>Quiero</span></h2>
    </div>
    <div class="woman bounceInUp animated"></div>
    <div class="col-xs-12 col-sm-4 wow bounceInLeft animated">
        <div class="blog-img"> <img src="<?php //echo URL; ?>public/images/ico-subastar.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Subastar</a> </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 wow bounceInUp animated">
        <div class="blog-img"> <img src="<?php //echo URL; ?>public/images/ico-vender.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Vender</a> </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 wow bounceInRight animated">
        <div class="blog-img"> <img src="<?php //echo URL; ?>public/images/ico-canjear.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Canjear</a> </div>
        </div>
    </div>
</section>-->
<!-- End Latest Blog -->