
<?php
    require_once($abs_us_root.$us_url_root.'users/includes/template/header1_must_include.php');
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/assets/fonts/glyphicons.php');
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_load.php');
    require_once($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'/template_css_datatables_load.php');
?>

<?php
    if (file_exists($abs_us_root.$us_url_root.'usersc/templates/'.$settings->template.'.css')) {
?>
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>.css" rel="stylesheet">
<?php
    }
?>

<?php
if ($user->isLoggedIn()) {

    $appearance = $user->data();

    $appearanceLight = !isset($appearance->is_light_mode)
        || (int)$appearance->is_light_mode === 1;

    $sidebarColor1 = isset($appearance->color_1)
        && preg_match('/^#[0-9A-Fa-f]{6}$/', $appearance->color_1)
        ? $appearance->color_1
        : '#1f2937';

    $sidebarColor2 = isset($appearance->color_2)
        && preg_match('/^#[0-9A-Fa-f]{6}$/', $appearance->color_2)
        ? $appearance->color_2
        : '#111827';
?>

<style>

/* =====================================================
   USER SIDEBAR COLOR - CUSTOM GRADIENT
===================================================== */

:root {
    --user-sidebar-color-1: <?=htmlspecialchars($sidebarColor1, ENT_QUOTES, 'UTF-8')?>;
    --user-sidebar-color-2: <?=htmlspecialchars($sidebarColor2, ENT_QUOTES, 'UTF-8')?>;
}

.navbar-static-side,
.navbar-static-side .sidebar-collapse,
.navbar-static-side .nav-second-level,
.navbar-static-side .nav-third-level,
.navbar-static-side .nav-fourth-level {
    background: linear-gradient(
        160deg,
        var(--user-sidebar-color-1),
        var(--user-sidebar-color-2)
    ) !important;
}

.navbar-static-side .nav-header {
    background: transparent !important;
}

.navbar-static-side .nav > li > a,
.navbar-static-side .nav-header a,
.navbar-static-side .nav-header .text-muted {
    color: #f8fafc !important;
}

.navbar-static-side .nav > li,
.navbar-static-side .nav-second-level > li,
.navbar-static-side .nav-third-level > li {
    background: transparent !important;
}

.navbar-static-side .nav > li > a,
.navbar-static-side .nav-second-level > li > a,
.navbar-static-side .nav-third-level > li > a {
    background: transparent !important;
}

.navbar-static-side .nav > li > a:hover,
.navbar-static-side .nav > li.active > a,
.navbar-static-side .nav-second-level > li > a:hover,
.navbar-static-side .nav-second-level > li.active > a,
.navbar-static-side .nav-third-level > li > a:hover,
.navbar-static-side .nav-third-level > li.active > a {
    background: rgba(255,255,255,.14) !important;
    color: #fff !important;
}

.navbar-static-side .nav-header .profile-element .dropdown-menu {
    background: #fff !important;
}

.navbar-static-side .nav-header .profile-element .dropdown-menu > li > a {
    color: #334155 !important;
}

.navbar-static-side .nav-header .profile-element .dropdown-menu > li > a:hover,
.navbar-static-side .nav-header .profile-element .dropdown-menu > li > a:focus {
    color: #0f172a !important;
    background: #eef2f7 !important;
}


/* =====================================================
   LIGHT MODE - CLEAN LAVENDER
===================================================== */

<?php if ($appearanceLight) { ?>

:root {
    --light-bg: #F4F5FA;
    --light-surface: #FFFFFF;
    --light-surface-2: #FAFAFD;
    --light-border: #E5E7EB;

    --light-text: #20212A;
    --light-muted: #73778A;

    --light-primary: #8B5CF6;
    --light-primary-hover: #7C3AED;
    --light-primary-soft: rgba(139,92,246,.09);
}

/* Main background */

body:not(.user-dark-mode),
body:not(.user-dark-mode) #wrapper,
body:not(.user-dark-mode) #page-wrapper,
body:not(.user-dark-mode) .wrapper-content,
body:not(.user-dark-mode) .gray-bg {
    background-color: var(--light-bg) !important;
    color: var(--light-text);
}

/* Navbar and header */

body:not(.user-dark-mode) .navbar-static-top,
body:not(.user-dark-mode) .row.border-bottom,
body:not(.user-dark-mode) .page-heading {
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
    color: var(--light-text) !important;
}

body:not(.user-dark-mode) .navbar-static-top a,
body:not(.user-dark-mode) .navbar-static-top .welcome-message {
    color: #525466 !important;
}

/* Content cards */

body:not(.user-dark-mode) .ibox,
body:not(.user-dark-mode) .ibox-title,
body:not(.user-dark-mode) .ibox-content,
body:not(.user-dark-mode) .panel,
body:not(.user-dark-mode) .panel-heading,
body:not(.user-dark-mode) .panel-body,
body:not(.user-dark-mode) .well {
    background-color: var(--light-surface) !important;
    color: var(--light-text);
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .ibox-title,
body:not(.user-dark-mode) .panel-heading {
    border-bottom: 1px solid var(--light-border) !important;
}

/* Typography */

body:not(.user-dark-mode) h1,
body:not(.user-dark-mode) h2,
body:not(.user-dark-mode) h3,
body:not(.user-dark-mode) h4,
body:not(.user-dark-mode) h5,
body:not(.user-dark-mode) h6,
body:not(.user-dark-mode) label,
body:not(.user-dark-mode) .control-label {
    color: var(--light-text);
}

body:not(.user-dark-mode) .text-muted,
body:not(.user-dark-mode) .page-heading small {
    color: var(--light-muted) !important;
}

body:not(.user-dark-mode) a:not(.btn):not(.dropdown-item) {
    color: var(--light-primary);
}

body:not(.user-dark-mode) a:not(.btn):not(.dropdown-item):hover {
    color: var(--light-primary-hover);
}

/* Form controls */

body:not(.user-dark-mode) .form-control,
body:not(.user-dark-mode) select,
body:not(.user-dark-mode) textarea,
body:not(.user-dark-mode) .input-group-addon {
    background: #FFFFFF !important;
    color: var(--light-text) !important;
    border-color: var(--light-border) !important;
    box-shadow: none !important;
}

body:not(.user-dark-mode) .form-control:focus,
body:not(.user-dark-mode) select:focus,
body:not(.user-dark-mode) textarea:focus {
    border-color: var(--light-primary) !important;
    box-shadow: 0 0 0 2px var(--light-primary-soft) !important;
}

body:not(.user-dark-mode) .form-control::placeholder {
    color: #A1A1AA !important;
}

/* Tables */

body:not(.user-dark-mode) .table {
    background: #FFFFFF !important;
    color: var(--light-text);
}

body:not(.user-dark-mode) .table > thead > tr > th,
body:not(.user-dark-mode) .table > thead > tr > td,
body:not(.user-dark-mode) .table > tbody > tr > th,
body:not(.user-dark-mode) .table > tbody > tr > td,
body:not(.user-dark-mode) .table > tfoot > tr > th,
body:not(.user-dark-mode) .table > tfoot > tr > td {
    border-color: var(--light-border) !important;
    color: inherit;
}

body:not(.user-dark-mode) table.dataTable thead,
body:not(.user-dark-mode) table.dataTable thead th,
body:not(.user-dark-mode) table.dataTable thead td {
    background: #F8F7FC !important;
    color: #383447 !important;
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .table-striped > tbody > tr:nth-of-type(odd) {
    background-color: #FAFAFD !important;
}

body:not(.user-dark-mode) .table-hover > tbody > tr:hover {
    background-color: var(--light-primary-soft) !important;
}

/* Buttons */

body:not(.user-dark-mode) .btn-primary {
    color: #FFFFFF !important;
    background: var(--light-primary) !important;
    border-color: var(--light-primary) !important;
}

body:not(.user-dark-mode) .btn-primary:hover,
body:not(.user-dark-mode) .btn-primary:focus {
    background: var(--light-primary-hover) !important;
    border-color: var(--light-primary-hover) !important;
}

body:not(.user-dark-mode) .btn-default,
body:not(.user-dark-mode) .btn-white,
body:not(.user-dark-mode) .btn-outline,
body:not(.user-dark-mode) .btn-group .btn-default {
    color: #444052 !important;
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
    box-shadow: none !important;
}

body:not(.user-dark-mode) .btn-default:hover,
body:not(.user-dark-mode) .btn-white:hover,
body:not(.user-dark-mode) .btn-outline:hover {
    color: var(--light-primary-hover) !important;
    background: #F5F3FF !important;
    border-color: #C4B5FD !important;
}

/* Pagination */

body:not(.user-dark-mode) .dataTables_wrapper .dataTables_paginate .paginate_button,
body:not(.user-dark-mode) .pagination > li > a,
body:not(.user-dark-mode) .pagination > li > span {
    color: #525466 !important;
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .dataTables_wrapper .dataTables_paginate .paginate_button.current,
body:not(.user-dark-mode) .pagination > .active > a,
body:not(.user-dark-mode) .pagination > .active > span {
    color: #FFFFFF !important;
    background: var(--light-primary) !important;
    border-color: var(--light-primary) !important;
}

/* Select2 */

body:not(.user-dark-mode) .select2-container--bootstrap .select2-selection,
body:not(.user-dark-mode) .select2-container--bootstrap4 .select2-selection,
body:not(.user-dark-mode) .select2-dropdown,
body:not(.user-dark-mode) .select2-container--default .select2-selection--single,
body:not(.user-dark-mode) .select2-container--default .select2-selection--multiple {
    color: var(--light-text) !important;
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .select2-results__option[aria-selected="true"],
body:not(.user-dark-mode) .select2-results__option--highlighted {
    color: #FFFFFF !important;
    background: var(--light-primary) !important;
}

/* Dropdown */

body:not(.user-dark-mode) .dropdown-menu {
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
    box-shadow: 0 8px 24px rgba(30,20,60,.08) !important;
}

body:not(.user-dark-mode) .dropdown-menu > li > a {
    color: #444052 !important;
}

body:not(.user-dark-mode) .dropdown-menu > li > a:hover {
    color: var(--light-primary-hover) !important;
    background: #F5F3FF !important;
}

/* Modal */

body:not(.user-dark-mode) .modal-content {
    background: #FFFFFF !important;
    color: var(--light-text) !important;
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .modal-header,
body:not(.user-dark-mode) .modal-footer {
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .modal-header .close {
    color: var(--light-muted) !important;
}

/* Tabs */

body:not(.user-dark-mode) .nav-tabs {
    border-color: var(--light-border) !important;
}

body:not(.user-dark-mode) .nav-tabs > li > a,
body:not(.user-dark-mode) .nav-tabs > li > a:hover,
body:not(.user-dark-mode) .nav-tabs > li > a:focus {
    color: var(--light-muted) !important;
    background: transparent !important;
}

body:not(.user-dark-mode) .nav-tabs > li.active > a,
body:not(.user-dark-mode) .nav-tabs > li.active > a:hover,
body:not(.user-dark-mode) .nav-tabs > li.active > a:focus {
    color: var(--light-primary) !important;
    background: #FFFFFF !important;
    border-color: var(--light-border) !important;
}

/* Miscellaneous */

body:not(.user-dark-mode) .hr-line-dashed,
body:not(.user-dark-mode) hr {
    border-color: var(--light-border) !important;
}

<?php } ?>


/* =====================================================
   DARK MODE - MODERN CHARCOAL PURPLE
===================================================== */

<?php if (!$appearanceLight) { ?>

:root {
    --dark-bg: #101014;
    --dark-surface: #18181f;
    --dark-surface-2: #20202a;
    --dark-surface-3: #272733;

    --dark-border: #30303d;

    --dark-text: #f4f4f5;
    --dark-muted: #a1a1aa;

    --dark-primary: #A78BFA;
    --dark-primary-hover: #8B5CF6;
    --dark-primary-soft: rgba(167,139,250,.14);
}

/* Main background */

body.user-dark-mode,
body.user-dark-mode #wrapper,
body.user-dark-mode #page-wrapper,
body.user-dark-mode .wrapper-content,
body.user-dark-mode .gray-bg,
body.user-dark-mode .white-bg {
    background: var(--dark-bg) !important;
    color: var(--dark-text) !important;
}

/* Navbar */

body.user-dark-mode .navbar-static-top,
body.user-dark-mode .row.border-bottom,
body.user-dark-mode .page-heading {
    background: var(--dark-surface) !important;
    border-color: var(--dark-border) !important;
    color: var(--dark-text) !important;
}

body.user-dark-mode .navbar-static-top a,
body.user-dark-mode .navbar-static-top .welcome-message {
    color: var(--dark-text) !important;
}

/* Cards and panels */

body.user-dark-mode .ibox,
body.user-dark-mode .ibox-title,
body.user-dark-mode .ibox-content,
body.user-dark-mode .panel,
body.user-dark-mode .panel-heading,
body.user-dark-mode .panel-body,
body.user-dark-mode .well,
body.user-dark-mode .footer {
    background: var(--dark-surface) !important;
    color: var(--dark-text) !important;
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .ibox-title,
body.user-dark-mode .panel-heading {
    border-bottom: 1px solid var(--dark-border) !important;
}

/* Typography */

body.user-dark-mode h1,
body.user-dark-mode h2,
body.user-dark-mode h3,
body.user-dark-mode h4,
body.user-dark-mode h5,
body.user-dark-mode h6,
body.user-dark-mode label,
body.user-dark-mode .control-label {
    color: #F4F4F5 !important;
}

body.user-dark-mode .text-muted,
body.user-dark-mode .page-heading small {
    color: var(--dark-muted) !important;
}

body.user-dark-mode a:not(.btn):not(.dropdown-item) {
    color: var(--dark-primary);
}

body.user-dark-mode a:not(.btn):not(.dropdown-item):hover {
    color: #C4B5FD;
}

/* Form controls */

body.user-dark-mode .form-control,
body.user-dark-mode select,
body.user-dark-mode textarea,
body.user-dark-mode .input-group-addon {
    background: var(--dark-surface-2) !important;
    color: var(--dark-text) !important;
    border-color: var(--dark-border) !important;
    box-shadow: none !important;
}

body.user-dark-mode .form-control:focus,
body.user-dark-mode select:focus,
body.user-dark-mode textarea:focus {
    border-color: var(--dark-primary) !important;
    box-shadow: 0 0 0 2px var(--dark-primary-soft) !important;
}

body.user-dark-mode .form-control::placeholder {
    color: #71717A !important;
}

/* Tables */

body.user-dark-mode .table {
    color: var(--dark-text) !important;
    background: var(--dark-surface) !important;
}

body.user-dark-mode .table > thead > tr > th,
body.user-dark-mode .table > thead > tr > td,
body.user-dark-mode .table > tbody > tr > th,
body.user-dark-mode .table > tbody > tr > td,
body.user-dark-mode .table > tfoot > tr > th,
body.user-dark-mode .table > tfoot > tr > td {
    background: transparent !important;
    border-color: var(--dark-border) !important;
    color: inherit !important;
}

body.user-dark-mode table.dataTable thead,
body.user-dark-mode table.dataTable thead th,
body.user-dark-mode table.dataTable thead td {
    background: var(--dark-surface-2) !important;
    color: var(--dark-text) !important;
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .table-striped > tbody > tr:nth-of-type(odd) {
    background: rgba(255,255,255,.025) !important;
}

body.user-dark-mode .table-hover > tbody > tr:hover {
    background: var(--dark-primary-soft) !important;
}

/* Tabs */

body.user-dark-mode .nav-tabs {
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .nav-tabs > li > a,
body.user-dark-mode .nav-tabs > li > a:hover,
body.user-dark-mode .nav-tabs > li > a:focus {
    color: var(--dark-muted) !important;
    background: transparent !important;
    border-color: transparent !important;
}

body.user-dark-mode .nav-tabs > li.active > a,
body.user-dark-mode .nav-tabs > li.active > a:hover,
body.user-dark-mode .nav-tabs > li.active > a:focus {
    color: var(--dark-primary) !important;
    background: var(--dark-surface) !important;
    border-color: var(--dark-border) !important;
    border-bottom-color: var(--dark-surface) !important;
}

/* Buttons */

body.user-dark-mode .btn-default,
body.user-dark-mode .btn-white,
body.user-dark-mode .btn-outline,
body.user-dark-mode .btn-group .btn-default {
    color: var(--dark-text) !important;
    background: var(--dark-surface-3) !important;
    border-color: var(--dark-border) !important;
    box-shadow: none !important;
}

body.user-dark-mode .btn-default:hover,
body.user-dark-mode .btn-white:hover,
body.user-dark-mode .btn-outline:hover,
body.user-dark-mode .btn-default:focus,
body.user-dark-mode .btn-white:focus {
    color: #fff !important;
    background: #343442 !important;
    border-color: #525265 !important;
}

body.user-dark-mode .btn-primary {
    color: #fff !important;
    background: var(--dark-primary-hover) !important;
    border-color: var(--dark-primary-hover) !important;
}

body.user-dark-mode .btn-primary:hover,
body.user-dark-mode .btn-primary:focus {
    background: #7C3AED !important;
    border-color: #7C3AED !important;
}

body.user-dark-mode .btn-success {
    color: #fff !important;
    background: #16845f !important;
    border-color: #16845f !important;
}

body.user-dark-mode .btn-info {
    color: #fff !important;
    background: #18779a !important;
    border-color: #18779a !important;
}

body.user-dark-mode .btn-warning {
    color: #1f2937 !important;
    background: #e4a73d !important;
    border-color: #e4a73d !important;
}

body.user-dark-mode .btn-danger {
    color: #fff !important;
    background: #c84754 !important;
    border-color: #c84754 !important;
}

body.user-dark-mode .btn:disabled,
body.user-dark-mode .btn.disabled {
    opacity: .55;
}

/* Pagination */

body.user-dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button,
body.user-dark-mode .pagination > li > a,
body.user-dark-mode .pagination > li > span {
    color: var(--dark-text) !important;
    background: var(--dark-surface-2) !important;
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .dataTables_wrapper .dataTables_paginate .paginate_button.current,
body.user-dark-mode .pagination > .active > a,
body.user-dark-mode .pagination > .active > span {
    color: #fff !important;
    background: var(--dark-primary-hover) !important;
    border-color: var(--dark-primary-hover) !important;
}

/* Select2 */

body.user-dark-mode .select2-container--bootstrap .select2-selection,
body.user-dark-mode .select2-container--bootstrap4 .select2-selection,
body.user-dark-mode .select2-dropdown,
body.user-dark-mode .select2-container--default .select2-selection--single,
body.user-dark-mode .select2-container--default .select2-selection--multiple {
    color: var(--dark-text) !important;
    background: var(--dark-surface-2) !important;
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .select2-container--bootstrap .select2-selection__rendered,
body.user-dark-mode .select2-container--bootstrap4 .select2-selection__rendered,
body.user-dark-mode .select2-results__option {
    color: var(--dark-text) !important;
}

body.user-dark-mode .select2-results__option[aria-selected="true"],
body.user-dark-mode .select2-results__option--highlighted {
    color: #fff !important;
    background: #553C86 !important;
}

/* Dropdown */

body.user-dark-mode .dropdown-menu {
    background: var(--dark-surface) !important;
    border: 1px solid var(--dark-border) !important;
    box-shadow: 0 8px 24px rgba(0,0,0,.3) !important;
}

body.user-dark-mode .dropdown-menu > li > a {
    color: var(--dark-text) !important;
}

body.user-dark-mode .dropdown-menu > li > a:hover {
    color: #fff !important;
    background: var(--dark-primary-soft) !important;
}

/* Modal */

body.user-dark-mode .modal-content {
    background: var(--dark-surface) !important;
    color: var(--dark-text) !important;
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .modal-header,
body.user-dark-mode .modal-footer {
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .modal-header .close {
    color: var(--dark-text) !important;
    background: transparent !important;
    border: 0;
    text-shadow: none;
    opacity: .85;
}

/* Misc */

body.user-dark-mode .hr-line-dashed,
body.user-dark-mode hr {
    border-color: var(--dark-border) !important;
}

body.user-dark-mode .progress {
    background: var(--dark-surface-3) !important;
}

body.user-dark-mode .tooltip-inner {
    background: var(--dark-surface-3) !important;
    color: #fff !important;
}

<?php } ?>

</style>

<?php } ?>

</head>

<!-- <body class="fixed-sidebar no-skin-config "> -->

<body class="canvas-menu<?=isset($appearanceLight) && !$appearanceLight ? ' user-dark-mode' : ''?>">

<?php
    require_once($abs_us_root.$us_url_root.'users/includes/template/header3_must_include.php');
?>
