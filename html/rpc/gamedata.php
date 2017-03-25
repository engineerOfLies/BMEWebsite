<?php

require_once("../../../dbaccess/gamedata.inc");
require_once("../../../dbaccess/auth.inc");

if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET";
	echo json_encode($msg);
	exit(0);
}

file_put_contents("/tmp/phpoutput",print_r($_POST, true));

function recordSessionData($request)
{
	validateSession($request['session']);
	if (!isset($request['orientations']))
	{
		err("no orientations information provided");	
	}
	$gdb = new GameDataDB();
	$ori = json_decode($request['orientations']);
	$cus = json_decode($request['custom']);
	return $gdb->recordGameState($request['sessionId'],$ori,$cus);
}

function startSession($request)
{
	validateSession($request['session']);
	if (!isset($request['game']))
	{
		err("no game information provided");	
	}
	$gdb = new GameDataDB();
	$game = $request['game'];
	if (isset($game['name']))
	{
		return $gdb->startGameSessionName(
			$game['name'],
			$game['startTime'],
			$game['patientId'],
			$game['calibrations']);
	}
	if (isset($game['id']))
	{
		return $gdb->startGameSession(
			$game['id'],
			$game['startTime'],
			$game['patientId'],
			$game['calibrations']);	
	}
	err("game data missing id and name");
}

$request = $_POST;
$response = "unsupported request type";
switch ($request["type"])
{
	case "startSession":
		$response = startSession($request);
	break;
	case "recordSessionData":
		$response = recordSessionData($request);
	break;
}
echo json_encode($response);

?>

