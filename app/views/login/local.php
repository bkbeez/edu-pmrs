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
    form[name='LoginForm'] input[readonly],
    form[name='LoginForm'] input[readonly]:hover,
    form[name='LoginForm'] input[readonly]:focus {
        background: #eaedf2;
    }
    form[name='LoginForm'] input[name='email'] {
        padding-right: 52px !important;
    }
    form[name='LoginForm'] input[name='pincode'] {
        padding-right: 82px !important;
    }
    form[name='LoginForm'] .email-clear,
    form[name='LoginForm'] .pincode-send {
        top: 50%;
        display: none;
        color: #959ca9;
        right: 0.25rem;
        cursor: pointer;
        font-size: 0.9rem;
        position: absolute;
        transform: translateY(-50%);
    }
    form[name='LoginForm'] .email-clear .btn,
    form[name='LoginForm'] .email-clear .btn:hover {
        margin: 0;
        width: 45px;
        padding-left: 0;
        padding-right: 0;
        transform: translateY(0);
    }
    form[name='LoginForm'] .pincode-send .btn,
    form[name='LoginForm'] .pincode-send .btn:hover {
        margin: 0;
        width: 72px;
        padding-left: 0;
        padding-right: 0;
        transform: translateY(0);
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
                                <h2 class="mb-3 text-start">LOGIN</h2>
                                <p class="lead mb-6 text-start">Fill your email and OTP to sign in.</p>
                                <form name="LoginForm" action="<?=APP_PATH.'/login/checking'?>" method="POST" enctype="multipart/form-data" class="form-manage text-start mb-3">
                                    <input name="refcode" type="hidden" value=""/>
                                    <div class="form-floating mb-4">
                                        <input name="email" type="email" class="form-control" placeholder="..." id="login-email">
                                        <span class="email-clear"><span class="btn btn-sm btn-soft-dark rounded" onclick="login_events('email', {'on':'clear'});">&#10005;</span></span>
                                        <label for="login-email">Email</label>
                                    </div>
                                    <div class="form-floating mb-4">
                                        <input name="pincode" type="text" class="form-control" readonly placeholder="..." id="login-pincode">
                                        <span class="pincode-send"><span class="btn btn-sm btn-soft-yellow rounded" onclick="login_events('resend');">ส่งอีกครั้ง</span></span>
                                        <label for="login-pincode">OTP</label>
                                    </div>
                                    <button type="button" class="btn btn-soft-primary rounded-pill w-100 mb-2">Sign in</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="text/javascript">
    function login_events(action, params){
        if(action=='resend'){
            $("form[name='LoginForm'] .pincode-send").fadeOut();
            $("form[name='LoginForm'] input[name='refcode']").val(null);
            $("form[name='LoginForm'] label[for='login-pincode']>span").remove();
            $("form[name='LoginForm'] input[name='pincode']").attr('readonly',true).removeAttr('required');
            $("form[name='LoginForm'] button").attr('type','submit');
            $("form[name='LoginForm'] button").click();
        }else if(action=='email'){
            if(params.on=='show'){
                $("form[name='LoginForm'] .email-clear").fadeIn();
                $("form[name='LoginForm'] button").attr({'type':'submit', 'class':'btn btn-warning rounded-pill w-100 mb-2'}).html('Send OTP to this Email Address');
            }else{
                $("form[name='LoginForm'] .email-clear").fadeOut();
                $("form[name='LoginForm'] .pincode-send").fadeOut();
                $("form[name='LoginForm'] input[name='email']").val(null);
                $("form[name='LoginForm'] input[name='refcode']").val(null);
                $("form[name='LoginForm'] label[for='login-pincode']>span").remove();
                $("form[name='LoginForm'] input[name='pincode']").attr('readonly',true).removeAttr('required');
                $("form[name='LoginForm'] button").attr({'type':'button', 'class':'btn btn-soft-primary rounded-pill w-100 mb-2'}).html('Sign in');
            }
        }
    }
    $("form[name='LoginForm'] input[name='email']").change(function(){
        if(this.value){
            login_events('email', {'on':'show'});
        }else{
            login_events('email', {'on':'clear'});
        }
    });
    $(document).ready(function() {
        $("form[name='LoginForm']").ajaxForm({
            beforeSubmit: function (formData, jqForm, options) {
                runStart();
            },
            success: function(rs) {
                runStop();
                var data = JSON.parse(rs);
                if(data.status=='success'){
                    if( data.continue!=undefined ){
                        $("form[name='LoginForm'] .pincode-send").fadeIn();
                        $("form[name='LoginForm'] label[for='login-pincode']").append('<span class="badge rounded-pill" style="margin:2px 0 0 2px;position:absolute;background:#fef3e4!important;"><code class="text-ash">REF:</code><code class="text-orange">'+data.refcode+'</code></span>');
                        $("form[name='LoginForm'] input[name='refcode']").val(data.refcode);
                        $("form[name='LoginForm'] input[name='pincode']").attr('required',true).removeAttr('readonly');
                        $("form[name='LoginForm'] button").attr({'type':'submit', 'class':'btn btn-icon btn-icon-start btn-success rounded-pill w-100 mb-2'}).html('<i class="uil uil-check-circle"></i> Sign in with Email Address');
                        if( data.htmls!=undefined ){
                            swal({
                                'title': data.text,
                                'html' : data.htmls,
                                'showCloseButton': false,
                                'showCancelButton': false,
                                'focusConfirm': false,
                                'allowEscapeKey': false,
                                'allowOutsideClick': false,
                                'confirmButtonClass': 'btn btn-warning',
                                'confirmButtonText':'<span>Okay</span>',
                                'buttonsStyling': false
                            }).then(
                                function () {
                                    swal.close();
                                    $("form[name='LoginForm'] input[name='pincode']").focus();
                                },
                                function (dismiss) {
                                    if (dismiss === 'cancel') {
                                        swal.close();
                                        $("form[name='LoginForm'] input[name='pincode']").focus();
                                    }
                                }
                            );
                        }
                    }else{
                        $("body").fadeOut('slow', function(){
                            document.location = data.url;
                        });
                    }
                }else{
                    swal({
                        'type' : data.status,
                        'title': data.title,
                        'html' : data.text,
                        'showCloseButton': false,
                        'showCancelButton': false,
                        'focusConfirm': false,
                        'allowEscapeKey': false,
                        'allowOutsideClick': false,
                        'confirmButtonClass': 'btn btn-outline-danger',
                        'confirmButtonText':'<span>Okay</span>',
                        'buttonsStyling': false
                    }).then(
                        function () {
                            swal.close();
                        },
                        function (dismiss) {
                            if (dismiss === 'cancel') {
                                swal.close();
                            }
                        }
                    );
                }
            }
        });
    });
</script>