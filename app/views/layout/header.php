<!DOCTYPE html>
<html lang="<?=App::lang()?>">
    <head app-lang="<?=App::lang()?>" app-path="<?=APP_PATH?>">
        <meta charset="utf-8" />
        <meta name="keywords" content="<?=APP_CODE?>">
        <meta name="description" content="<?=APP_CODE?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible" />
        <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
        <title><?=APP_CODE?></title>
        <link rel="icon" type="image/png" href="<?=APP_PATH?>/favicon.png" />
        <link rel="icon" type="image/png" sizes="32x32" href="<?=APP_PATH?>/favicon.png" />
        <link rel="icon" type="image/png" sizes="16x16" href="<?=APP_PATH?>/favicon.png" />
        <link rel="icon shortcut" type="image/ico" href="<?=APP_PATH?>/favicon.ico" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?=APP_PATH?>/favicon.png" />
        <link rel="apple-touch-icon" sizes="180x180" href="<?=APP_PATH?>/favicon.png">
        <link rel="apple-touch-icon" sizes="256x204" href="<?=APP_PATH?>/favicon.png">
        <link rel="apple-touch-icon-precomposed" href="<?=APP_PATH?>/favicon.png" />
        <link rel="stylesheet" href="<?=THEME_JS?>/sweetalert/sweetalert2.min.css" />
        <link rel="stylesheet" href="<?=THEME_CSS?>/plugins.css">
        <link rel="stylesheet" href="<?=THEME_CSS?>/style.css">
        <link rel="stylesheet" href="<?=THEME_CSS?>/table.css">
        <link rel="stylesheet" href="<?=THEME_CSS?>/index.css?<?=time()?>">
        <script type="text/javascript" src="<?=THEME_JS?>/jquery-2.1.1.js"></script>
        <script type="text/javascript" src="<?=THEME_JS?>/jquery.form.min.js"></script>
        <script type="text/javascript" src="<?=THEME_JS?>/sweetalert/sweetalert2.min.js"></script>
        <script type="text/javascript" src="<?=THEME_JS?>/index.js?<?=time()?>"></script>
    </head>
    <body>
        <div class="page-loader"></div>
        <div class="content-wrapper">
            <header class="wrapper">
                <nav class="navbar navbar-expand-lg center-nav transparent position-absolute navbar-dark">
                    <div class="container flex-lg-row flex-nowrap align-items-center">
                        <div class="navbar-brand w-100">
                            <a <?=( (isset($index)&&isset($index['home'])) ? 'href="'.$index['home'].'"' : 'href="javascript:void(0);" style="cursor:default;"')?>>
                                <img class="logo-dark" src="<?=THEME_IMG.'/logo/logo-dark.png'?>"/>
                                <img class="logo-light" src="<?=THEME_IMG.'/logo/logo-light.png'?>" />
                            </a>
                        </div>
                        <div class="navbar-collapse offcanvas offcanvas-nav offcanvas-start">
                            <div class="offcanvas-header d-lg-none">
                                <img src="<?=THEME_IMG?>/logo/logo-light.png" style="height:28px;margin-left:-20px;"/>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                            </div>
                            <div class="offcanvas-body ms-lg-auto d-flex flex-column h-100">
                                <?=( (isset($index)&&isset($index['navbar'])) ? $index['navbar'] : '<ul class="navbar-nav"><li class="nav-item dropdown dropdown-mega"><a class="nav-link" href="javascript:void(0);" style="cursor:default;"><font>&nbsp;</font></a></li></ul>' )?>
                                <div class="offcanvas-footer d-lg-none"><div><?=APP_COPYRIGHT?>,<br/>All rights reserved.</div></div>
                            </div>
                        </div>
                        <div class="navbar-other w-100 d-flex ms-auto">
                            <ul class="navbar-nav flex-row align-items-center ms-auto">
                                <!--
                                <li class="nav-item dropdown language-select text-uppercase">
                                    <a class="nav-link dropdown-item dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">TH</a>
                                    <ul class="dropdown-menu">
                                        <li class="nav-item"><a class="dropdown-item" href="#">TH</a></li>
                                        <li class="nav-item"><a class="dropdown-item" href="#">EN</a></li>
                                    </ul>
                                </li>
                                -->
                                <?php /*if( Auth::user() ){ ?>
                                <li class="nav-item d-lg-none">
                                    <button class="hamburger offcanvas-nav-btn"><span></span></button>
                                </li>
                                <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-profile">
                                    <?php if( Auth::user('picture') ){ ?>
                                    <div class="profile-box"><img src="<?=Auth::user('picture')?>" alt="avatar" onerror="this.onerror=null;this.src='<?=THEME_IMG.'/avatar.png'?>';"/></div>
                                    <?php }else{ ?>
                                    <span class="avatar avatar-box bg-soft-primary text-primary w-9 h-9" style="cursor:pointer;"><span class="fs-24"><?=strtoupper(substr(Auth::user(),0,1))?></span></span>
                                    <?php } ?>
                                </li>
                                <?php }else if( isset($_SERVER['PHP_AUTH_USER'])&&$_SERVER['PHP_AUTH_USER'] ){ ?>
                                <li class="nav-item" data-bs-toggle="offcanvas" data-bs-target="#offcanvas-profile">
                                    <span class="avatar avatar-box bg-soft-primary text-primary w-9 h-9" style="cursor:pointer;"><span class="fs-24"><?=strtoupper(substr($_SERVER['PHP_AUTH_USER'],0,1))?></span></span>
                                </li>
                                <?php }*/ ?>
                            </ul>
                        </div>
                    </div>
                </nav>
                <?=( isset($index) ? Auth::profile($index) : null )?>
            </header>