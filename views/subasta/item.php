<?php
$helper = new Helper();
$subasta = $this->getItemSubasta;
$imgs = explode('|', $subasta['imagen']);
$imagenes = $imgs;
#quitamos el primer elemento del array
$img_principal = array_shift($imgs);
$idSubasta = $subasta['id_subasta'];
$idCliente = $_SESSION['cliente']['id'];
$ofertas = $helper->getSubastaOfertas($idSubasta, 8);
$montoOfertaActual = $helper->obtenerOfertaActual($idSubasta);
$cantOfertas = count($ofertas);
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="row">
                <div class="product-view wow bounceInUp animated">
                    <div class="product-essential">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <form action="#" method="post" id="product_addtocart_form">
                            <div class="product-img-box col-lg-5 col-sm-5 col-md-5 col-xs-12 wow bounceInRight animated">
                                <div class="product-image">
                                    <div class="large-image"><a href="<?php echo IMAGE_SUBASTA . $img_principal ?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img src="<?php echo IMAGE_SUBASTA . $img_principal ?>" alt="<?php echo $img_principal; ?>"></a></div>
                                    <div class="flexslider flexslider-thumb">
                                        <ul class="previews-list slides">
                                            <?php foreach ($imagenes as $imagen): ?>
                                                <li><a href='<?php echo IMAGE_SUBASTA . $imagen ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo IMAGE_SUBASTA . $imagen ?>' "><img src="<?php echo IMAGE_SUBASTA . $imagen ?>" alt = "<?php echo $imagen ?>"/></a></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    </div>
                                </div>
                                <!-- end: more-images -->
                                <div class="clear"></div>
                            </div>
                            <div class="product-shop col-lg-4 col-sm-4 col-xs-12">
                                <div class="product-name">
                                    <h1><?php echo utf8_encode($subasta['marca']) . ' - ' . utf8_encode($subasta['nombre']); ?></h1> 
                                </div>
                                <div class="ratings">
                                    <span class="rating-links pull-right" style=" position: relative; top:-5px;"> <a href="#"><span id="cantOfertas"><?= $cantOfertas; ?></span> Oferta(s)</a></span>
                                </div>
                                <div class="price-block">
                                    <div class="price-box">
                                        <p class="special-price"> <span class="price-label">Oferta Actual</span> <span class="price" id="price"> <?= (!empty($montoOfertaActual[0]['oferta'])) ? $helper->getPrecioCarrito($montoOfertaActual[0]['oferta']) : $helper->getPrecioCarrito($subasta['oferta_minima']); ?> </span> </p>
                                    </div>
                                </div>
                                <div class="add-to-box">
                                    <div class="add-to-cart">
                                        <label for="qty">Monto a Ofertar:</label>
                                        <div class="pull-left">
                                            <div class="custom pull-left">
                                                <input type="text" class="input-text qty" title="Monto" value="<?= (!empty($montoOfertaActual[0]['oferta'])) ? round($montoOfertaActual[0]['oferta'] + 5000, 0) : round($subasta['oferta_minima'] + 5000, 0); ?>" maxlength="12" id="monto" name="monto" style=" width: 100px; color: #312d2d;">
                                                <input type="hidden" value="<?= round($montoOfertaActual[0]['oferta'], 0); ?>" id="ofertActual">
                                                <input type="hidden" value="<?= $idSubasta; ?>" id="id_subasta">
                                                <input type="hidden" value="<?= $idCliente; ?>" id="id_cliente">
                                                <button id="plus" class="increase items-count" type="button"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                                <button id="min" class="reduced items-count" type="button"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                        <?php if ($subasta['estado'] == 'Habilitada'): ?>
                                            <div>
                                                <button class="button btn-ofertar" title="Ofertar" type="button" id="ofertar"><span style=" font-size: 15px;"><i class="fa fa-gavel" aria-hidden="true"></i> Ofertar</span></button>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="short-description">
                                    <h2>Breve Descripción</h2>
                                    <?= $subasta['descripcion_corta']; ?>
                                </div>

                            </div>
                            <aside class="col-lg-3 col-sm-3 col-xs-12">
                                <h3>Ofertas</h3>
                                <div id="listarOfertas">
                                    <?php if (!empty($ofertas[0]['fecha_oferta'])): ?>
                                        <?php foreach ($ofertas as $item): ?>
                                            <div class="brand-img">	
                                                <p class="text-bold text-orange" style="padding-top: 10px;"><?= $helper->getPrecioCarrito($item['monto_oferta']) . ' el ' . date('d-m-Y H:i:s', strtotime($item['fecha_oferta'])); ?></p>
                                            </div>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <div class="brand-img">	
                                            <p class="text-bold text-orange" style="padding-top: 10px;">0 Ofertas</p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </aside>
                        </form>
                    </div>
                    <div class="product-collateral">
                        <div class="col-sm-12 wow bounceInUp animated">
                            <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                                <li class="active"> <a href="#product_tabs_description" data-toggle="tab"> Descripción del Producto </a> </li>
                            </ul>
                            <div id="productTabContent" class="tab-content">
                                <div class="tab-pane fade in active" id="product_tabs_description">
                                    <div class="std">
                                        <?= $subasta['contenido']; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    $(document).ready(function () {
        $('#min').click(function () {
            //Solo si el valor del campo es diferente de 0
            if ($('#monto').val() != 0)
                //Decrementamos su valor
                $('#monto').val(parseInt($('#monto').val()) - 5000);
        });
        $('#plus').click(function () {
            //Aumentamos el valor del campo
            $('#monto').val(parseInt($('#monto').val()) + 5000);
        });
        $('#ofertar').click(function () {
            var monto = $('#monto').val();
            var ofertActual = $('#ofertActual').val();
            var id_subasta = $('#id_subasta').val();
            var id_cliente = $('#id_cliente').val();
            $.ajax({
                type: "POST",
                url: "<?= URL; ?>subasta/ofertar",
                dataType: "json",
                method: "POST",
                data: {monto: monto, ofertActual: ofertActual, id_subasta: id_subasta, id_cliente: id_cliente},
                success: function (data) {
                    if (data == 'error') {
                        location.reload();
                    } else {
                        var listaOfertas = $('#listarOfertas');
                        var price = $('#price');
                        var monto = $('#monto');
                        var cantOfertas = $('#cantOfertas');
                        listaOfertas.prepend('<div class="brand-img"><p class="text-bold text-orange" style="padding-top: 10px;">' + data.monto_oferta + ' - ' + data.fecha_oferta + '</p></div>');
                        price.html('');
                        price.html(data.monto_oferta);
                        monto.html('');
                        monto.html(data.monto);
                        cantOfertas.html('');
                        cantOfertas.html(data.cant);
                    }
                }
            });
        });
    });
</script>