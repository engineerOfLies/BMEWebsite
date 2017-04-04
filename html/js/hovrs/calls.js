/**
	pull game session data
*/

function HandleSessionDataResponse(response)
{
	var data = JSON.parse(response);
	var text = JSON.stringify(response);
	if (data.status == "fail")
	{
		alert(text);
		return;
	}
	sessionStorage.setItem("orientation",data);	
}

function sendSessionDataRequest(sessionId)
{
	var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username};
	var sessionString = JSON.stringify(session);
	
	var request = new XMLHttpRequest();
	request.open("POST","rpc/gamedata.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange = function ()
	{
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleSessionDataResponse(this.responseText);
		}
	}
	request.send("type=getSessionData&sessionId="+sessionId+"&session="+sessionString);
}


/**
	@brief handle a user login event
*/

function HandleLoginResponse(response)
{
	var data = JSON.parse(response);
	var text = JSON.stringify(response);
	if (data.status != "success")
	{
		alert("Login Failed");
		location.reload();
	}
	else
	{
		sessionStorage.setItem("sessionId",data.sessionId);
		sessionStorage.setItem("username",data.username);
		sessionStorage.setItem("role",data.role);
		location.href = "profile.php";
	}
}

function sendLoginRequest(username,password)
{
	var request = new XMLHttpRequest();
	request.open("POST","rpc/auth.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange = function ()
	{
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleLoginResponse(this.responseText);
		}
	}
	request.send("type=auth&username="+username+"&password="+password);
}

function signoff()
{
	sessionStorage.removeItem("sessionId");
	sessionStorage.removeItem("username");
	sessionStorage.removeItem("role");
	location.href = "login.php";
}
/**
	@brief handle session validation on each page
	Used in the footer
*/
function handleSessionResponse(response)
{
	var data = JSON.parse(response);
	if (data !== "ok")
	{
		sessionStorage.removeItem("sessionId");
		sessionStorage.removeItem("username");
		sessionStorage.removeItem("role");
		location.href = "login.php";
	}
}

function validateSession()
{
	if (sessionStorage.sessionId !== undefined)
	{
		var request = new XMLHttpRequest();
		var session = {
id : sessionStorage.sessionId,
	 name : sessionStorage.username
		};
		var sesString = JSON.stringify(session);
		request.open("POST","rpc/auth.php",true);
		request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		request.onreadystatechange = function ()
		{
			if ((this.readyState == 4)&&(this.status == 200))
			{
				handleSessionResponse(this.responseText);
			}
		}
		request.send("type=validate&session="+sesString);
	}
}

