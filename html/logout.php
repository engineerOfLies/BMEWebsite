<?php include('header.php'); ?>
<link href="signin.css" rel="stylesheet">
<body>
    <div id="loginForm" class="container">

      <form class="form-signin">
        <h2 class="form-signin-heading">Log Out?</h2>
        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="signoff()">Sign Off</button>
      </form>

    </div> <!-- /container -->

</body>
<?php include('footer.php'); ?>
<script>
function signoff()
{
sessionStorage.removeItem("sessionId");
sessionStorage.removeItem("username");
sessionStorage.removeItem("role");
location.href = "login.php";
}
</script>
</html>
