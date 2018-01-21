<?php
session_start();
require('config.php');
if(isset($_GET['lid']) && isset($_GET['code']))
{
	$lid=(int)$_GET['lid'];
	$code=$_GET['code'];
	$code=mysqli_real_escape_string($conn,$code);
	$query="SELECT user_id,content,heading FROM letters WHERE letter_id=$lid AND code='$code'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)==1)
	{
		$row=mysqli_fetch_row($result);
		$id=$row[0];
		$q= "SELECT firstname,lastname FROM users WHERE id=$id";
        $res=mysqli_query($conn, $q);
        $r=mysqli_fetch_row($res);
		$name=$r[0]." ".$r[1];
		$content=$row[1];
		$heading=$row[2];
	}
	else
		echo '<script type="text/javascript">window.location="https://www.post2dost.com";</script>';
}
else
	echo '<script type="text/javascript">window.location="https://www.post2dost.com";</script>';

mysqli_close($conn);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>DashBoard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<!-- Include stylesheet -->
	<link href="https://cdn.quilljs.com/1.2.6/quill.snow.css" rel="stylesheet">

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>


<body style="background-color: #34577a;">

	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	     	</button>
		    <a class="navbar-brand" href="https://www.post2dost.com/"><span class="glyphicon glyphicon-home" title="Home"></span></a>
	    </div>

	<div class="collapse navbar-collapse" id="myNavbar">
	    <ul class="nav navbar-nav">
	      <p class="navbar-text" style="font-size: 1.15em;">Post2Dost</p>
	    </ul>


		<ul class="nav navbar-nav navbar-right">

		    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="logo.jpg"  class="img-circle" width="30" height="30"></a>
		        
	     	</li>
		</ul>

		</div>
	  </div>
	</nav>

	<div class="row">

		<div class="col-sm-6" style="border: 1px solid black; height: 40px;">
			
			<p style="color: white; font-size: 1.5em;">Quote Of The Day</p>

		</div>
	</div>


	<div class="row" style="top: 100px; border: 1px solid black; width: 100%; margin: 0px;">

		<div class="col-sm-6" style="border: 1px solid black; color: black; padding: 0; background-color: rgb(255,255,255);">
			
			<div id="form-container" class="container" style="max-width: 100%; height: inherit;">
				<h2><?php echo "Your Letter from $name";?>
				<h3><?php echo $heading;?>
				<div id="editor-container" style="width: inherit; background-color: rgb(255,255,255); color: black; height: 350px;" ></div>
			</div>
		</div>
	</div>

<footer class="panel foot" style="background-color: rgb(25,25,25); color: rgb(200,200,200);"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>


	<!-- Include the Quill library -->
		<script src="https://cdn.quilljs.com/1.2.6/quill.js"></script>



<script type="text/javascript">

//alert('<?php echo $content;?>');
	var quill = new Quill('#editor-container', {
  modules: {
    toolbar: false
  },
  readOnly: true,
  theme: 'snow'
});
var con=<?php echo $content;?>;
quill.setContents(con);

</script>

</body>
</html>
<?php session_write_close();
?>