<?php
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php'); 
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php');
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php');
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_datatables_load.php');
?>

<?php
    if(file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'.css')){?> <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>.css" rel="stylesheet"> <?php } 
?>
<?php if ($user->isLoggedIn()) {
    $appearance = $user->data();
    $appearanceLight = !isset($appearance->is_light_mode) || (int)$appearance->is_light_mode === 1;
    $sidebarColor1 = isset($appearance->color_1) && preg_match('/^#[0-9A-Fa-f]{6}$/', $appearance->color_1) ? $appearance->color_1 : '#1f2937';
    $sidebarColor2 = isset($appearance->color_2) && preg_match('/^#[0-9A-Fa-f]{6}$/', $appearance->color_2) ? $appearance->color_2 : '#111827';
?>
<style>
    :root { --user-sidebar-color-1: <?=htmlspecialchars($sidebarColor1, ENT_QUOTES, 'UTF-8')?>; --user-sidebar-color-2: <?=htmlspecialchars($sidebarColor2, ENT_QUOTES, 'UTF-8')?>; }
    .navbar-static-side, .navbar-static-side .sidebar-collapse,
    .navbar-static-side .nav-second-level, .navbar-static-side .nav-third-level,
    .navbar-static-side .nav-fourth-level { background: linear-gradient(160deg, var(--user-sidebar-color-1), var(--user-sidebar-color-2)) !important; }
    .navbar-static-side .nav-header { background: transparent !important; }
    .navbar-static-side .nav > li > a, .navbar-static-side .nav-header a, .navbar-static-side .nav-header .text-muted { color: #f8fafc !important; }
    .navbar-static-side .nav > li, .navbar-static-side .nav-second-level > li,
    .navbar-static-side .nav-third-level > li { background: transparent !important; }
    .navbar-static-side .nav > li > a, .navbar-static-side .nav-second-level > li > a,
    .navbar-static-side .nav-third-level > li > a { background: transparent !important; }
    .navbar-static-side .nav > li > a:hover, .navbar-static-side .nav > li.active > a,
    .navbar-static-side .nav-second-level > li > a:hover, .navbar-static-side .nav-second-level > li.active > a,
    .navbar-static-side .nav-third-level > li > a:hover, .navbar-static-side .nav-third-level > li.active > a { background: rgba(255,255,255,.14) !important; color: #fff !important; }
    .navbar-static-side .nav-header .profile-element .dropdown-menu { background: #fff !important; }
    .navbar-static-side .nav-header .profile-element .dropdown-menu > li > a { color: #334155 !important; }
    .navbar-static-side .nav-header .profile-element .dropdown-menu > li > a:hover,
    .navbar-static-side .nav-header .profile-element .dropdown-menu > li > a:focus { color: #0f172a !important; background: #eef2f7 !important; }
    <?php if (!$appearanceLight) { ?>
    body.user-dark-mode, body.user-dark-mode #page-wrapper, body.user-dark-mode .wrapper-content,
    body.user-dark-mode .gray-bg, body.user-dark-mode .white-bg { background-color: #151c28 !important; color: #e5eaf2; }
    body.user-dark-mode .navbar-static-top, body.user-dark-mode .row.border-bottom,
    body.user-dark-mode .page-heading, body.user-dark-mode .ibox, body.user-dark-mode .ibox-title,
    body.user-dark-mode .ibox-content, body.user-dark-mode .panel, body.user-dark-mode .panel-heading,
    body.user-dark-mode .panel-body, body.user-dark-mode .well, body.user-dark-mode .footer {
        background-color: #202a38 !important; color: #e5eaf2 !important; border-color: #354255 !important;
    }
    body.user-dark-mode h1, body.user-dark-mode h2, body.user-dark-mode h3, body.user-dark-mode h4,
    body.user-dark-mode h5, body.user-dark-mode h6, body.user-dark-mode label, body.user-dark-mode .control-label,
    body.user-dark-mode .text-muted, body.user-dark-mode .page-heading small { color: #d5deea; }
    body.user-dark-mode a:not(.btn):not(.dropdown-item) { color: #8fc8ff; }
    body.user-dark-mode .navbar-static-top a, body.user-dark-mode .navbar-static-top .welcome-message { color: #e5eaf2 !important; }
    body.user-dark-mode .form-control, body.user-dark-mode select, body.user-dark-mode textarea,
    body.user-dark-mode .input-group-addon { background-color: #182230 !important; color: #edf2f7 !important; border-color: #45546a !important; }
    body.user-dark-mode .form-control::placeholder { color: #9aa9bc; }
    body.user-dark-mode .table { color: #e5eaf2; background-color: #202a38; }
    body.user-dark-mode .table > thead > tr > th, body.user-dark-mode .table > thead > tr > td,
    body.user-dark-mode .table > tbody > tr > th, body.user-dark-mode .table > tbody > tr > td,
    body.user-dark-mode .table > tfoot > tr > th, body.user-dark-mode .table > tfoot > tr > td { background-color: transparent !important; border-color: #354255 !important; color: inherit; }
    body.user-dark-mode table.dataTable thead, body.user-dark-mode table.dataTable thead th,
    body.user-dark-mode table.dataTable thead td { background: #263345 !important; color: #e5eaf2 !important; }
    body.user-dark-mode .table-striped > tbody > tr:nth-of-type(odd) { background-color: #263345; }
    body.user-dark-mode .table-hover > tbody > tr:hover { background-color: #2c3a4e; }
    body.user-dark-mode .nav-tabs { border-color: #354255; }
    body.user-dark-mode .nav-tabs > li > a, body.user-dark-mode .nav-tabs > li > a:hover,
    body.user-dark-mode .nav-tabs > li > a:focus { color: #aabbd0 !important; background: transparent !important; border-color: transparent; }
    body.user-dark-mode .nav-tabs > li.active > a, body.user-dark-mode .nav-tabs > li.active > a:hover,
    body.user-dark-mode .nav-tabs > li.active > a:focus { color: #f1f5f9 !important; background: #202a38 !important; border-color: #354255 #354255 #202a38 !important; }
    body.user-dark-mode .btn-default, body.user-dark-mode .btn-white,
    body.user-dark-mode .btn-outline, body.user-dark-mode .btn-group .btn-default {
        color: #e5eaf2 !important; background: #2a3749 !important; border-color: #526176 !important; box-shadow: none;
    }
    body.user-dark-mode .btn-default:hover, body.user-dark-mode .btn-white:hover,
    body.user-dark-mode .btn-outline:hover, body.user-dark-mode .btn-default:focus,
    body.user-dark-mode .btn-white:focus { color: #fff !important; background: #384960 !important; border-color: #71839b !important; }
    body.user-dark-mode .btn-primary { color: #fff !important; background: #0f9f82 !important; border-color: #0f9f82 !important; }
    body.user-dark-mode .btn-primary:hover, body.user-dark-mode .btn-primary:focus { background: #0b846d !important; border-color: #0b846d !important; }
    body.user-dark-mode .btn-success { color: #fff !important; background: #16845f !important; border-color: #16845f !important; }
    body.user-dark-mode .btn-info { color: #fff !important; background: #18779a !important; border-color: #18779a !important; }
    body.user-dark-mode .btn-warning { color: #1f2937 !important; background: #e4a73d !important; border-color: #e4a73d !important; }
    body.user-dark-mode .btn-danger { color: #fff !important; background: #c84754 !important; border-color: #c84754 !important; }
    body.user-dark-mode .btn:disabled, body.user-dark-mode .btn.disabled { opacity: .55; }
    body.user-dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button,
    body.user-dark-mode .pagination > li > a, body.user-dark-mode .pagination > li > span { color: #dce5f0 !important; background: #2a3749 !important; border-color: #45546a !important; }
    body.user-dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    body.user-dark-mode .pagination > .active > a, body.user-dark-mode .pagination > .active > span { color: #fff !important; background: #0f9f82 !important; border-color: #0f9f82 !important; }
    body.user-dark-mode .select2-container--bootstrap .select2-selection,
    body.user-dark-mode .select2-container--bootstrap4 .select2-selection,
    body.user-dark-mode .select2-dropdown, body.user-dark-mode .select2-container--default .select2-selection--single,
    body.user-dark-mode .select2-container--default .select2-selection--multiple { color: #e5eaf2 !important; background: #182230 !important; border-color: #45546a !important; }
    body.user-dark-mode .select2-container--bootstrap .select2-selection__rendered,
    body.user-dark-mode .select2-container--bootstrap4 .select2-selection__rendered,
    body.user-dark-mode .select2-results__option { color: #e5eaf2 !important; }
    body.user-dark-mode .select2-results__option[aria-selected="true"],
    body.user-dark-mode .select2-results__option--highlighted { color: #fff !important; background: #304057 !important; }
    body.user-dark-mode .modal-header .close { color: #e5eaf2 !important; background: transparent !important; border: 0; text-shadow: none; opacity: .85; }
    body.user-dark-mode .dropdown-menu { background-color: #202a38; border: 1px solid #354255; }
    body.user-dark-mode .dropdown-menu > li > a { color: #e5eaf2; }
    body.user-dark-mode .dropdown-menu > li > a:hover { color: #fff; background-color: #304057; }
    body.user-dark-mode .modal-content { background-color: #202a38; color: #e5eaf2; border-color: #354255; }
    body.user-dark-mode .modal-header, body.user-dark-mode .modal-footer { border-color: #354255; }
    body.user-dark-mode .hr-line-dashed, body.user-dark-mode hr { border-color: #354255; }
    <?php } ?>
</style>
<?php } ?>

</head>
<!-- <body class="fixed-sidebar no-skin-config "> -->
<body class="canvas-menu<?=isset($appearanceLight) && !$appearanceLight ? ' user-dark-mode' : ''?>">
<?php require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php'); ?>
