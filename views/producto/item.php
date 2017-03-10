<?php
$helper = new Helper();
$producto = $this->producto;
$imagenes = explode('|', $producto['imagen']);
#quitamos el primer elemento del array
$img_principal = array_shift($imagenes);
#verficamos que exista publicidad para la categoria o para el producto
$publicidad = @$this->publicidadProducto;
$precio = $helper->getProductoPrecio($producto['id']);
?>
<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="row">
                <div class="product-view">
                    <div class="product-essential">
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo $helper->messageAlert($_SESSION['message']['type'], $_SESSION['message']['mensaje']);
                        }
                        ?>
                        <input name="form_key" value="6UbXroakyQlbfQzK" type="hidden">
                        <div class="product-img-box col-lg-5 col-sm-5 col-md-5 col-xs-12">
                            <?php if ($producto['precio_oferta'] > 0): ?>
                                <div class="sale-label new-top-left" id="detail-new"> Oferta </div>
                            <?php elseif ($producto['nuevo'] == 1): ?>
                                <div class="new-label new-top-left" id="detail-new"> Nuevo </div>
                            <?php endif; ?>
                            <div class="product-image">
                                <div class="large-image"> <a href="<?php echo IMAGE_PRODUCT . $img_principal ?>" class="cloud-zoom" id="zoom1" rel="useWrapper: false, adjustY:0, adjustX:20"> <img src="<?php echo IMAGE_PRODUCT . $img_principal ?>" alt="<?php echo $img_principal; ?>"> </a> </div>
                                <div class="flexslider flexslider-thumb">
                                    <ul class="previews-list slides">
                                        <?php foreach ($imagenes as $imagen): ?>
                                            <li><a href='<?php echo IMAGE_PRODUCT . $imagen ?>' class='cloud-zoom-gallery' rel="useZoom: 'zoom1', smallImage: '<?php echo IMAGE_PRODUCT . $imagen ?>' "><img src="<?php echo IMAGE_PRODUCT . $imagen ?>" alt = "<?php echo $imagen ?>"/></a></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            </div>
                            <!-- end: more-images -->
                            <div class="clear"></div>
                        </div>
                        <?php if (!empty($publicidad)): ?>
                            <div class="product-shop col-lg-4 col-sm-4 col-xs-12">
                            <?php else : ?>
                                <div class="product-shop col-lg-7 col-sm-7 col-xs-12">
                                <?php endif; ?>
                                <div class="product-name">
                                    <h1><?php echo $helper->getProductoNombre($producto['id']); ?></h1>
                                </div>

<!--<p class="availability in-stock"><span>In Stock</span></p>-->

                                <div class="short-description">
                                    <h2>Breve Reseña</h2>
                                    <?php echo utf8_encode($producto['descripcion']); ?>
                                </div>
                                <div class="price-block">
                                    <div class="price-box">
                                        <?php if ($producto['precio_oferta'] == 0): ?>
                                            <p class="regular-price"> <span class="price-label">Precio Contado:</span> <span class="price"><?php echo $precio['precio']; ?> </span> </p>
                                        <?php else: ?>
                                            <p class="old-price"> <span class="price-label">Precio Contado:</span> <span class="price"> <?php echo $precio['precio']; ?> </span> </p>
                                            <p class="special-price"> <span class="price-label">Precio de Oferta</span> <span class="price"> <?php echo $precio['precio_oferta']; ?> </span> </p>
                                        <?php endif; ?>
                                    </div>
                                    <!--                                    <div class="row">
                                                                            <form>
                                                                                <div class="col-md-10">
                                                                                    <div class="col-xs-3">
                                                                                        <input type="hidden" value="" name="pre_cu">
                                                                                        <input type="hidden" value="12" name="cu_num">
                                                                                        <input type="hidden" value="<?= TASA_INTERES; ?>" name="gasto_interes">
                                                                                        <input type="hidden" onkeyup="computeForm(this.form)" value="<?php echo $producto['precio']; ?>" class="formulario" size="20" name="principal">
                                                                                        <label>Cuotas</label>
                                                                                        <select name="cuotas" onchange="computeForm(this.form)" class="form-control" id="cantCuotas">
                                                                                            <option value="2">02</option>
                                                                                            <option value="3">03</option>
                                                                                            <option value="4">04</option>
                                                                                            <option value="5">05</option>
                                                                                            <option value="6">06</option>
                                                                                            <option value="7">07</option>
                                                                                            <option value="8">08</option>
                                                                                            <option value="9">09</option>
                                                                                            <option value="10">10</option>
                                                                                            <option value="11">11</option>
                                                                                            <option selected="selected" value="12">12</option>
                                                                                        </select>
                                                                                    </div>	
                                                                                    <div class="col-xs-3">
                                                                                        <label>Cantidad </label>
                                                                                        <select name="cantidad" onchange="computeForm(this.form)" class="form-control" id="cantItems">
                                                                                            <option selected="selected" value="1">01</option>
                                                                                            <option value="2">02</option>
                                                                                            <option value="3">03</option>
                                                                                            <option value="4">04</option>
                                                                                            <option value="5">05</option>
                                                                                            <option value="6">06</option>
                                                                                            <option value="7">07</option>
                                                                                            <option value="8">08</option>
                                                                                            <option value="9">09</option>
                                                                                            <option value="10">10</option>
                                                                                            <option value="11">11</option>
                                                                                            <option value="12">12</option>
                                                                                            <option value="13">13</option>
                                                                                            <option value="14">14</option>
                                                                                            <option value="15">15</option>
                                                                                        </select>
                                                                                    </div>
                                                                                    <div class="col-xs-6">
                                                                                        <label>Cuotas de:</label>
                                                                                        <input type="text" class="form-control" onchange="computeForm(this.form)" readonly="readonly" size="10" name="payment" id="payment" value="<?= $helper->calcularCuotaProducto($producto['precio'], TASA_INTERES); ?>" style=" height: 40px;">
                                                                                    </div>
                                                                                </div>
                                                                            </form>
                                                                            <div class="">
                                                                                <button class="btn btn-success btn-outline" id="solicitarFinanciacion" title="Financiar" type="submit" style="margin-top: 15px; margin-left: 30px;"><span><i class="icon-basket"></i> Solicitar Financiación</span></button>
                                                                            </div>
                                                                            <div id="div-financiar" class="col-md-5" style="margin-top: 20px; display: none;">
                                                                                <form method="POST" action="<?= URL; ?>producto/financiar">
                                                                                    <div class="form-group">
                                                                                        <label for="financiacion[nombre]">Nombre</label>
                                                                                        <input type="text" class="form-control" name="financiacion[nombre]" placeholder="Nombre" required>
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="financiacion[email]">Email</label>
                                                                                        <input type="email" class="form-control" name="financiacion[email]" placeholder="Email">
                                                                                    </div>
                                                                                    <div class="form-group">
                                                                                        <label for="financiacion[telefono]">Teléfono</label>
                                                                                        <input type="text" class="form-control" name="financiacion[telefono]" placeholder="Teléfono" required>
                                                                                    </div>
                                                                                    <input type="hidden" id="cuotas" name="financiacion[cuotas]" value="">
                                                                                    <input type="hidden" id="cantidad" name="financiacion[cantidad]" value="">
                                                                                    <input type="hidden" id="monto_cuota" name="financiacion[monto_cuota]" value="">
                                                                                    <input type="hidden" name="financiacion[id_producto]" value="<?= $producto['id']; ?>">
                                                                                    <button type="submit" class="btn btn-block btn-primary" style="">Solicitar</button>
                                                                                </form>
                                                                            </div>
                                                                            <script type="text/javascript">
                                                                                $('#solicitarFinanciacion').click(function () {
                                                                                    $("#div-financiar").fadeIn("slow");
                                                                                });
                                                                                var canCuotas = $('#cantCuotas');
                                                                                $('#cuotas').val(canCuotas.val());
                                                                                canCuotas.change(function () {
                                                                                    $('#cuotas').val(canCuotas.val());
                                                                                });
                                                                                var canItems = $('#cantItems');
                                                                                $('#cantidad').val(canItems.val());
                                                                                canItems.change(function () {
                                                                                    $('#cantidad').val(canItems.val());
                                                                                });
                                                                                var payment = $('#payment');
                                                                                $('#monto_cuota').val(payment.val());
                                                                                payment.change(function () {
                                                                                    $('#monto_cuota').val(payment.val());
                                                                                });
                                                                            </script>
                                                                        </div>-->
                                    <div class="home-welcome">
                                        <?php if ($producto['fecha_fin'] >= date('Y-m-d H:i:s')): ?>
                                            <h4 class="ofertaTitle">Esta oferta finaliza en</h4>
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
                                                    var contador = 1;
                                                    var labels = ['weeks', 'days', 'hours', 'minutes', 'seconds'],
                                                            //nextYear = (new Date().getFullYear() + 1) + '/01/01',
                                                            nextYear = '<?= $producto['fecha_fin']; ?>',
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
                                        <?php else: ?>
                                            <h4 class="ofertaTitle">Esta oferta ha finalizado</h4>
                                        <?php endif; ?>
                                    </div>
                                    <div id="liveVideo" style="display: none;">
                                        <?= $liveVideo; ?>
                                    </div>
                                    <!--<script type="text/javascript" src="<?= URL; ?>public/pluggins/jquery.countdown/js/jquery.countdown.min.js"></script>-->
                                    <script type="text/javascript">
                                        var contador = 1;
                                        $('#clock').countdown('<?= $producto['fecha_fin']; ?>')
                                                .on('update.countdown', function (event) {
                                                    var format = '%H:%M:%S';
                                                    if (event.offset.totalDays > 0) {
                                                        format = '%-d day%!d ' + format;
                                                    }
                                                    if (event.offset.weeks > 0) {
                                                        format = '%-w week%!w ' + format;
                                                    }
                                                    $(this).html(event.strftime(format));
                                                })
                                                .on('finish.countdown', function (event) {
                                                    $(this).html('Esta oferta ha finalizado')
                                                            .parent().addClass('disabled');
                                                    var ajax_call = function () {
                                                        $.ajax({
                                                            type: 'POST',
                                                            url: '<?= URL; ?>producto/liveVideo',
                                                            dataType: 'json',
//                                                            beforeSend: function () {
//                                                                if (contador == 1) {
//                                                                    $('#liveVideo').css('display', 'block');
//                                                                    $('#liveVideo').html('');
//                                                                    $('#liveVideo').html('<div class="loading"><img src="<?= IMAGES; ?>loader.gif" alt="Loading..." /></div>');
//                                                                }
//                                                            },
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
                                                    var interval = 10000; // 1000 = 1s
                                                    setInterval(ajax_call, interval); //ejecutamos
                                                });
                                    </script>
                                </div>
                                <div class="ratings">
                                    <div class="rating-box">
                                        <div class="rating"></div>
                                    </div>
                                    <?php echo $helper->calcularValoracion($producto['id'], 2); ?>
                                </div>
                                <div class="add-to-box">
                                    <form method="POST" action="<?php echo URL . 'cart/agregar/' . $producto['id']; ?>">
                                        <div class="add-to-cart">
                                            <label for="qty">Cantidad:</label>
                                            <div class="pull-left">
                                                <div class="custom pull-left">
                                                    <input type="number" class="input-text qty" title="Qty" value="1" maxlength="12" id="qty" name="qty">
                                                </div>
                                            </div>
                                            <div class="">
                                                <button class="button btn-cart" title="Add to Cart" type="submit"><span><i class="icon-basket"></i> Agregar al Carrito</span></button>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="email-addto-box">
                                        <?php if (!empty($_SESSION['cliente']['id'])): ?>
                                            <ul class="add-to-links">
                                                <li> <a class="link-wishlist" href="<?php echo URL; ?>/cliente/agregar_lista_deseo/<?php echo $_SESSION['cliente']['id'] . '/' . $producto['id']; ?>"><span>Agregar a mi Lista de Deseos</span></a></li>
                                            </ul>
                                        <?php endif; ?>

                                    </div>
                                    <div class="row">
                                        <?php ?>
                                    </div>
                                </div>
                            </div>
                            <?php if (!empty($publicidad)): ?>
                                <aside class="col-lg-3 col-sm-3 col-xs-12">
                                    <div class="product-sibebar-banner">
                                        <?php echo $publicidad; ?>
                                    </div>		
                                </aside>
                            <?php endif; ?>
                        </div>
                        <div class="product-collateral">
                            <div class="col-sm-12 wow bounceInUp">
                                <ul id="product-detail-tab" class="nav nav-tabs product-tabs">
                                    <li class="active"> <a href="#product_tabs_description" data-toggle="tab">Descripción</a></li>
                                    <li><a href="#product_tabs_tags" data-toggle="tab">Tags</a></li>
                                    <li> <a href="#reviews_tabs" data-toggle="tab">Reseñas</a></li>
                                </ul>
                                <div id="productTabContent" class="tab-content">
                                    <div class="tab-pane fade in active" id="product_tabs_description">
                                        <div class="std">
                                            <?php echo utf8_encode($producto['contenido']); ?>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="product_tabs_tags">
                                        <div class="box-collateral box-tags">
                                            <!--tags-->
                                            <?php
                                            $tags = explode(',', utf8_encode($producto['tags']));
                                            ?>
                                            <p class="note">
                                                <?php foreach ($tags as $tag): ?>
                                                    <a href="#"><?php echo $tag; ?></a>
                                                <?php endforeach; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="reviews_tabs">
                                        <div class="box-collateral box-reviews" id="customer-reviews">
                                            <?php if (!empty($_SESSION['cliente'])): ?>
                                                <?php if ((!empty($this->verificaComentario[0]['id'])) && (empty($this->verificaComentario[0]['opinion']))): ?>
                                                    <div class="box-reviews1">
                                                        <div class="form-add">
                                                            <form method="post" action="<?php echo URL; ?>producto/agregar_resena">
                                                                <h3>Escribe una reseña acerca de este producto</h3>
                                                                <fieldset>
                                                                    <h4>¿Cómo califica a este producto? <em class="required">*</em></h4>
                                                                    <span id="input-message-box"></span>
                                                                    <table id="product-review-table" class="data-table">

                                                                        <thead>
                                                                            <tr class="first last">
                                                                                <th>&nbsp;</th>
                                                                                <th><span class="nobr">1 *</span></th>
                                                                                <th><span class="nobr">2 *</span></th>
                                                                                <th><span class="nobr">3 *</span></th>
                                                                                <th><span class="nobr">4 *</span></th>
                                                                                <th><span class="nobr">5 *</span></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr class="first odd">
                                                                                <th>Valora este Producto</th>
                                                                                <td class="value"><input type="radio" class="radio" value="1" id="Price_1" name="resena[rating]"></td>
                                                                                <td class="value"><input type="radio" class="radio" value="2" id="Price_2" name="resena[rating]"></td>
                                                                                <td class="value"><input type="radio" class="radio" value="3" id="Price_3" name="resena[rating]"></td>
                                                                                <td class="value"><input type="radio" class="radio" value="4" id="Price_4" name="resena[rating]"></td>
                                                                                <td class="value last"><input type="radio" class="radio" value="5" id="Price_5" name="resena[rating]"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <input type="hidden" value="" class="validate-rating" name="validate_rating">
                                                                    <div class="review1">
                                                                        <ul class="form-list">
                                                                            <li>
                                                                                <label class="required" for="summary_field">Titulo<em>*</em></label>
                                                                                <div class="input-box">
                                                                                    <input type="text" class="input-text required-entry" id="summary_field" name="resena[titulo]" required>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="review2">
                                                                        <ul>
                                                                            <li>
                                                                                <label class="required label-wide" for="review_field">Reseña<em>*</em></label>
                                                                                <div class="input-box">
                                                                                    <textarea class="required-entry" rows="3" cols="5" id="review_field" name="resena[resena]" required></textarea>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                        <input type="hidden" value="<?php echo $producto['id']; ?>" name="resena[id_producto]" />
                                                                        <div class="buttons-set">
                                                                            <button class="button submit" title="Enviar Resena" type="submit"><span>Enviar Resena</span></button>
                                                                        </div>
                                                                    </div>
                                                                </fieldset>
                                                            </form>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                            <div class="box-reviews2">
                                                <h3>Reseñas de los usuarios</h3>
                                                <div class="box visible">
                                                    <ul>
                                                        <?php
                                                        if (!empty($this->getResenas)) {
                                                            foreach ($this->getResenas as $item) {
                                                                echo $item;
                                                            }
                                                        } else {
                                                            echo $helper->messageAlert('info', 'Este producto aún no tiene ninguna reseña.');
                                                        }
                                                        ?>
                                                    </ul>
                                                </div>
                                                <?php if (!empty($this->getResenas)): ?>
                                                    <div class="actions"> <a class="button view-all" href="<?php echo URL; ?>producto/resenas/<?= $producto['id']; ?>"><span><span>Ver todas</span></span></a> </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="clear"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="box-additional">
                                    <?php if (!empty($this->relacionados[0])): ?>
                                        <div class="related-pro wow bounceInUp">
                                            <div class="slider-items-products">
                                                <div class="new_title center">
                                                    <h2>Productos Relacionados</h2>
                                                </div>
                                                <div id="related-products-slider" class="product-flexslider hidden-buttons">
                                                    <div class="slider-items slider-width-col4"> 
                                                        <?php
                                                        foreach ($this->relacionados as $relacionado) {
                                                            echo $relacionado;
                                                        }
                                                        ?>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?> 
                                    <div class="upsell-pro wow bounceInUp">
                                        <div class="slider-items-products">
                                            <div class="new_title center">
                                                <h2>Más Vendidos</h2>
                                            </div>
                                            <div id="upsell-products-slider" class="product-flexslider hidden-buttons">
                                                <div class="slider-items slider-width-col4"> 
                                                    <?php
                                                    $masVendidos = $helper->productoDestacado(7, 'DESC');
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
</section>
