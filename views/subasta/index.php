<?php
$helper = new Helper();
$paginador = $this->paginacion;
$subastas = $this->listarSubastas;
?>
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
    <div class="main container">
        <div class="row">
            <div class="col-main col-md-12 bounceInUp animated">
                <div class="category-title">
                    <h1>Subastas</h1>
                </div>
                <div class="category-products">
                    <div class="toolbar">
                        <?= $paginador; ?>
                    </div>
                    <?php if (!empty($subastas)): ?>
                        <ol id="products-list" class="products-list">
                            <?php foreach ($subastas as $item): ?>
                                <?php
                                $imagenes = explode('|', $item['imagen']);
                                $oferta_actual = $helper->obtenerOfertaActual($item['id']);
                                if (!empty($oferta_actual)) {
                                    $ofertaActual = $oferta_actual;
                                } else {
                                    $ofertaActual = array('oferta' => $item['oferta_minima'], 'fecha_oferta' => $item['fecha_inicio']);
                                }
                                ?>
                                <li class="item odd">
                                    <div class="product-image"> <a href="<?= URL; ?>subasta/item/<?= $item['id']; ?>" title="HTC Rhyme Sense"> <img class="small-image" src="<?= IMAGE_SUBASTA . $imagenes[0] ?>" alt="<?= utf8_encode($item['nombre']) ?>" width="230"> </a> </div>
                                    <div class="product-shop">
                                        <main>
                                            <h5>Esta subasta finaliza en</h5>
                                            <div class="home-welcome">
                                                <div class="main-example">
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
                                                        });
                                                    });
                                                </script>
                                            </div>
                                        </main>
                                        <h2 class="product-name"><a title="<?= utf8_encode($item['nombre']); ?>" href="<?= URL; ?>subasta/<?= $item['id']; ?>"> <?= utf8_encode($item['marca']) . ' - ' . utf8_encode($item['nombre']); ?> </a></h2>
                                        <div class="price-box">
                                            <p class="text-gray" style=" display: inline-block; font-size: 13px;"> Oferta Actual </p>
                                            <p class="special-price"> <span class="price-label"></span> <span id="product-price-212" class="price" style=" font-size: 14px;"> <?= (!empty($ofertaActual[0]['oferta'])) ? $helper->getPrecioCarrito($ofertaActual[0]['oferta']) : $helper->getPrecioCarrito($item['oferta_minima']); ?> </span> </p>
                                        </div>
                                        <div class="ratings">

                                        </div>
                                        <div class="desc std">
                                            <?= utf8_encode($item['descripcion_corta']); ?>
                                        </div>
                                        <div class="actions">
                                            <a role="button" href="<?= URL; ?>subasta/item/<?= $item['id']; ?>" class="btn-subasta" title="Ofertar" type="button"><span>Ofertar</span></a>
                                        </div>
                                    </div>
                                </li>
                            <?php endforeach; ?>
                        </ol>
                    <?php else: ?>
                        <?php echo $helper->messageAlert('info', 'Actualmente no disponemos de ninguna subasta activa.'); ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
