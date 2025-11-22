<style type="text/css">
    html,body {
        background: #21262d;
    }
    header.wrapper,
    nav.navbar-stick {
        display: none;
    }
    .wrapper-apps {
        padding-bottom: 0 !important;
        background: url('<?=THEME_IMG?>/map.png') top center;
    }
    @media only all and (max-width: 414px) {
        .wrapper-apps button {
            padding-left: 12px!important;
            padding-right: 0!important;
            display: block!important;
            overflow:hidden!important;
            white-space:nowrap!important;
            text-overflow:ellipsis!important;
        }
    }
</style>
<section class="wrapper image-wrapper bg-image bg-overlay bg-overlay-400 text-white" data-image-src="<?=THEME_IMG?>/bg/bg-blue.jpg">
    <div class="container pt-15 pb-7 pt-md-15 pb-md-7 text-center">
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <h3 class="display-1 mb-0 text-white font-cmu-b">LOGIN</h3>
                <h4 class="display-4 mb-0 font-cmu"><span class="typer text-white" data-loop="true" data-delay="100" data-words="<?=APP_NAME?>"></span><span class="cursor text-white" data-owner="typer"></span></h1>
            </div>
        </div>
    </div>
</section>
<section class="wrapper wrapper-apps bg-light">
    <div class="container pb-12">
        <div class="row">
            <div class="col mt-n19">
                <div class="card card-login shadow-lg">
                    <div class="row gx-0 text-center">
                        <div class="col-lg-6 image-wrapper bg-image bg-cover rounded-top rounded-lg-start d-none d-md-block" data-image-src="<?=THEME_IMG?>/bg/bg-login.jpg"></div>
                        <div class="col-lg-6">
                            <div class="p-10 p-md-11 p-lg-13">
                                <figure class="text-center mb-5"><img src="/favicon.png" style="width:256px;"/></figure>
                                <button type="button" class="btn btn-icon btn-icon-start rounded-pill btn-purple w-100 mb-2" onclick="document.location='/login/signincmu';"><i class="uil uil-microsoft"></i> Sign in with CMU Account</button>
                                <div class="divider-icon my-4">or</div>
                                <button type="button" class="btn btn-icon btn-icon-start rounded-pill btn-danger w-100 mb-2" onclick="document.location='/login/signingoogle';"><i class="uil uil-google"></i> Sign in with Google Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>