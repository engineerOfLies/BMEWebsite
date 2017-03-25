	<footer>
	<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="js/vendor/jquery.min.js"><\/script>')</script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="js/ie10-viewport-bug-workaround.js"></script>
	<script>
/*	document.onload = function()*/
	if (typeof sessionStorage.sessionId !== 'undefined')
{
	$("#profile").removeClass('disabled');
	$("#profile").prop('disabled', true);
	$("#loginButton").text('logout');
	document.getElementById("loginButton").onclick = function() {location.reload();location.href='logout.php';};
}
else
{
	$("#profile").addClass('disabled');
	$("#loginButton").text('login');
	document.getElementById("loginButton").onclick = function() {location.reload();location.href='login.php';};
}
// send session validation
function handleSessionResponse(response)
{
	var data = JSON.parse(response);
	document.getElementById("output").innerHTML=response;	
	if (data !== "ok")
	{
		sessionStorage.removeItem("sessionId");
		sessionStorage.removeItem("username");
		sessionStorage.removeItem("role");
		location.href = "login.php";
	}
}
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
	</script>
	<div id="output">
	</div>
	</footer>

