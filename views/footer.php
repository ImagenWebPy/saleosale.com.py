<?php $helper = new Helper(); ?>
<footer class="footer bounceInUp animated">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-7">
                    <div class="block-subscribe">
                        <div class="newsletter">
                            <form method="POST" action="<?php echo URL; ?>footer/newsletter/">
                                <h4>newsletter</h4>
                                <input type="text" placeholder="Ingresa tu dirección de Email" class="input-text required-entry validate-email" title="Suscribite a nuestro Newsletter" name="newsletter[email]">
                                <button class="subscribe" title="Suscribite" type="submit"><span>Suscribite</span></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-5">
                    <div class="social">
                        <ul>
                            <li class="fb"><a href="#"></a></li>
                            <li class="tw"><a href="#"></a></li>
                            <li class="linkedin"><a href="#"></a></li>
                            <li class="youtube"><a href="#"></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-middle container">
        <div class="col-md-3 col-sm-4">
            <div class="footer-logo"><a href="/" title="Logo"><img src="<?php echo URL; ?>public/images/logo-footer.png" alt="logo"></a></div>
            <p>&COPY;Sale O Sale - Sale O Sale y su isotipo de la S con la mano haciendo ok son marcas registradas de SACO  </p>
            <div class="payment-accept">
                <div class="row">
                    <img src="<?php echo IMAGES; ?>tarjetas.png" alt="tarjetas" style=" width: 100%;">
                </div>
                <div class="row">
                    <div class="col-sm-6 text-center">
                        <img src="<?php echo IMAGES; ?>billetera-personal.png" alt="billetera personal" />
                    </div>
                    <div class="col-md-6 text-center">
                        <img src="<?php echo IMAGES; ?>tigo-money.png" alt="tigo money" />
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Guía de Compras</h4>
            <?php echo $helper->getPaginas(1); ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Información</h4>
            <?php echo $helper->getPaginas(2); ?>
        </div>
        <div class="col-md-3 col-sm-4">
            <h4>Contactenos</h4>
            <div class="contacts-info">
                <address>
                    <i class="add-icon">&nbsp;</i>Santa Rosa 668 c/ España <br>
                    &nbsp;Asunción - Paraguay 
                </address>
                <div class="phone-footer"><i class="phone-icon">&nbsp;</i> (+595 021) 224 500 </div>
                <div class="email-footer"><i class="email-icon">&nbsp;</i> <a href="mailto:info@saleosale.com.py">info@saleosale.com.py</a> </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom container">
        <div class="col-sm-5 col-xs-12 coppyright"> &copy; Todos los derechos reservados.</div>
        <div class="col-sm-7 col-xs-12 company-links">

        </div>
    </div>
</footer>
<!-- End Footer --> 
</div>
<!-- JavaScript --> 

<script type="text/javascript" src="<?php echo URL; ?>public/js/bootstrap.min.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>public/js/parallax.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>public/js/common.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>public/js/revslider.js"></script> 
<script type="text/javascript" src="<?php echo URL; ?>public/js/owl.carousel.min.js"></script> 
<script type='text/javascript'>
    jQuery(document).ready(function () {
        jQuery('#rev_slider_4').show().revolution({
            dottedOverlay: 'none',
            delay: 5000,
            startwidth: 770,
            startheight: 460,
            hideThumbs: 200,
            thumbWidth: 200,
            thumbHeight: 50,
            thumbAmount: 2,
            navigationType: 'thumb',
            navigationArrows: 'solo',
            navigationStyle: 'round',
            touchenabled: 'on',
            onHoverStop: 'on',
            swipe_velocity: 0.7,
            swipe_min_touches: 1,
            swipe_max_touches: 1,
            drag_block_vertical: false,
            spinner: 'spinner0',
            keyboardNavigation: 'off',
            navigationHAlign: 'center',
            navigationVAlign: 'bottom',
            navigationHOffset: 0,
            navigationVOffset: 20,
            soloArrowLeftHalign: 'left',
            soloArrowLeftValign: 'center',
            soloArrowLeftHOffset: 20,
            soloArrowLeftVOffset: 0,
            soloArrowRightHalign: 'right',
            soloArrowRightValign: 'center',
            soloArrowRightHOffset: 20,
            soloArrowRightVOffset: 0,
            shadow: 0,
            fullWidth: 'on',
            fullScreen: 'off',
            stopLoop: 'off',
            stopAfterLoops: -1,
            stopAtSlide: -1,
            shuffle: 'off',
            autoHeight: 'off',
            forceFullWidth: 'on',
            fullScreenAlignForce: 'off',
            minFullScreenHeight: 0,
            hideNavDelayOnMobile: 1500,
            hideThumbsOnMobile: 'off',
            hideBulletsOnMobile: 'off',
            hideArrowsOnMobile: 'off',
            hideThumbsUnderResolution: 0,
            hideSliderAtLimit: 0,
            hideCaptionAtLimit: 0,
            hideAllCaptionAtLilmit: 0,
            startWithSlide: 0,
            fullScreenOffsetContainer: ''
        });
    });
</script>
<?php
#cargamos los js de las vistas
if (isset($this->external_js)) {
    foreach ($this->external_js as $external) {
        echo '<script async defer src="' . $external . '"></script>';
    }
}

if (isset($this->public_js)) {
    foreach ($this->public_js as $public_js) {
        echo '<script type="text/javascript" src="' . URL . 'public/js/' . $public_js . '"></script>';
    }
}
if (isset($this->public_folder)) {
    foreach ($this->public_folder as $public_folder) {
        echo '<script type="text/javascript" src="' . URL . 'public/' . $public_folder . '"></script>';
    }
}
if (isset($this->js)) {
    foreach ($this->js as $js) {
        echo '<script type="text/javascript" src="' . URL . 'views/' . $js . '"></script>';
    }
}
?>
</body>
</html>

