<?php include('header.php'); ?>
<body>
<div class="row">
	<div class="col-md-6">
		<video id="monitor" autoplay></video>
	</div>
	<div class="col-md-6">
		<canvas id="videoImage"></canvas>
	</div>
</div>
<p id="errorMessage"></p>
</body>


<?php include('footer.php'); ?>
<script>
if ( !window.requestAnimationFrame )
{
	window.requestAnimationFrame = ( function() {
		return window.webkitRequestAnimationFrame ||
		window.mozRequestAnimationFrame ||
		window.oRequestAnimationFrame ||
		window.msRequestAnimationFrame ||
		function( callback,  element )
		{
			window.setTimeout( callback, 1000 / 60 );
		};
	} )();

}
navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia;
window.URL = window.URL || window.webkitURL;

var camvideo = document.getElementById('monitor');

	if (!navigator.getUserMedia) 
	{
		document.getElementById('errorMessage').innerHTML = 
			'Sorry. <code>navigator.getUserMedia()</code> is not available.';
	}
	navigator.getUserMedia({video: true}, gotStream, noStream);

function gotStream(stream) 
{
	if (window.URL) 
	{   camvideo.src = window.URL.createObjectURL(stream);   } 
	else // Opera
	{   camvideo.src = stream;   }

	camvideo.onerror = function(e) 
	{   stream.stop();   };

	stream.onended = noStream;
}

function noStream(e) 
{
	var msg = 'No camera available.';
	if (e.code == 1) 
	{   msg = 'User denied access to use camera.';   }
	document.getElementById('errorMessage').textContent = msg;
}
</script>
<script>

// global variables
var video, videoImage, videoImageContext;

// assign variables to HTML elements
video = document.getElementById( 'monitor' );
videoImage = document.getElementById( 'videoImage' );
videoImageContext = videoImage.getContext( '2d' );

// background color if no video present
videoImageContext.fillStyle = '#005337';
videoImageContext.fillRect( 0, 0, videoImage.width, videoImage.height );				

// start the loop				
animate();

function animate() 
{
    requestAnimationFrame( animate );
	render();		
}

function render() 
{	
	if ( video.readyState === video.HAVE_ENOUGH_DATA ) 
		videoImageContext.drawImage( video, 0, 0, videoImage.width, videoImage.height );
}

</script>
</html>

