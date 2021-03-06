<?php
$helper = new Helper();
$slider = $helper->getProductosSlider();
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
                        <!--                        <ul>
                        <?php
//                            $sliders = $helper->printBanner(1, 'ASC');
//                            foreach ($sliders as $slider) {
//                                echo $slider;
//                            }
                        ?>
                                                </ul>-->
                        <ul>
                            <?php foreach ($slider as $item): ?>
                                <?php
                                #Imagen a utilizar
                                $ruta = (!empty($item['img_destacada'])) ? "public/products-images/slider/" : "public/products-images/";
                                $imagen = (!empty($item['img_destacada'])) ? $item['img_destacada'] : $item['imagen'];
                                ?>
                                <li data-transition='random' data-slotamount='7' data-masterspeed='1000' data-thumb='<?= URL . $ruta . $imagen; ?>' class="black-text"><img src='<?= URL . $ruta . $imagen; ?>'  data-bgposition='left top'  data-bgfit='cover' data-bgrepeat='no-repeat' alt="banner"/>
                                    <div class='tp-caption LargeTitle sfl  tp-resizeme ' data-x='40'  data-y='40'  data-endspeed='500'  data-speed='500' data-start='1300' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:3; white-space:nowrap; color: #000;'><?= $item['nombre']; ?></div>
                                    <div class='tp-caption sfb  tp-resizeme ' data-x='40'  data-y='400'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Linear.easeNone' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'><a href='<?= $helper->urlProducto($item['id']); ?>' class="buy-btn">COMPRAR CUPON</a></div>
                                    <div class='tp-caption Title sft  tp-resizeme ' data-x='45'  data-y='85'  data-endspeed='500'  data-speed='500' data-start='1500' data-easing='Power2.easeInOut' data-splitin='none' data-splitout='none' data-elementdelay='0.1' data-endelementdelay='0.1' style='z-index:4; white-space:nowrap;'>
                                        <div class="price-box">
                                            <div class="price-box">
                                                <?php if ($item['precio_oferta'] > 0): ?>
                                                    <p class="special-price"> <span class="price" style="font-size: 16px;"> <?= $item['simbolo']; ?> <?= number_format($item['precio_oferta'], 0, ',', '.'); ?> </span> </p>
                                                    <p class="old-price" > <span class="price-sep">-</span> <span class="price" style="font-size: 14px;"> <?= $item['simbolo']; ?> <?= number_format($item['precio'], 0, ',', '.'); ?> </span> </p>
                                                <?php else: ?>
                                                    <span class="regular-price"> <span class="price" style="font-size: 16px;"><?= $item['simbolo']; ?> <?= number_format($item['precio'], 0, ',', '.'); ?></span> </span> 
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="main-example contadorSlider">
                                        <div class="countdown-container tiempoRestante" id="main-example">
                                            <div class="time weeks flip">
                                                <span class="label">sem</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                            <div class="time days flip">
                                                <span class="label">dias</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                            <div class="time hours flip">
                                                <span class="label">horas</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                            <div class="time minutes flip">
                                                <span class="label">min</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                            <div class="time seconds flip">
                                                <span class="label">seg</span>
                                                <span class="count curr top">00</span>
                                                <span class="count next top">00</span>
                                                <span class="count next bottom">00</span>
                                                <span class="count curr bottom">00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <script type="text/javascript">
                                        $(window).on('load', function () {
                                            var contador = 1;
                                            var labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'],
                                                    //nextYear = (new Date().getFullYear() + 1) + '/01/01',
                                                    nextYear = '<?= $item['fecha_fin']; ?>',
                                                    template = _.template($('#main-example-template').html()),
                                                    currDate = '00:00:00:00:00',
                                                    nextDate = '00:00:00:00:00',
                                                    parser = /([0-9]{2})/gi,
                                                    //$example = $('#main-example');
                                                    $example = $('.tiempoRestante');
                                            // Parse countdown string to an object
                                            function strfobj(str) {
                                                var parsed = str.match(parser),
                                                        obj = {};
                                                labels.forEach(function (label, i) {
                                                    obj[label] = parsed[i]
                                                });
                                                return obj;
                                            }
                                            // Return the time components that diffs
                                            function diff(obj1, obj2) {
                                                var diff = [];
                                                labels.forEach(function (key) {
                                                    if (obj1[key] !== obj2[key]) {
                                                        diff.push(key);
                                                    }
                                                });
                                                return diff;
                                            }
                                            // Build the layout
                                            var initData = strfobj(currDate);
                                            labels.forEach(function (label, i) {
                                                $example.append(template({
                                                    curr: initData[label],
                                                    next: initData[label],
                                                    label: label
                                                }));
                                            });
                                            // Starts the countdown
                                            $example.countdown(nextYear, function (event) {
                                                var newDate = event.strftime('%w:%d:%H:%M:%S'),
                                                        data;
                                                if (newDate !== nextDate) {
                                                    currDate = nextDate;
                                                    nextDate = newDate;
                                                    // Setup the data
                                                    data = {
                                                        'curr': strfobj(currDate),
                                                        'next': strfobj(nextDate)
                                                    };
                                                    // Apply the new values to each node that changed
                                                    diff(data.curr, data.next).forEach(function (label) {
                                                        var selector = '.%s'.replace(/%s/, label),
                                                                $node = $example.find(selector);
                                                        // Update the node
                                                        $node.removeClass('flip');
                                                        $node.find('.curr').text(data.curr[label]);
                                                        $node.find('.next').text(data.next[label]);
                                                        // Wait for a repaint to then flip
                                                        _.delay(function ($node) {
                                                            $node.addClass('flip');
                                                        }, 50, $node);
                                                    });
                                                }
                                                var days = data['next']['days'];
                                                var hours = data['next']['hours'];
                                                var seconds = data['next']['seconds'];
                                                var minutes = data['next']['minutes'];
                                                var weeks = data['next']['weeks'];
                                                if (days == '00' && hours == '00' && seconds == '00' && minutes == '00' && weeks == '00') {
                                                    var ajax_call = function () {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?= URL; ?>producto/liveVideo',
                                                            dataType: 'json',
                                                            success: function (data) {
                                                                $('#liveVideo').css('display', 'block');
                                                                if (data == 'noLive') {
                                                                    $('#liveVideo').html('');
                                                                    $('#liveVideo').html('<img src="<?= IMAGES; ?>live-video.jpg" />');
                                                                } else {
                                                                    if (contador == 1) {
                                                                        $('#liveVideo').html('');
                                                                        $('#liveVideo').html(data);
                                                                        contador += 1;
                                                                    }
                                                                }
                                                            },
                                                            error: function () {
                                                                // failed request; give feedback to user
                                                                $('#liveVideo').html('<p class="error"><strong>Oops!</strong> Ha ocurrido un error.</p>');
                                                            }
                                                        });
                                                    };
                                                    setTimeout(ajax_call, 500); //primera ejecucion
                                                    var interval = 10000; // 1000 = 1s
                                                    setInterval(ajax_call, interval);
                                                }
                                            });
                                        });
                                    </script>
                                </li>
                            <?php endforeach; ?>
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
<!--<section class="main-container col1-layout home-content-container">
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
//                            $masvistos = $helper->productoDestacado(1, 'ASC');
//                            foreach ($masvistos as $vistos) {
//                                echo $vistos;
//                            }
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- End main container --> 
<!-- Featured Slider -->
<section class="featured-pro wow animated parallax parallax-2">
    <div class="container">
        <div class="std">
            <img src="<?= URL; ?>public/images/banner_900.png" class="img-responsive" style=" margin: 0 auto;"/>
            <div class="slider-items-products">
                <div class="featured_title center">
                    <!--<h2>Productos Destacados</h2>-->
                </div>
                <div id="featured-slider" class="product-flexslider hidden-buttons">

                    <div class="slider-items slider-width-col4"> 
                        <?php
//                        $destacados = $helper->productoDestacado(2, 'ASC');
//                        foreach ($destacados as $destacado) {
//                            echo $destacado;
//                        }
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Featured Slider --> 

<!-- middle slider -->
<!--<section class="middle-slider container">
    <div class="row">
        <div class="col-sm-4 wow bounceInUp">
            <div class="inner-div">
                <h2 class="category-pro-title"><span>Electrodomesticos</span></h2>
                <div class="category-products">
                    <div class="products small-list">
<?php
//                        $catDestacados = $helper->mostrarCatIndex(4);
//                        foreach ($catDestacados as $categoria) {
//                            echo $categoria;
//                        }
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
//                        $catDestacados = $helper->mostrarCatIndex(5);
//                        foreach ($catDestacados as $categoria) {
//                            echo $categoria;
//                        }
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
//                        $catDestacados = $helper->mostrarCatIndex(6);
//                        foreach ($catDestacados as $categoria) {
//                            echo $categoria;
//                        }
?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- End middle slider --> 
<!-- promo banner section -->
<!--<div class="promo-banner-section container wow bounceInUp animated">
    <div class="container">
        <div class="row"> <img alt="promo-banner3" src="<?php //echo URL;                      ?>public/images/pub-exclusiva-proteccion.jpg"></div>
    </div>
</div>-->
<!-- End promo banner section --> 
<!-- recommend slider -->
<!--<section class="recommend container">
    <div class="recommend-product-slider small-pr-slider wow bounceInUp">
        <div class="slider-items-products">
            <div class="new_title center">
                <h2>Recomendados</h2>
            </div>
            <div id="recommend-slider" class="product-flexslider hidden-buttons">
                <div class="slider-items slider-width-col3"> 
<?php
//                    $recomendados = $helper->productoDestacado(3, 'ASC');
//                    foreach ($recomendados as $recomendado) {
//                        echo $recomendado;
//                    }
?>
                </div>
            </div>
        </div>
    </div>
</section>-->
<!-- End Recommend slider --> 
<!-- Latest Blog -->
<!--<section class="latest-blog container">
    <div class="blog-title">
        <h2><span>Quiero</span></h2>
    </div>
    <div class="woman bounceInUp animated"></div>
    <div class="col-xs-12 col-sm-4 wow bounceInLeft animated">
        <div class="blog-img"> <img src="<?php //echo URL;                      ?>public/images/ico-subastar.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Subastar</a> </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 wow bounceInUp animated">
        <div class="blog-img"> <img src="<?php //echo URL;                      ?>public/images/ico-vender.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Vender</a> </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 wow bounceInRight animated">
        <div class="blog-img"> <img src="<?php //echo URL;                      ?>public/images/ico-canjear.png" alt="Image">
            <div class="mask"> <a class="info" href="blog_detail.html">Canjear</a> </div>
        </div>
    </div>
</section>-->
<!-- End Latest Blog -->