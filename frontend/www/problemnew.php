<?php

require_once("../server/bootstrap.php");
require_once("api/ApiCaller.php");

$smarty->assign('TITLE', "");
$smarty->assign('ALIAS', "");
$smarty->assign('VALIDATOR', "token-caseless");
$smarty->assign('TIME_LIMIT', "1000");
$smarty->assign('OVERALL_WALL_TIME_LIMIT', "60000");
$smarty->assign('OUTPUT_LIMIT', "10240");
$smarty->assign('MEMORY_LIMIT', "32768");
$smarty->assign('STACK_LIMIT', "10485760");
$smarty->assign('SOURCE', "");
$smarty->assign('PUBLIC', "0");

if (isset($_POST["request"]) && ($_POST["request"] == "submit")) {
		
	$r = new Request(array(
				"auth_token" => $smarty->getTemplateVars('CURRENT_USER_AUTH_TOKEN'),
				"title" => $_POST["title"],
				"alias" => $_POST["alias"],
				"validator" => $_POST["validator"],
				"time_limit" => $_POST["time_limit"],
				"overall_wall_time_limit" => $_POST["overall_wall_time_limit"],
				"memory_limit" => $_POST["memory_limit"],
				"output_limit" => $_POST["output_limit"],
 				"source" => $_POST["source"],				
				"public" => $_POST["public"],
				"stack_limit" => $_POST["stack_limit"]
			));
	$r->method = "ProblemController::apiCreate";

	$response = ApiCaller::call($r);

	if ($response["status"] == "error") {
		$smarty->assign('STATUS_ERROR', $response["error"]);
		$smarty->assign('TITLE', $_POST["title"]);
		$smarty->assign('ALIAS', $_POST["alias"]);
		$smarty->assign('VALIDATOR', $_POST["validator"]);
		$smarty->assign('TIME_LIMIT', $_POST["time_limit"]);
		$smarty->assign('OUTPUT_LIMIT', $_POST["output_limit"]);
		$smarty->assign('MEMORY_LIMIT', $_POST["memory_limit"]);
		$smarty->assign('SOURCE', $_POST["source"]);
		$smarty->assign('PUBLIC', $_POST["public"]);
		$smarty->assign('STACK_LIMIT', $_POST["stack_limit"]);
	} else if ($response["status"] == "ok") {
		header("Location: /problem/edit/{$response['alias']}/");
		die();
	}
}

$smarty->display('../templates/problem.new.tpl');
