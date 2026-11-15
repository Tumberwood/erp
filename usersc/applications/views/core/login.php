
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

    // Resolve the requested destination before processing a successful POST.
    $dest = sanitizedDest('dest');

    if (!empty($_POST['login_hook'])) {
        $token = Input::get('csrf');

        if (!Token::check($token)) {
            include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
            exit;
        }

        $validate = new Validate();

        $validation = $validate->check($_POST, array(
            'username' => array('display' => lang('GEN_UNAME'), 'required' => true),
            'password' => array('display' => lang('GEN_PASS'), 'required' => true)
        ));

        $validated = $validation->passed();

        $username = Input::get('username');
        // Passwords are opaque strings; trimming changes valid credentials.
        $password = isset($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : '';
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
                    Redirect::to($dest);
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

    if (empty($dest)) {
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
        --login-border: #dbe3ef;
    }

    html {
        min-height: 100%;
        margin: 0;
    }

    body {
        min-height: 100vh;
        margin: 0 !important;
        color: var(--login-text);
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
            "Helvetica Neue", Arial, sans-serif !important;
        background: linear-gradient(
            180deg,
            #EDE9FE 0%,
            #C4B5FD 100%
        ) !important;
    }

    .login-wrapper {
        width: 100%;
        min-height: 100vh;
        min-height: 100svh;
        display: flex;
        align-items: center;
        justify-content: center;
        box-sizing: border-box;
        padding: 28px 20px;
    }

    .login-card {
        width: 100%;
        max-width: 460px;
        box-sizing: border-box;
        padding: 38px 40px 30px;
        background: #fff;
        border: 1px solid rgba(255, 255, 255, .85);
        border-radius: 22px;
        box-shadow: 0 22px 60px rgba(30, 58, 95, .13);
        animation: loginFadeIn .35s ease both;
    }

    @keyframes loginFadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .login-header {
        text-align: center;
        margin-bottom: 28px;
    }

    .login-welcome {
        margin: 0 0 16px;
        color: var(--login-muted);
        font-size: 14px;
        font-weight: 500;
        letter-spacing: .2px;
    }

    .login-logo,
    .login-extra-logo img {
        display: block;
        width: auto;
        max-width: 220px;
        max-height: 95px;
        height: auto;
        object-fit: contain;
        margin: 0 auto 18px;
    }

    .login-title {
        margin: 0 0 7px;
        color: var(--login-text);
        font-size: 25px;
        font-weight: 750;
        line-height: 1.3;
        letter-spacing: -.6px;
        overflow-wrap: anywhere;
    }

    .login-subtitle {
        margin: 0;
        color: var(--login-muted);
        font-size: 13px;
    }

    .login-form-title {
        margin: 0 0 18px;
        color: var(--login-text);
        font-size: 17px;
        font-weight: 700;
        text-align: left;
    }

    .login-card .form-group {
        margin-bottom: 15px;
    }

    .login-card .form-control {
        display: block;
        width: 100%;
        height: 52px;
        box-sizing: border-box;
        padding: 11px 16px;
        color: var(--login-text);
        background: #f8fafc;
        border: 1px solid var(--login-border);
        border-radius: 11px;
        box-shadow: none;
        font-size: 14px;
        transition: background .2s, border-color .2s, box-shadow .2s;
    }

    .login-card .form-control::placeholder {
        color: #94a3b8;
    }

    .login-card .form-control:focus {
        background: #fff;
        border-color: var(--login-primary);
        box-shadow: 0 0 0 4px rgba(37, 99, 235, .10);
        outline: none;
    }

    .login-card .btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        min-height: 51px;
        box-sizing: border-box;
        border-radius: 11px;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .1px;
        transition: background .2s, border-color .2s, box-shadow .2s, transform .2s;
    }

    .login-card .btn-primary {
        color: #fff;
        background: var(--login-primary);
        border: 1px solid var(--login-primary);
        box-shadow: 0 7px 16px rgba(37, 99, 235, .20);
    }

    .login-card .btn-primary:hover,
    .login-card .btn-primary:focus {
        color: #fff;
        background: var(--login-primary-dark);
        border-color: var(--login-primary-dark);
        box-shadow: 0 9px 20px rgba(37, 99, 235, .25);
        transform: translateY(-1px);
    }

    .login-card .btn-info {
        color: #334155;
        background: #eef3fa;
        border: 1px solid #dce5f1;
        box-shadow: none;
    }

    .login-card .btn-info:hover,
    .login-card .btn-info:focus {
        color: #1e293b;
        background: #e2eaf5;
        border-color: #cbd8e8;
    }

    .login-error {
        margin-bottom: 17px;
        padding: 12px 14px;
        color: #b91c1c;
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-radius: 10px;
        font-size: 13px;
        line-height: 1.6;
    }

    .login-divider {
        display: flex;
        align-items: center;
        gap: 12px;
        margin: 22px 0 17px;
        color: #94a3b8;
        font-size: 11px;
        font-weight: 600;
        letter-spacing: .5px;
    }

    .login-divider::before,
    .login-divider::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .login-extra-logo {
        margin-top: 22px;
        text-align: center;
    }

    .login-extra-logo img {
        margin-bottom: 0;
    }

    .login-footer {
        margin-top: 24px;
        padding-top: 18px;
        border-top: 1px solid #edf1f6;
        color: var(--login-muted);
        font-size: 12px;
        text-align: center;
    }

    .login-footer a {
        color: var(--login-primary);
        font-weight: 600;
        text-decoration: none;
    }

    .login-footer a:hover {
        text-decoration: underline;
    }

    @media (max-width: 520px) {
        .login-wrapper {
            align-items: flex-start;
            padding: 18px 13px;
        }

        .login-card {
            max-width: 100%;
            padding: 30px 22px 24px;
            border-radius: 17px;
        }

        .login-title {
            font-size: 22px;
        }
    }

    @media (max-height: 700px) and (min-width: 521px) {
        .login-wrapper {
            align-items: flex-start;
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .login-card {
            animation: none;
        }

        .login-card .btn,
        .login-card .form-control {
            transition: none;
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

                <input type="hidden" name="dest" value="<?= htmlspecialchars($dest, ENT_QUOTES, 'UTF-8') ?>" />

                <div class="form-group">
                    <input
                        class="form-control"
                        type="text"
                        name="username"
                        id="username"
                        placeholder="<?= lang("SIGNIN_UORE") ?>"
                        required
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
