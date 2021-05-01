<?php
	require_once 'vendor/autoload.php';
	use Medoo\Medoo;

	$db_data = [
		"database_type"=>"mysql",
		"database_name"=>"database",
		"server"=>"localhost",
		"username"=>"username",
		"password"=>"password",
		"charset"=>"utf8",
		"prefix"=>""
	];

	$posecount = 0;
	$gamename = "SceneSys";
	$gamedesc = "Game desc here!";
	$gameurl = "https://github.com/volundmush/mushcode";
	$gameconnect = "<connect data here>";
	
	$url = "../index.php/Special:FormEdit/Roleplaying Log/";
	
	$scenedb = new Medoo($db_data);
	$num = ($_REQUEST['id']  ? $_REQUEST['id'] : $num );
	$json = ($_REQUEST['json']  ? $_REQUEST['json'] : $json );
	$smarty = new Smarty;
	$gameinfo = ["name"=>$gamename,"desc"=>$gamedesc,"site"=>$gameurl,"connect"=>$gameconnect];
	$smarty->assign('info', $gameinfo);
	
?>
