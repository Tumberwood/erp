<!-- Load CSS -->
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/animate.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/style.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/custom.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/font-awesome.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/material-icons.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/iCheck/green.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/datepicker/bootstrap-datepicker.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/select2/select2.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/select2/select2-bootstrap.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/toastr/toastr.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/selectize/selectize.bootstrap3.min.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/quill/quill.snow.css" rel="stylesheet">
<link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/plugins/switchery/switchery.css" rel="stylesheet">

<style>
	.select2-dropdown{
		z-index: 3051;
	}
	.select2-container {
		width: 100%!important;
	}
	div.selectize-dropdown {
		z-index: 9999;
	}
	.datepicker.dropdown-menu {
		z-index: 9999 !important;
	}
	div.quill-wrapper {
        min-height: 6em;
        border: 1px solid #ccc;
        background-color: white;
    }
    div.quill-wrapper div.toolbar {
        border-bottom: 1px solid #ccc;
    }

	.floating-button {
		position: fixed;
		bottom: 20px;
		right: 20px;
		background-color: #1ab394;
		color: white;
		border-radius: 50%;
		width: 50px;
		height: 50px;
		display: flex;
		align-items: center;
		justify-content: center;
		box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
		font-size: 24px;
		cursor: pointer;
		transition: background-color 0.3s ease;
		z-index: 9999 !important; /* Ensures the button is on top of all elements */
	}

	.floating-button:hover {
		background-color: #179b77;
	}

	.tooltip {
		visibility: hidden;
		width: 120px;
		background-color: #555;
		color: #fff;
		text-align: center;
		border-radius: 6px;
		padding: 5px 0;
		position: absolute;
		z-index: 1;
		bottom: 125%; /* Position above the button */
		left: 50%;
		margin-left: -60px; /* Center the tooltip */
		opacity: 0;
		transition: opacity 0.3s;
	}

	.floating-button:hover .tooltip {
		visibility: visible;
		opacity: 1;
	}
</style>

<!-- Button untuk Filter Floating-->
<div class="floating-button" id="btnFilterFloating" title="Filter" style="display: none">
	<i class="fa fa-filter"></i>
</div>
