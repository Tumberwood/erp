<?php
$path=['','users/','usersc/applications/views/core/','usersc/applications/views/iittpmh/','usersc/applications/views/iicctmh/','usersc/applications/views/iibbrmh/','usersc/applications/views/iumxxmh/','usersc/applications/views/iimxxmh/','usersc/applications/views/iwhctmh/','usersc/applications/views/iwhxxmh/','usersc/applications/views/fcrxxmh/','usersc/applications/views/aakxxmh/','usersc/applications/views/fbtxxth/','usersc/applications/views/forxxth/','usersc/applications/views/psuxxmh/','usersc/applications/views/fbnxxmh/','usersc/applications/views/prqxxth/','usersc/applications/views/hodxxmh/','usersc/applications/views/podxxth/','usersc/applications/views/scuxxmh/','usersc/applications/views/fpytmmh/','usersc/applications/views/fpymtmh/','usersc/applications/views/posprrd/','usersc/applications/views/prqosrd/','usersc/applications/views/wloxxmh/','usersc/applications/views/itoxxth/'];
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
//redirect back to Userspice URL root (usually /)
header('Location: '.$us_url_root);
exit;
?>
