<?php include('header.php'); ?>
<link href="signin.css" rel="stylesheet">
<body>

    <div id = "output">
	status<p>
    </div>
    <div class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Orientation Test</h2>
        <label for="inputName" class="sr-only">Username</label>
        <input type="username" id="inputName" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
        <div class="checkbox">
          <label>
            <input type="checkbox" value="remember-me"> Remember me
          </label>
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="submitLogin()">Sign in</button>
      </form>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<script>
function submitLogin()
{

	var uname = document.getElementById("inputName").value;
	var pword = document.getElementById("inputPassword").value;
	document.getElementById("output").innerHTML = "username: " + uname + "<p>password: "+pword+"<p>";	
	sendOrientationData();
	return 0;
}

function HandleLoginResponse(response)
{
	var data = JSON.parse(response);
	var text = JSON.stringify(response);
	document.getElementById("output").innerHTML = "response: "+text+"<p>";
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
	}
}

function sendOrientationData()
{	
	var session = {
			id : sessionStorage.sessionId,
			name : sessionStorage.username};
	var sessionString = JSON.stringify(session);
	var sessionId = 1;
	var ts =Date.now();
	var	orientations = [
			[ts,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,0.5,
			0.5,0.5,0.5,0.5
			]
			];
	var orientationString = JSON.stringify(orientations);
	var request = new XMLHttpRequest();
	request.open("POST","rpc/gamedata.php",true);
	request.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	request.onreadystatechange = function ()
	{
		if ((this.readyState == 4)&&(this.status == 200))
		{
			HandleLoginResponse(this.responseText);
		}
	}
	request.send("type=recordSessionData&sessionId="+sessionId+"&session="+sessionString+"&orientations="+orientationString+"&custom=none");
}

</script>
  </body>
<?php include('footer.php'); ?>
