<?php
/**
 * Login
 */
class Login extends Controller {

    public function __construct($view, $parameters=array()) {
        parent::__construct();
        if( $view ){
            if( method_exists($this, $view) ){
                $this->$view($parameters);
            }else{
                $this->render('PageNotFound');
            }
        }else{
            $this->index();
        }
    }

    public function index() {
        $this->render('login/check');
    }

    public function checking() {
        Helper::debug($_POST, 1);
        // Validate
        if( !isset($_POST['email'])||!$_POST['email'] ){
            Status::error( 'ไม่พบ Email !!!' );
        }
        // Begin
        $parameters = array();
        $parameters['email'] = Helper::stringSave($_POST['email']);
        if( isset($_POST['refcode'])&&$_POST['refcode'] ){
            if( !isset($_POST['pincode'])||!$_POST['pincode'] ){
                Status::error( 'ไม่พบ OTP !!!' );
            }
            $parameters['verify_ref'] = Helper::stringSave($_POST['refcode']);
            $check = DB::one("SELECT * FROM tbl_apiapp_login WHERE email=:email AND status='pending' AND verify_ref=:verify_ref ORDER BY send_at DESC LIMIT 1;", array('dbname'=>'edumis_application'), $parameters);
            if( isset($check['verify_code'])&&password_verify(Helper::stringSave($_POST['pincode']), $check['verify_code']) ){
                if( Auth::login($parameters['email']) ){
                    DB::update("UPDATE `tbl_apiapp_login` SET `verify_date`=NOW(), `status`='success' WHERE email=:email AND verify_ref=:verify_ref;", array('dbname'=>'edumis_application'), $parameters);
                    $redirect = APP_PATH.'/app';
                    if( isset($_SESSION['LOGIN_REDIRECT_PAGE']) ){
                        if( $_SESSION['LOGIN_REDIRECT_PAGE'] ){
                            $redirect = $_SESSION['LOGIN_REDIRECT_PAGE'];
                        }
                        unset($_SESSION['LOGIN_REDIRECT_PAGE']);
                    }
                    Status::success( 'ยินดีต้อนรับ '.Auth::user('fullname'), array('title'=>"เข้าสู่ระบบเรียบร้อยแล้ว", 'url'=>$redirect) );
                }
            }
        }else{
            $check = DB::one("SELECT tbl_apiapp.*
                            , TRIM(CONCAT(tbl_apiapp.name,' ',COALESCE(tbl_apiapp.surname,''))) AS fullname
                            FROM tbl_apiapp
                            WHERE tbl_apiapp.email=:email OR tbl_apiapp.email_cmu=:email
                            LIMIT 1;"
                            , array('dbname'=>'edumis_application')
                            , $parameters
            );
            if( isset($check['email'])&&$check['email'] ){
                $today = new datetime();
                $verify_ref = strtoupper(Helper::randomString(5));
                $verify_code = Helper::randomNumber();
                $verify = array();
                $verify['email'] = $parameters['email'];
                $verify['send_at'] = $today->format('Y-m-d H:i:s');
                $verify['verify_ref'] = $verify_ref;
                $verify['verify_code'] = password_hash($verify_code, PASSWORD_BCRYPT);
                $verify['status'] = 'pending';
                if( DB::create("INSERT INTO `tbl_apiapp_login` (`email`,`send_at`,`verify_ref`,`verify_code`,`status`) VALUES (:email, :send_at, :verify_ref, :verify_code,:status);", array('dbname'=>'edumis_application'), $verify) ){
                    DB::delete("DELETE FROM `tbl_apiapp_login` WHERE status='pending' AND send_at<:send_at AND email=:email;", array('dbname'=>'edumis_application'), array('email'=>$verify['email'], 'send_at'=>$verify['send_at']));
                    $returns = array();
                    $returns['refcode'] = $verify_ref;
                    if( Helper::isLocal() ){
                        $htmls = '<div class="code-wrapper bg-dark">';
                            $htmls .= '<button type="button" class="btn btn-sm btn-white rounded-pill btn-clipboard">Copy</button>';
                            $htmls .= '<div class="code-wrapper-inner pt-4 pb-4">';
                                $htmls .= '<pre class="fs-20 text-center text-white language-html p-1" tabindex="0">'.$verify_code.'</pre>';
                            $htmls .= '</div>';
                        $htmls .= '</div>';
                        $returns['htmls'] = $htmls;
                    }else{
                        $email = $verify['email'];
                        $fullname = $check['fullname'];
                        $subject = "OTP ยืนยันเข้าสู่ระบบ คือ ".$verify_code;
                        $message = '<div style="padding:15px 35px;text-align:center;">';
                            $message .= '<div>รหัส OTP ยืนยันเข้าสู่ระบบสำหรับ ';
                                $message .= '<span style="padding:2px 0;border:1px solid #113e82;background:#eaeaea;">';
                                    $message .= '<span style="color:#FFF;padding:2px 12px;background-color:#113e82;">REF</span>';
                                    $message .= '<span style="color:#113e82;padding:2px 6px;">'.$verify_ref.'</span>';
                                $message .= '</span>';
                                $message .= ' ของท่าน';
                                $message .= '<br>&nbsp;';
                            $message .= '</div>';
                            $message .= '<span style="font-size:24px;line-height:32px;padding:6px 12px;border:1px solid #2e4150;">'.$verify_code.'</span>';
                        $message .= '</div>';
                        $message .= 'เว็บไซต์ : <a href="'.APP_HOST.'/profile">'.APP_HOST.'</a>';
                        $content = str_replace(array('_NAME_', '_PARAGRAP_'), array($fullname, $message), Mail::getTemplate());
                        Mail::send($subject, $content, array('name'=>$fullname, 'email'=>$email), $message);
                    }
                    $returns['continue'] = true;
                    Status::success( 'ดำเนินการต่อ...', $returns );
                }
            }else{
                Status::error( 'Email นี้ไม่ได้รับสิทธิ์ให้เข้าสู่ระบบได้', array('title'=>'ขออภัย !!!') );
            }
        }
        Status::error( 'กรุณาตรวจสอบและลองใหม่อีกครั้ง !!!', array('title'=>'ไม่สามารถเข้าสู่ระบบได้') );
        
    }

    public function signincmu() {
        if( defined('IS_LOCAL')&&IS_LOCAL ){
            $this->render('login/local');
        }else{
            echo "signincmu";
        }
    }

    public function signingoogle() {
        if( defined('IS_LOCAL')&&IS_LOCAL ){
            $this->render('login/local');
        }else{
            echo "signingoogle";
            /*include_once(APP_ROOT."/app/classes/google.class.php");
            include_once(APP_ROOT."/app/classes/googleinfo.class.php");
            $signin = new Google();
            $signin->setCallbackUri(APP_HOME.'/login/signingoogle');
            $signin->setScope('https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile');
            if( isset($_GET['code'])&&!empty($_GET['code']) ){
                $code = $_GET['code'];
                $codecheck = $signin->getAccessTokenAuthCode($code);
                if( isset($codecheck->access_token)&&!empty($codecheck->access_token) ){
                    $info = new Googleinfo();
                    $infocheck = $info->getBasicinfo($codecheck->access_token);
                    Helper::debug($infocheck);
                }
            }else{
                $signin->initGoogle();
            }*/
        }
    }

}
?>