
<?php
    ini_set("allow_url_fopen", 1);
    require_once '../../../../users/init.php';
    // require_once $abs_us_root.$us_url_root.'users/includes/template/prep.php';
    require_once $abs_us_root.$us_url_root.'usersc/templates/' . $settings->template . '/header.php';

    $hooks = getMyHooks();
    includeHook($hooks, 'pre');

    if (!securePage($_SERVER['PHP_SELF'])) {
        die();
    }

    $qs_ggsxxsh = $db->query("SELECT files.web_path as url_logo, posisi_logo_login FROM ggsxxsh LEFT JOIN files ON files.id = ggsxxsh.id_files_company_logo");
    $rs_ggsxxsh = $qs_ggsxxsh->first();

    $_SESSION['company_logo'] = $rs_ggsxxsh->url_logo;
?>

<?php
    $errors = $successes = [];

    if (Input::get('err') != '') {
        $errors[] = Input::get('err');
    }

    if ($user->isLoggedIn()) {
        Redirect::to($us_url_root . $settings->redirect_uri_after_login);
    }

    if (!empty($_POST['login_hook'])) {
        $token = Input::get('csrf');

        if (!Token::check($token)) {
            include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
        }

        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'username' => array('display' => lang('GEN_UNAME'), 'required' => true),
            'password' => array('display' => lang('GEN_PASS'), 'required' => true)
        ));

        $validated = $validation->passed();

        $username = Input::get('username');
        $password = trim(Input::get('password'));
        $remember = false;

        includeHook($hooks, 'post');

        if ($validated) {
            $user = new User();
            $login = $user->loginEmail($username, $password, $remember);

            if ($login) {
                $errors = [];

                $hooks = getMyHooks(['page' => 'loginSuccess']);
                includeHook($hooks, 'body');

                $dest = sanitizedDest('dest');

                $_SESSION['last_confirm'] = date("Y-m-d H:i:s");

                if (!empty($dest)) {
                    $redirect = Input::get('redirect');

                    if (!empty($redirect) || $redirect !== '') {
                        Redirect::to($redirect);
                    } else {
                        Redirect::to($dest);
                    }
                } elseif (file_exists($abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php')) {
                    require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';
                } else {
                    if (($dest = Config::get('homepage')) ||
                        ($dest = 'account.php')) {
                        Redirect::to($dest);
                    }
                }
            } else {
                $eventhooks = getMyHooks(['page' => 'loginFail']);
                includeHook($eventhooks, 'body');

                logger("0", "Login Fail", "A failed login on login.php");

                $msg = lang("SIGNIN_FAIL");
                $msg2 = lang("SIGNIN_PLEASE_CHK");

                $errors[] = '<strong>' . $msg . '</strong><br>' . $msg2;
            }
        } else {
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
    :root {
        --login-primary: #2563eb;
        --login-primary-dark: #1d4ed8;
        --login-text: #172033;
        --login-muted: #64748b;
        --login-border: #e2e8f0;
        --login-background: #f1f5f9;
    }

    html,
    body {
        min-height: 100%;
        margin: 0;
    }

    body {
        background:
            radial-gradient(circle at 10% 10%, rgba(59, 130, 246, .13), transparent 30%),
            radial-gradient(circle at 90% 90%, rgba(99, 102, 241, .12), transparent 30%),
            var(--login-background) !important;
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            "Helvetica Neue", Arial, sans-serif !important;
        color: var(--login-text);
    }

    .login-wrapper {
        min-height: 100vh;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 35px 20px;
        box-sizing: border-box;
    }

    .login-card {
        width: 100%;
        max-width: 440px;
        background: #ffffff;
        border: 1px solid rgba(226, 232, 240, .9);
        border-radius: 20px;
        padding: 42px 38px;
        box-shadow:
            0 20px 50px rgba(15, 23, 42, .07),
            0 3px 10px rgba(15, 23, 42, .025);
        animation: loginFadeIn .5s ease;
    }

    @keyframes loginFadeIn {
        from {
            opacity: 0;
            transform: translateY(15px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .login-header {
        text-align: center;
        margin-bottom: 30px;
    }

    .login-welcome {
        font-size: 14px;
        color: var(--login-muted);
        font-weight: 500;
        margin: 0 0 16px;
        letter-spacing: .4px;
    }

    .login-logo {
        display: block;
        max-width: 230px;
        max-height: 110px;
        width: auto;
        height: auto;
        object-fit: contain;
        margin: 0 auto 20px;
    }

    .login-title {
        font-size: 25px;
        font-weight: 750;
        letter-spacing: -.7px;
        color: var(--login-text);
        margin: 0 0 8px;
        line-height: 1.3;
    }

    .login-subtitle {
        color: var(--login-muted);
        font-size: 13px;
        margin: 0;
    }

    .login-form-title {
        font-size: 17px;
        font-weight: 700;
        color: var(--login-text);
        margin: 0 0 22px;
        text-align: left;
    }

    .login-card .form-group {
        margin-bottom: 17px;
    }

    .login-card .form-control {
        width: 100%;
        height: 49px;
        border: 1px solid var(--login-border);
        border-radius: 10px;
        padding: 10px 15px;
        font-size: 14px;
        color: var(--login-text);
        background: #ffffff;
        box-shadow: none;
        transition: border-color .2s, box-shadow .2s;
        box-sizing: border-box;
    }

    .login-card .form-control::placeholder {
        color: #94a3b8;
    }

    .login-card .form-control:focus {
        border-color: var(--login-primary);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .11);
        outline: none;
    }

    .login-card .btn {
        height: 49px;
        border-radius: 10px;
        font-size: 14px;
        font-weight: 650;
        letter-spacing: .2px;
        transition: all .2s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
    }

    .login-card .btn-primary {
        background: var(--login-primary);
        border: 1px solid var(--login-primary);
        color: #ffffff;
        box-shadow: 0 5px 12px rgba(37, 99, 235, .18);
    }

    .login-card .btn-primary:hover,
    .login-card .btn-primary:focus {
        background: var(--login-primary-dark);
        border-color: var(--login-primary-dark);
        color: #ffffff;
        transform: translateY(-1px);
        box-shadow: 0 7px 16px rgba(37, 99, 235, .25);
    }

    .login-card .btn-info {
        background: #f1f5f9;
        border: 1px solid #e2e8f0;
        color: #334155;
        box-shadow: none;
    }

    .login-card .btn-info:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .login-error {
        padding: 12px 15px;
        border-radius: 9px;
        background: #fef2f2;
        border: 1px solid #fecaca;
        color: #b91c1c;
        font-size: 13px;
        margin-bottom: 18px;
        line-height: 1.6;
    }

    .login-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 20px 0;
        color: #94a3b8;
        font-size: 11px;
    }

    .login-divider::before,
    .login-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .login-footer {
        text-align: center;
        color: var(--login-muted);
        font-size: 12px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
    }

    .login-footer a {
        color: var(--login-primary);
        font-weight: 600;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    .login-extra-logo {
        margin-top: 25px;
        text-align: center;
    }

    .login-extra-logo img {
        max-width: 230px;
        max-height: 110px;
        width: auto;
        height: auto;
        object-fit: contain;
    }

    @media (max-width: 480px) {
        .login-wrapper {
            padding: 20px 14px;
        }

        .login-card {
            padding: 32px 23px;
            border-radius: 16px;
        }

        .login-title {
            font-size: 22px;
        }
    }
</style>

<body class="gray-bg">

    <div class="login-wrapper">

        <div class="login-card">

            <div class="login-header">

                <p class="login-welcome">Welcome to</p>

                <?php
                if ($rs_ggsxxsh->posisi_logo_login == 1) {
                ?>
                    <img
                        class="login-logo"
                        src="<?php echo $rs_ggsxxsh->url_logo; ?>"
                        alt="Company Logo">
                <?php
                }
                ?>

                <h1 class="login-title">
                    <?= $settings->site_name ?>
                </h1>

                <p class="login-subtitle">
                    Silakan masuk menggunakan akun Anda
                </p>

            </div>

            <div class="row">
                <div class="col-sm-12">
                    <?php
                    includeHook($hooks, 'body');
                    ?>
                </div>
            </div>

            <form name="login" id="login-form" class="m-t" action="" method="post">

                <h2 class="login-form-title">
                    <?= lang("SIGNIN_TITLE", ""); ?>
                </h2>

                <?php if (count($errors) > 0) { ?>
                    <div class="login-error">
                        <?= $errors[0]; ?>
                    </div>
                <?php } ?>

                <input type="hidden" name="dest" value="<?= $dest ?>" />

                <div class="form-group">
                    <input
                        class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        placeholder="<?= lang("SIGNIN_UORE") ?>"
                        required
                        autofocus
                        autocomplete="username">
                </div>

                <div class="form-group">
                    <input
                        type="password"
                        class="form-control"
                        name="password"
                        id="password"
                        placeholder="<?= lang("SIGNIN_PASS") ?>"
                        required
                        autocomplete="current-password">
                </div>

                <?php includeHook($hooks, 'form'); ?>

                <input type="hidden" name="login_hook" value="1">
                <input type="hidden" name="csrf" value="<?= $token ?>">

                <input
                    type="hidden"
                    name="redirect"
                    value="<?= Input::get('redirect') ?>" />

                <button
                    class="submit btn btn-primary block full-width m-b"
                    id="next_button"
                    type="submit">

                    <i class="fa fa-sign-in"></i>
                    <?= lang("SIGNIN_BUTTONTEXT", ""); ?>

                </button>

            </form>

            <div class="login-divider">
                AKSES LAINNYA
            </div>

            <form action="../../../../tes_online.php" target="_blank">

                <button type="submit" class="btn btn-info block full-width m-b">

                    <i class="fa fa-file-text"></i>
                    Form Kandidat & Tes Online

                </button>

            </form>

            <?php
            if ($rs_ggsxxsh->posisi_logo_login == 2) {
            ?>
                <div class="login-extra-logo">
                    <img
                        src="<?php echo $rs_ggsxxsh->url_logo; ?>"
                        alt="Company Logo">
                </div>
            <?php
            }
            ?>

            <div class="login-footer">

                <?php if ($settings->registration == 1) { ?>

                    <a href="../../../users/join.php">
                        <i class="fa fa-plus-circle"></i>
                        <?= lang("SIGNUP_TEXT", ""); ?>
                    </a>

                <?php } ?>

                <?php includeHook($hooks, 'bottom'); ?>

                <div style="margin-top: 15px;">
                    <?php languageSwitcher(); ?>
                </div>

            </div>

        </div>

    </div>

    <?php require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php'; ?>

</body>
