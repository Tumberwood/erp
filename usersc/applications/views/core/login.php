
<?php
ini_set("allow_url_fopen", 1);

require_once '../../../../users/init.php';
require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/header.php';

$hooks = getMyHooks();
includeHook($hooks, 'pre');

if (!securePage($_SERVER['PHP_SELF'])) {
    die();
}

$qs_ggsxxsh = $db->query("
    SELECT
        files.web_path AS url_logo,
        posisi_logo_login
    FROM ggsxxsh
    LEFT JOIN files ON files.id = ggsxxsh.id_files_company_logo
");

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

$dest = sanitizedDest('dest');

if (!empty($_POST['login_hook'])) {

    $token = Input::get('csrf');

    if (!Token::check($token)) {
        include($abs_us_root . $us_url_root . 'usersc/scripts/token_error.php');
        exit;
    }

    $validate = new Validate();

    $validation = $validate->check($_POST, array(
        'username' => array(
            'display' => lang('GEN_UNAME'),
            'required' => true
        ),
        'password' => array(
            'display' => lang('GEN_PASS'),
            'required' => true
        )
    ));

    $validated = $validation->passed();

    $username = Input::get('username');

    $password = isset($_POST['password']) && is_string($_POST['password'])
        ? $_POST['password']
        : '';

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

            } elseif (
                file_exists(
                    $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php'
                )
            ) {

                require_once $abs_us_root . $us_url_root . 'usersc/scripts/custom_login_script.php';

            } else {

                if (
                    ($dest = Config::get('homepage')) ||
                    ($dest = 'account.php')
                ) {
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

/* =====================================================
   LOGIN - SOFT PURPLE GRADIENT
===================================================== */

:root {
    --login-button: #7654CF;
    --login-button-hover: #6242B5;

    --login-bg: #F7F5FC;
    --login-surface: #FFFFFF;

    --login-text: #34313A;
    --login-muted: #77717F;

    --login-border: #E8E4EC;

    --login-shadow:
        0 15px 45px rgba(73, 48, 120, .10),
        0 3px 12px rgba(73, 48, 120, .04);
}

/* =====================================================
   GLOBAL BACKGROUND
===================================================== */

html {
    min-height: 100%;
    margin: 0;
    background: #F7F5FC !important;
}

body,
body.gray-bg {
    position: relative;

    min-height: 100vh;
    min-height: 100svh;

    margin: 0 !important;

    color: var(--login-text) !important;

    font-family:
        -apple-system,
        BlinkMacSystemFont,
        "Segoe UI",
        Roboto,
        "Helvetica Neue",
        Arial,
        sans-serif !important;

    background: transparent !important;
    background-color: transparent !important;
}

/* Gradient memenuhi seluruh viewport */
body::before {
    content: "";

    position: fixed;
    inset: 0;

    width: 100%;
    height: 100%;

    z-index: 0;
    pointer-events: none;

    background:
        linear-gradient(
            125deg,
            #FFFFFF 0%,
            #F8F6FC 28%,
            #EDE7FA 58%,
            #D8C9F4 82%,
            #BBA5E9 100%
        );
}

/* =====================================================
   LOGIN WRAPPER
===================================================== */

.login-wrapper {
    position: relative;
    z-index: 1;

    width: 100%;

    min-height: 100vh;
    min-height: 100svh;

    display: flex;
    align-items: center;
    justify-content: center;

    box-sizing: border-box;
    padding: 28px 20px;

    background: transparent !important;
}

/* =====================================================
   LOGIN CARD
===================================================== */

.login-card {
    position: relative;
    z-index: 2;

    width: 100%;
    max-width: 460px;

    box-sizing: border-box;
    padding: 38px 40px 30px;

    background: #FFFFFF !important;

    border: 1px solid rgba(255,255,255,.9);
    border-radius: 13px;

    box-shadow: var(--login-shadow);

    animation: loginFadeIn .35s ease both;
}

@keyframes loginFadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* =====================================================
   HEADER
===================================================== */

.login-header {
    text-align: center;
    margin-bottom: 28px;
}

.login-welcome {
    margin: 0 0 16px;

    color: var(--login-muted) !important;

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

    color: var(--login-text) !important;

    font-size: 25px;
    font-weight: 700;
    line-height: 1.3;

    letter-spacing: -.5px;
    overflow-wrap: anywhere;
}

.login-subtitle {
    margin: 0;

    color: var(--login-muted) !important;
    font-size: 13px;
}

/* =====================================================
   FORM TITLE
===================================================== */

.login-form-title {
    margin: 0 0 18px;

    color: var(--login-text) !important;

    font-size: 17px;
    font-weight: 600;
    text-align: left;
}

.login-card .form-group {
    margin-bottom: 15px;
}

/* =====================================================
   INPUT
===================================================== */

.login-card .form-control {
    display: block;

    width: 100%;
    height: 50px;

    box-sizing: border-box;
    padding: 11px 15px;

    color: var(--login-text) !important;

    background: #FFFFFF !important;

    border: 1px solid #DED9E5 !important;
    border-radius: 6px;

    box-shadow: none !important;

    font-size: 14px;

    transition:
        border-color .2s,
        box-shadow .2s;
}

.login-card .form-control::placeholder {
    color: #A19BA8 !important;
    opacity: 1;
}

.login-card .form-control:focus {
    color: var(--login-text) !important;
    background: #FFFFFF !important;

    border-color: #BDB6C9 !important;

    box-shadow:
        0 0 0 3px rgba(80, 70, 95, .07) !important;

    outline: none;
}

/* Browser autofill */

.login-card .form-control:-webkit-autofill,
.login-card .form-control:-webkit-autofill:hover,
.login-card .form-control:-webkit-autofill:focus {
    -webkit-text-fill-color: var(--login-text) !important;

    -webkit-box-shadow:
        0 0 0 1000px #FFFFFF inset !important;

    transition: background-color 5000s ease-in-out 0s;
}

/* =====================================================
   BUTTON BASE
===================================================== */

.login-card .btn {
    display: flex;

    align-items: center;
    justify-content: center;

    gap: 9px;

    width: 100%;
    min-height: 48px;

    box-sizing: border-box;
    padding: 10px 15px;

    border-radius: 6px;

    font-size: 13px;
    font-weight: 600;
    letter-spacing: 0;

    box-shadow: none !important;

    transition:
        background-color .2s,
        border-color .2s,
        color .2s;
}

/* =====================================================
   PRIMARY BUTTON - #7654CF
===================================================== */

.login-card .btn-primary {
    color: #FFFFFF !important;

    background: var(--login-button) !important;

    border: 1px solid var(--login-button) !important;
}

.login-card .btn-primary:hover,
.login-card .btn-primary:focus {
    color: #FFFFFF !important;

    background: var(--login-button-hover) !important;

    border-color: var(--login-button-hover) !important;
}

.login-card .btn-primary:active {
    color: #FFFFFF !important;

    background: var(--login-button-hover) !important;

    border-color: var(--login-button-hover) !important;
}

/* =====================================================
   SECONDARY BUTTON
===================================================== */

.login-card .btn-info {
    color: #514B59 !important;

    background: #F5F4F7 !important;

    border: 1px solid var(--login-border) !important;
}

.login-card .btn-info:hover,
.login-card .btn-info:focus {
    color: var(--login-text) !important;

    background: #ECEAF0 !important;

    border-color: #D8D3DF !important;
}

/* =====================================================
   LOGIN ERROR
===================================================== */

.login-error {
    margin-bottom: 17px;
    padding: 12px 14px;

    color: #9B454D !important;

    background: #FAF0F1 !important;

    border: 1px solid #EEDBDD;
    border-radius: 6px;

    font-size: 13px;
    line-height: 1.6;
}

/* =====================================================
   DIVIDER
===================================================== */

.login-divider {
    display: flex;
    align-items: center;

    gap: 12px;
    margin: 22px 0 17px;

    color: var(--login-muted) !important;

    font-size: 11px;
    font-weight: 600;
    letter-spacing: .5px;
}

.login-divider::before,
.login-divider::after {
    content: "";

    flex: 1;
    height: 1px;

    background: var(--login-border);
}

/* =====================================================
   EXTRA LOGO
===================================================== */

.login-extra-logo {
    margin-top: 22px;
    text-align: center;
}

.login-extra-logo img {
    margin-bottom: 0;
}

/* =====================================================
   FOOTER
===================================================== */

.login-footer {
    margin-top: 24px;
    padding-top: 18px;

    border-top: 1px solid var(--login-border);

    color: var(--login-muted) !important;

    font-size: 12px;
    text-align: center;
}

.login-footer a {
    color: var(--login-muted) !important;

    font-weight: 600;
    text-decoration: none;
}

.login-footer a:hover {
    color: var(--login-text) !important;
    text-decoration: underline;
}

/* =====================================================
   LANGUAGE SWITCHER
===================================================== */

.login-footer select,
.login-footer .form-control {
    color: var(--login-text) !important;

    background: #FFFFFF !important;

    border: 1px solid var(--login-border) !important;
}

/* =====================================================
   RESPONSIVE
===================================================== */

@media (max-width: 520px) {

    .login-wrapper {
        align-items: flex-start;
        padding: 18px 13px;
    }

    .login-card {
        max-width: 100%;
        padding: 30px 22px 24px;
        border-radius: 10px;
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

/* =====================================================
   REDUCED MOTION
===================================================== */

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

                <p class="login-welcome">
                    Welcome to
                </p>

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

            <form
                name="login"
                id="login-form"
                class="m-t"
                action=""
                method="post">

                <h2 class="login-form-title">
                    <?= lang("SIGNIN_TITLE", ""); ?>
                </h2>

                <?php if (count($errors) > 0) { ?>

                    <div class="login-error">
                        <?= $errors[0]; ?>
                    </div>

                <?php } ?>

                <input
                    type="hidden"
                    name="dest"
                    value="<?= htmlspecialchars($dest, ENT_QUOTES, 'UTF-8') ?>" />

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

                <input
                    type="hidden"
                    name="login_hook"
                    value="1">

                <input
                    type="hidden"
                    name="csrf"
                    value="<?= $token ?>">

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

            <form
                action="../../../../tes_online.php"
                target="_blank">

                <button
                    type="submit"
                    class="btn btn-info block full-width m-b">

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

    <?php
        require_once $abs_us_root . $us_url_root . 'usersc/templates/' . $settings->template . '/template_js_load.php';
    ?>

</body>
