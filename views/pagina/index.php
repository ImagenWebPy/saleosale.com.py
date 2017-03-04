<div class="main-container col2-right-layout">
    <div class="main container">
        <div class="row">
            <section class="col-main col-sm-9 wow bounceInUp animated">
                <div class="page-title">
                    <h2><?php echo utf8_encode($_SESSION['pagina']['titulo']); ?></h2>
                </div>
                <div class="static-contain">
                    <?php echo utf8_encode($_SESSION['pagina']['contenido']); ?>
                </div>
            </section>
            <?php echo $this->sidebar; ?>
        </div>
    </div>
</div>