<?php

require_once("../../../dbaccess/gamedata.inc");
require_once("../../../dbaccess/auth.inc");

if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET";
	echo json_encode($msg);
	exit(0);
}

file_put_contents("/tmp/phpoutput",print_r($_POST, true),FILE_APPEND);

function recordSessionData($request)
{
	validateSession($request['session']);
	if (!isset($request['orientations']))
	{
		err("no orientations information provided");	
	}
	$gdb = new GameDataDB();
	$ori = json_decode($request['orientations']);
	$cus = NULL;
	if (isset($request['custom']))
	{
		$cus = json_decode($request['custom']);
	}
	return $gdb->recordGameState($request['sessionId'],$ori,$cus);
}

function getSessionData($request)
{
	validateSession($request['session']);
	$gdb = new GameDataDB();
	return $gdb->getSessionData($request['sessionId']);
}

function getSessionList($request)
{
	validateSession($request['session']);
	return $gdb->getSessionList($request['gameName']);
}

function endSession($request)
{
	validateSession($request['session']);
	$cus = NULL;
	if (isset($request['custom']))
	{
		$cus = json_decode($request['custom']);
	}
	$gdb = new GameDataDB();
	return $gdb->endGameSession($request['gameSessionId'],$request['timestamp'],$cus);
}

function startSession($request)
{
	validateSession($request['session']);
	if (!isset($request['game']))
	{
		err("no game information provided");	
	}
	
	$gdb = new GameDataDB();
	$game = json_decode($request['game']);
	if (isset($game->name))
	{
		$response =  $gdb->startGameSessionName(
			$game->name,
			$game->startTime,
			$game->patientId,
			$game->calibrations);
		return $response;
	}
	if (isset($game->id))
	{
		return $gdb->startGameSession(
			$game->id,
			$game->startTime,
			$game->patientId,
			$game->calibrations);	
	}
	err("game data missing id and name");
}

$request = $_POST;
$response = "unsupported request type: ".$request["type"];
switch ($request["type"])
{
	case "getSessionData":
		$response = getSessionData($request);
	break;
	case "startSession":
		$response = startSession($request);
	break;
	case "endSession":
		$response = endSession($request);
	break;
	case "recordSessionData":
		$response = recordSessionData($request);
	break;
	case "getSessionList":
		$response = getSessionList($request);
	break;
}
file_put_contents("/tmp/phpoutput","response: ".json_encode($response),FILE_APPEND);
echo json_encode($response);

?>

