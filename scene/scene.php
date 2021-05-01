<?php
	require_once 'base.php';
	use MudString\PennMUSH;
	use SensioLabs\AnsiConverter\AnsiToHtmlConverter;

	if (!$scenedb->count('volv_scene', ['scene_id'=>$num]))
	{
		$smarty->assign('message', "The entered ID was not found.");
		$smarty->display('error.tpl');
	}
	else
	{
		$scene_data = $scenedb->get('volv_scene', ['runner_name', 'runner_id', 'scene_title', 'scene_outcome', 'scene_status', 'scene_date_created'], ['scene_id'=>$num]);

		$pose_list = $scenedb->select('volv_action', ['character_name', 'character_id', 'action_text'], ['AND'=>['action_is_deleted'=>0, 'scene_id'=>$num]]);
		$pose_data = array();
		$log_data = "";
		$poser_ids = array();
		$converter = new AnsiToHtmlConverter();
		foreach ($pose_list as $indiv)
		{
			$ansi_text = PennMUSH::decode($indiv['action_text']);
			$scene_text = $converter->convert($ansi_text->render(true, true, false, false));
			$scene_text = str_replace("\n", "<br>", $scene_text);
			$scene_text = str_replace("\t", "&nbsp;&nbsp;&nbsp;&nbsp;", $scene_text);
			$scene_text = str_replace(" ", "&nbsp;&nbsp;", $scene_text);
			$pose_data[] = ["owner"=>$indiv['character_id'], "owner_name"=>$indiv['character_name'], "text"=>$scene_text];
			$poser_ids[] = $indiv['character_id'];
			$log_data .= ":'''{{#var:".$indiv['character_id']."|".$indiv['character_name']." (".$indiv['character_id'].")}} has posed:'''&lt;br&gt;".$scene_text."<br> <br>\n\n";
		}
		
		$poser_ids = array_unique($poser_ids);
		$poser_list = implode(", ",$poser_ids);
		$scene_date = substr($scene_data['scene_date_created'],0,10);
		#'location'=>$scene_data['room_name'],
		$scene = ["title"=>$scene_data['scene_title'], 'id'=>$num, 'description'=>$scene_data['scene_outcome'], 'formatted_poses'=>$pose_data, 'url'=>$url, 'poser_ids'=>$poser_list, 'creation_date'=>$scene_date];

		if($json) {
			header("Content-type: application/json");
			echo json_encode($scene);
		} else {
			$smarty->assign('poses', $pose_data);
			$smarty->assign('scene', $scene);
			$smarty->display('templates/scene.tpl');
		}
	}

?>
