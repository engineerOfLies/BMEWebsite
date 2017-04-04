<?php include('header.php'); ?>
<link href="signin.css" rel="stylesheet">
<body>

    <div id="loginForm" class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Please sign in</h2>
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


    <!-- local project includes -->
    <script src="js/hovrs/calls.js"></script>
	<script>
function submitLogin()
{

	var uname = document.getElementById("inputName").value;
	var pword = document.getElementById("inputPassword").value;
	sendLoginRequest(uname,pword);
	return 0;
}

</script>
  </body>
<?php include('footer.php'); ?>
</html>
