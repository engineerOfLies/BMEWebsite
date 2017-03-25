<?php include('header.php'); ?>


<div id="title">
</div>


<?php include('footer.php'); ?>
<script>
if (sessionStorage.sessionId === undefined)
{
	location.href = "login.php";
}
document.getElementById("title").innerHTML = "<h1> Welcome "+sessionStorage.username+"!</h1>";
</script>
</html>

