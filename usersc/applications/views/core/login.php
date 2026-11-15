<?php
    ini_set("allow_url_fopen", 1);
    require_once '../../../../users/init.php';
    // require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/' . $settings->template . '/header.php';
    $hooks =  getMyHooks();
    includeHook($hooks,'pre');
    
    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }
	$qs_ggsxxsh 		= $db->query("SELECT files.web_path as url_logo, posisi_logo_login FROM ggsxxsh LEFT JOIN files ON files.id = ggsxxsh.id_files_company_logo");
	$rs_ggsxxsh	= $qs_ggsxxsh->first();
  $_SESSION['company_logo'] = $rs_ggsxxsh->url_logo;
?>	
<?php
    $errors = $successes = [];
    if (Input::get('err') != '') {
        $errors[] = Input::get('err');
    }

    if ($user->isLoggedIn()) {
        Redirect::to($us_url_root.$settings->redirect_uri_after_login);
    }

    if (!empty($_POST['login_hook'])) {
        $token = Input::get('csrf');
        if(!Token::check($token)){
            include($abs_us_root.$us_url_root.'usersc/scripts/token_error.php');
        }

        $validate = new Validate();
        $validation = $validate->check($_POST, array(
            'username' => array('display' => lang('GEN_UNAME'),'required' => true),
            'password' => array('display' => lang('GEN_PASS'), 'required' => true))
        );
        $validated = $validation->passed();
        // Set $validated to False to kill validation, or run additional checks, in your post hook
        $username = Input::get('username');
        $password = trim(Input::get('password'));
        $remember = false;
        includeHook($hooks,'post');

        if ($validated) {
            //Log user in
            $user = new User();
            $login = $user->loginEmail($username, $password, $remember);
            if ($login) {
                $errors = [];
                $hooks =  getMyHooks(['page'=>'loginSuccess']);
                includeHook($hooks,'body');
                $dest = sanitizedDest('dest');
                # if user was attempting to get to a page before login, go there
                $_SESSION['last_confirm']=date("Y-m-d H:i:s");

                if (!empty($dest)) {
                    $redirect=Input::get('redirect');
                    if(!empty($redirect) || $redirect!=='') Redirect::to($redirect);
                    else Redirect::to($dest);
                } elseif (file_exists($abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php')) {

                    # if site has custom login script, use it
                    # Note that the custom_login_script.php normally contains a Redirect::to() call
                    require_once $abs_us_root.$us_url_root.'usersc/scripts/custom_login_script.php';
                } else {
                    if (($dest = Config::get('homepage')) ||
                    ($dest = 'account.php')) {
                    Redirect::to($dest);
                    }
                }
            } else {
                $eventhooks =  getMyHooks(['page'=>'loginFail']);
                includeHook($eventhooks,'body');
                logger("0","Login Fail","A failed login on login.php");
                $msg = lang("SIGNIN_FAIL");
                $msg2 = lang("SIGNIN_PLEASE_CHK");
                $errors[] = '<strong>'.$msg.'</strong><br>'.$msg2;
            }
        }else{
          $errors = $validation->errors();
        }
        sessionValMessages($errors, $successes, NULL);
    }
    if (empty($dest = sanitizedDest('dest'))) {
      $dest = '';
    }
    $token = Token::generate();
    ?>

<style>
  body.gray-bg {
    min-height: 100vh;
    background: radial-gradient(ellipse at 14% 12%, rgba(56, 189, 175, .16), transparent 33%), linear-gradient(135deg, #edf4f5 0%, #f5f7fb 52%, #e8eef6 100%);
    color: #243447;
    font-family: Inter, "Segoe UI", Arial, sans-serif;
  }
  .loginscreen {
    width: min(100% - 32px, 440px);
    margin: 5vh auto 32px;
    padding: 34px 38px 28px;
    border: 1px solid rgba(255,255,255,.8);
    border-radius: 22px;
    background: rgba(255,255,255,.94);
    box-shadow: 0 24px 70px rgba(27, 45, 74, .13);
    text-align: left;
  }
  .loginscreen > h3:first-child { margin: 0 0 14px; color: #6b7a90; font-size: 13px; font-weight: 600; letter-spacing: .12em; text-align: center; text-transform: uppercase; }
  .loginscreen > img { display: block; width: auto !important; max-width: 190px; max-height: 76px; object-fit: contain; margin: 0 auto 18px; }
  .loginscreen > h3:nth-of-type(2) { margin: 0 0 28px; color: #172b45; font-size: 25px; font-weight: 700; text-align: center; }
  #login-form .form-signin-heading { margin: 0 0 22px; color: #172b45; font-size: 20px; font-weight: 700; }
  #login-form .form-group { margin-bottom: 16px; }
  #login-form .form-control { height: 50px; padding: 12px 15px; border: 1px solid #dce4ec; border-radius: 11px; background: #fbfcfe; box-shadow: none; font-size: 15px; transition: border-color .2s, box-shadow .2s, background .2s; }
  #login-form .form-control:focus { border-color: #16a995; background: #fff; box-shadow: 0 0 0 4px rgba(22,169,149,.12); }
  #login-form .btn, .loginscreen form[action*="tes_online"] .btn { min-height: 48px; border: 0; border-radius: 11px; font-size: 14px; font-weight: 700; letter-spacing: .01em; transition: transform .18s, box-shadow .18s, background .18s; }
  #login-form .btn-primary { background: linear-gradient(135deg, #159c89, #117b83); box-shadow: 0 9px 20px rgba(17,123,131,.2); }
  #login-form .btn-primary:hover, #login-form .btn-primary:focus { background: linear-gradient(135deg, #128b7a, #0d6d76); box-shadow: 0 12px 24px rgba(17,123,131,.27); transform: translateY(-1px); }
  .loginscreen form[action*="tes_online"] .btn { border: 1px solid #dce6ed; background: #f5f8fb; color: #37516a; }
  .loginscreen form[action*="tes_online"] .btn:hover { background: #eaf2f5; }
  .loginscreen .bg-danger { margin-bottom: 16px; padding: 12px 14px; border-radius: 9px; color: #8a2631; }
  .loginscreen a { color: #128b7a; font-weight: 600; }
  .loginscreen a:hover { color: #0d6d76; }
  .loginscreen .row { margin-left: -8px; margin-right: -8px; }
  .loginscreen .col-sm-12 { padding-left: 8px; padding-right: 8px; }
  @media (max-width: 480px) { .loginscreen { margin-top: 20px; padding: 28px 22px 22px; border-radius: 18px; } }
  @media (prefers-reduced-motion: reduce) { .loginscreen *, .loginscreen *::before, .loginscreen *::after { transition: none !important; animation: none !important; } }
</style>

<body class="gray-bg">
    <div class="middle-box text-center loginscreen animated fadeInDown">
		<h3>Welcome to </h3>
    <?php 
      if($rs_ggsxxsh->posisi_logo_login == 1){
    ?>
        <img class="text-center" style="width:100%" src="<?php echo $rs_ggsxxsh->url_logo;?>"></img>    
    <?php 
     }
    ?>
        <div class="row">
          <div class="col-sm-12">
            <?php
            includeHook($hooks,'body');
            ?>
          </div>
        </div>

		<h3><?=$settings->site_name?></h3>
		
		<div class="row">
          <div class="col-sm-12">
            <form name="login" id="login-form" class="m-t" action="" method="post">
                <h2 class="form-signin-heading"><?=lang("SIGNIN_TITLE","");?></h2>
                
                <?php if(count($errors) > 0 ){ ?>
                  <div class="bg-danger"><?=$errors[0];?></div>
                <?php } ?>
                

                <input type="hidden" name="dest" value="<?= $dest ?>" />
                <div class="form-group">
                    <input  class="form-control" type="text" name="username" id="username" placeholder="<?=lang("SIGNIN_UORE")?>" required autofocus autocomplete="username">
                </div>

                <div class="form-group">
                    <input type="password" class="form-control"  name="password" id="password"  placeholder="<?=lang("SIGNIN_PASS")?>" required autocomplete="current-password">
                </div>
                <?php   includeHook($hooks,'form');?>
                <input type="hidden" name="login_hook" value="1">
                <input type="hidden" name="csrf" value="<?=$token?>">
                <input type="hidden" name="redirect" value="<?=Input::get('redirect')?>" />
                <button class="submit  btn btn-primary block full-width m-b" id="next_button" type="submit"><i class="fa fa-sign-in"></i> <?=lang("SIGNIN_BUTTONTEXT","");?></button>
            </form>
            <form action="../../../../tes_online.php" target="_blank">
                <button type="submit" class="btn btn-info btn btn-primary block full-width m-b"><i class="fa fa-file-text"></i> Form Kandidat & Tes Online</button>
            </form>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6"><br>
              <!-- <a class="pull-left" href='../users/forgot_password.php'><i class="fa fa-wrench"></i> <?=lang("SIGNIN_FORGOTPASS","");?></a> -->
              <br><br>
            </div>
            <?php if($settings->registration==1) {?>
              <div class="col-sm-6"><br>
                <a class="pull-right" href='../../../users/join.php'><i class="fa fa-plus-square"></i> <?=lang("SIGNUP_TEXT","");?></a><br><br>
              </div><?php } ?>
              <?php   includeHook($hooks,'bottom');?>
                <?php languageSwitcher();?>
            </div>
          </div>

        </div>
        
		<br>
		
    <br>
    <br>
    <br>

    <?php 
      if($rs_ggsxxsh->posisi_logo_login == 2){
    ?>
        <img class="text-center" style="width:100%" src="<?php echo $rs_ggsxxsh->url_logo;?>"></img>    
    <?php 
      }
    ?>
    
	</div>

    <?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>
    
</body>