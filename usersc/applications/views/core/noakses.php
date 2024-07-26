<?php 
    //kalau init.php diaktifkan di noakses.php, maka akan ada error
    //Notice: Undefined index: user in D:\xampp\htdocs\erpx\usersc\includes\loader.php on line 39
    // require_once '../../../../users/init.php';

    $abs_us_root=$_SERVER['DOCUMENT_ROOT'];

    $self_path=explode("/", $_SERVER['PHP_SELF']);
    $self_path_length=count($self_path);
    $file_found=FALSE;

    for($i = 1; $i < $self_path_length; $i++){
        array_splice($self_path, $self_path_length-$i, $i);
        $us_url_root=implode("/",$self_path)."/";

        if (file_exists($abs_us_root.$us_url_root.'z_us_root.php')){
            $file_found=TRUE;
            break;
        }else{
            $file_found=FALSE;
        }
    }
    $settings = new stdClass();
    $settings->template = "inspinia-side"; //ini dibuat hard code karena tidak bisa akses db

    //ini kalau diaktifkan akan membuat noakses redirect ke login.php, karena 
    // if (!securePage($_SERVER['PHP_SELF'])) {
    //     die();
    // }
?>

<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>INSPINIA | 500 Error</title>

    <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/animate.css" rel="stylesheet">
    <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/style.css" rel="stylesheet">
    <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/custom.css" rel="stylesheet">
    <link href="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/css/font-awesome.min.css" rel="stylesheet">

</head>

<body class="gray-bg">


    <div class="middle-box text-center animated fadeInDown">
        <h1>Oops</h1>
        <h3 class="font-bold">No Data Akses</h3>

        <div class="error-desc">
            User Anda sudah aktif, tetapi belum memiliki akses data.<br>Silakan hubungi administrator untuk meminta hak akses data.
        </div>
    </div>

    <!-- Mainly scripts -->
    <script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/jquery-3.2.1.min.js"></script>
    <script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/popper.min.js"></script>
    <script src="<?=$us_url_root?>usersc/templates/<?=$settings->template?>/assets/js/bootstrap.min.js"></script>

</body>

</html>
