<?php
session_start();
include 'config.php';
date_default_timezone_set('Asia/Kolkata');
$email=$emailErr=$dateErr="";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(isset($_POST['self']))
	{
		$id=$_SESSION['id'];
		$query="SELECT email FROM users WHERE id=$id";
		$result=mysqli_query($conn,$query);
		$row=mysqli_fetch_row($result);
		$email=$row[0];
	}
	else
	{
		if(empty($_POST['email']))
			$emailErr="Email is required.";
		if(empty($_POST['deliver']))
			$dateErr="Date is required.";
		
		if(!empty($_POST['email']) && !empty($_POST['deliver']))
		{
		    $hour=(int)$_POST['hour'];
		    //echo $hour;
			$id=$_SESSION['id'];
			$email = test_input($_POST["email"]);
			$email=mysqli_real_escape_string($conn,$email);
			$sch=$_POST["today"];
			$del=$_POST["deliver"];
			$lid=$_SESSION['letter_id'];
			$query="UPDATE letters SET email='$email',scheduled='$sch',deliver='$del',time=$hour WHERE user_id=$id AND letter_id=$lid";
			mysqli_query($conn,$query);
			echo'<script type="text/javascript">
  window.location="https://www.post2dost.com/DashBoard.php"; 
</script>';
			
		}
	}
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
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
	
<!--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css' />
<script src='https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.js'></script>

<script src="https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>-->

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
	      <p class="navbar-text" style="font-size: 1.15em;">DashBoard</p>
	    </ul>


		<ul class="nav navbar-nav navbar-right">

		    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="logo.jpg"  class="img-circle" width="30" height="30"></a>
		        <ul class="dropdown-menu">
		          <li><a href="#">View Profile</a></li>
		          <li><a href="#">Edit Profile</a></li>
		          <li><a href="#">My Letters</a></li>
		          <li><a href="#">Logout</a></li>
		        </ul>
	     	</li>
		</ul>

		</div>
	  </div>
	</nav>

	<div class="row">
		<div class="col-sm-3" style="border: 1px solid black; height: 40px;">
			<form style="border: 1px solid black; width: 105%;">
			  <div class="input-group">
			    <input type="text" class="form-control" placeholder="Search">
			    <div class="input-group-btn">
			      <button class="btn btn-default" type="submit">
			        <i class="glyphicon glyphicon-search"></i>
			      </button>
			    </div>
			  </div>
			</form>
		</div>

		<div class="col-sm-6" style="border: 1px solid black; height: 40px;">
			
			<p style="color: white; font-size: 1.5em;">Quote Of The Day</p>

		</div>

		<div class="col-sm-3" style="border: 1px solid black; height: inherit; height: 40px;">
			<p style="color: white; font-size: 1.5em;">Hello <?php echo $_SESSION['name'];?></p>

		</div>

	</div>


	<div class="row" style="top: 100px; border: 1px solid black; width: 100%; margin: 0px;">
		<div class="col-sm-3" style="border: 1px solid black; color: white; padding: 0;">

			<div style="border: 1px solid black; background-image: url('Calender.png'); background-size: contain; height: 220px;">Inspiration
			<br>
			<br>
			<br>
			<br>
			</div>
			<div style="border: 0px solid black; height: 220px;">
				<br>
				<br>
				<br>
				<br>
			</div>
			

		</div>

		<div class="col-sm-6" style="border: 1px solid black; color: black; padding: 0; background-color: rgb(255,255,255);">
			
			<div style="border: 1px solid black;">
				Schedule Your Letter
			</div>


			<div id="form-container" class="container" style="max-width: 100%; height: inherit;">
				 <form id="form" method="post" action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> > 

  E-mail: <input type="email" name="email" id="email" value="<?php echo $email;?>"> OR 
  <input type="submit" name="self" value="Send to yourself">
  <span class="error" id="d_err"><?php echo $emailErr;?></span>
  <br><br>
  Deliver By: <input type="date" name="deliver" min="<?php echo date('Y-m-d',strtotime(date('Y-m-d') . "+0 days"));;
  ?>">
  <span class="error" id="d_err"><?php echo $dateErr;?></span>
  <br><br>
  Time: <select name="hour" form="form">
      <?php
      for($i=0;$i<24;$i++)
      {
          echo "<option value=$i>$i</option>";
      }
      ?>
  </select><br><br>
  <input type="submit" name="submit" value="Confirm">  
  <input type="hidden" name="today" value="<?php echo date('Y-m-d');?>"> 
</form>
			</div>


		</div>

		<div class="col-sm-3" style="border: 1px solid black; color: white; padding: 0;">


		<div style="border: 1px solid black; height: 220px;">Notifications<br>
			1. First Letter			<br>
			2. Second Letter        <br>
			3. Third Letter         <br>
		</div>

		<div style="border: 1px solid black; height: 220px;">
			Calendar
		<div id='calendar'></div>
		</div>


		</div>
	</div>



<footer class="panel foot" style="background-color: rgb(25,25,25); color: rgb(200,200,200);"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>

</body>
</html>
<?php session_write_close();
?>