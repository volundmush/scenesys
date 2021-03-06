<?php
	require_once 'base.php';
	$scene_list = array_reverse($scenedb->select('volv_scene', ["scene_id", "runner_id", "runner_name", "scene_title", "scene_outcome", "scene_status"], ["scene_status[!]"=>2]));
	
	$state_array = ["0"=>"Active", "1"=>"Paused", "2"=>"Unfinished", "3"=>"Finished", "4"=>"Scheduled"];
	$scene_data = array();
	foreach ($scene_list as $indiv)
	{
		$indiv_data = ["id"=>$indiv['scene_id'], "owner_name"=>$indiv['runner_name'], "owner"=>$indiv['runner_id'], 'title'=>$indiv['scene_title'], "description"=>$indiv['scene_outcome'], "state"=>$state_array[$indiv['scene_status']]];
		$scene_data[] = $indiv_data;
	}
	if($json) {
		header("Content-type: application/json");
		echo json_encode($scene_data);
	} else {
		$smarty->assign('scenes', $scene_data);
		$smarty->display('templates/listing.tpl');
	}


?>
