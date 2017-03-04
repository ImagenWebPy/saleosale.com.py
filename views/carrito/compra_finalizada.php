<section class="main-container col1-layout">
    <div class="main container">
        <div class="col-main">
            <div class="cart wow bounceInUp animated">
                <div class="page-title">
                    <h2><?php echo $this->titleh2; ?></h2>
                </div>
                <div class="table-responsive">
                    <form method="post" action="#updatePost/">
                        <input type="hidden" value="Vwww7itR3zQFe86m" name="form_key">
                        <fieldset>
                            <table class="data-table cart-table" id="shopping-cart-table">
                                <thead>
                                    <tr class="first last">
                                        <th colspan="4">&nbsp;</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr class="first last">
                                        <td colspan="4">&nbsp;</td>
                                    </tr>
                                </tfoot>
                                <tbody>
                                    <tr class="first odd">
                                        <td colspan="4">
                                            <?php echo $this->message; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>