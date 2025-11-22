        <!-- Body -->
        </div>
        <footer class="pt-7 bg-dark text-inverse">
            <div class="container py-5 py-md-5">
                <div class="row gy-2 gy-lg-0">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                        <div class="widget copyright">
                            <img src="<?=THEME_IMG?>/logo/logo-light.png"/>
                            <div class="footer-info">
                                <?=APP_COPYRIGHT?>. 
                                <br class="d-none d-lg-block"> All rights reserved.
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-8 col-sm-8 col-md-8 col-lg-6">
                        <div class="widget">
                            <div class="widget-title text-white mb-0"><?=((App::lang()=='en')?APP_FACT_EN:APP_FACT_TH)?></div>
                            <div class="footer-info">
                                <i class="uil uil-map-marker-alt"></i> <?=((App::lang()=='en')?APP_ADDR_EN:APP_ADDR_TH)?>
                                <br><i class="uil uil-phone-volume"></i> <?=APP_PHONE?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-3">
                        <div class="widget">
                            <div class="widget-title text-white mb-0"><?=Lang::get('ContactUs')?></div>
                            <div class="footer-info">
                                <i class="uil uil-envelopes"></i> <?=APP_EMAIL?>
                                <br><i class="uil uil-phone-volume"></i> <?=APP_PHONE?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <div class="progress-wrap"><svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102"><path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" /></svg></div>
        <script type="text/javascript" src="<?=THEME_JS?>/plugins.js"></script>
        <script type="text/javascript" src="<?=THEME_JS?>/theme.js"></script>
    </body>
</html>