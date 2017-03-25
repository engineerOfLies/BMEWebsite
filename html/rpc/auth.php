<?php

require_once("../../../dbaccess/auth.inc");

function doLogin($username,$password)
{
	$auth = new AuthDB();
	return $auth->userLogin($username,$password);
}

if (!isset($_POST))
{
	$msg = "NO POST MESSAGE SET";
	echo json_encode($msg);
	exit(0);
}
$request = $_POST;
$response = "unsupported request type";
switch ($request["type"])
{
	case "auth":
		$response = doLogin($request["username"],$request["password"]);
	break;
	case "validate":
		$response = validateSession($request['session']);
	break;
}
$r = json_encode($response);
file_put_contents("/tmp/auth.php.output",$r."\n",FILE_APPEND);
echo $r;

?>
