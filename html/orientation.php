<?php include('header.php'); ?>


<div id="title">
</div>
<div id = data>
</div>

<?php include('footer.php'); ?>
    <!-- local project includes -->
    <script src="js/hovrs/calls.js"></script>
<script>
if (sessionStorage.sessionId == undefined)
{
	location.href = "login.php";
}
$("#orientation").addClass("active");

sendSessionDataRequest(1);
if (sessionStorage.orientation != undefined)
{
	document.getElementById("data").innerHTML = JSON.stringify(sessionStorage.orientation);
}
</script>
</html>

