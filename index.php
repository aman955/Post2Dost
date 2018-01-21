<?php session_start();
require 'config.php';

$mailErr="";
if($_SERVER["REQUEST_METHOD"] == "POST")
{	
    if(!empty($_POST['mail']))
		{
		$mail=$_POST['mail'];	
			       $mail=mysqli_real_escape_string($conn,$mail);
    $mail = strtolower(test_input($_POST["email"]));
	  $search = "SELECT email FROM newsletters WHERE email= '$mail' ";
  
$result = mysqli_query($conn, $search);

$counti = mysqli_num_rows($result);

if($counti>0)
{
	$emailErr= "Email already subscribed.";
}
  else {
    $mail = test_input($_POST["mail"]);
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
    else
    {
        $queri= "INSERT INTO newsletters(email) VALUES('$mail')";
        $result = mysqli_query($conn, $queri);
    }
		}
}
}


require_once ('libraries/Google/autoload.php');

//Insert your cient ID and secret 
$client_id = '1029605450202-12rruotf4072o3m75onm54eolt0gpdl0.apps.googleusercontent.com';
$client_secret = 'W9ZTl9pRAXbm8FDWg_w1I4--';
$redirect_uri = 'https://www.post2dost.com';


########## MySql details  #############
$db_username = "post2inext"; //Database Username
$db_password = "PostToDost*123#"; //Database Password
$host_name = "localhost"; //Mysql Hostname
$db_name = 'post2ine_users'; //Database Name
###################################################################
//incase of logout request, just unset the session var
if (isset($_GET['logout'])) {
  unset($_SESSION['access_token']);
}

/************************************************
  Make an API request on behalf of a user. In
  this case we need to have a valid OAuth 2.0
  token for the user, so we need to send them
  through a login flow. To do this we need some
  information from our API console project.
 ************************************************/
$client = new Google_Client();
$client->setClientId($client_id);
$client->setClientSecret($client_secret);
$client->setRedirectUri($redirect_uri);
$client->addScope("email");
$client->addScope("profile");

/************************************************
  When we create the service here, we pass the
  client to it. The client then queries the service
  for the required scopes, and uses that when
  generating the authentication URL later.
 ************************************************/
$service = new Google_Service_Oauth2($client);

/************************************************
  If we have a code back from the OAuth 2.0 flow,
  we need to exchange that with the authenticate()
  function. We store the resultant access token
  bundle in the session, and redirect to ourself.
*/
  
if (isset($_GET['code'])) {
  $client->authenticate($_GET['code']);
  $_SESSION['access_token'] = $client->getAccessToken();
  header('Location: ' . filter_var($redirect_uri, FILTER_SANITIZE_URL));
  exit;
}

/************************************************
  If we have an access token, we can make
  requests, else we generate an authentication URL.
 ************************************************/
if (isset($_SESSION['access_token']) && $_SESSION['access_token']) {
  $client->setAccessToken($_SESSION['access_token']);
} else {
  $authUrl = $client->createAuthUrl();
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
<!-- saved from url=(0025)http://www.post2dost.com/ -->
<html lang="en">
    
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta https-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Welcome to Post2Dost. Here we build and nurture relations and emotions.">
    <meta name="author" content="">
    <link rel="icon" href="./logo.jpg">
    <title>Homepage-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js.download"></script>
    <script id="id_ad_rns_lqwls" src="./bootstrap-3/adrns.js.download"></script>
    <link rel="stylesheet" type="text/css" href="./Homepage-Post2Dost_files/style-homepage.css">
</head>

<body>&nbsp;
  
     <?php
        if(isset($_SESSION['id']))
		{
		    echo '<nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
            <div class="container nav-head">
	            Hello '.$_SESSION['name'].'
	  
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="./Homepage-Post2Dost_files/logo.jpg">
        </div>
        <div id="navbar" class="pull-left navbar-collapse collapse">
          
      </div>
    </div></nav>';	

	}
	else
	{
	?> <nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
      <div class="container nav-head">
	  
	  
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="./Homepage-Post2Dost_files/logo.jpg">
        </div>
        <div id="navbar" class="pull-left navbar-collapse collapse">
          <form id="login_form" class="navbar-form navbar-right" onsubmit="return submitdata();" method="POST">
            <div class="form-group">
              <input type="text" placeholder="Email" class="form-control" name="usrnm"  >
              <span class="error" id="e_err"></span>
            </div>
            <div class="form-group">
              <input type="password" placeholder="Password" class="form-control" name="pwd">
              <span class="error" id="p_err"></span>
            </div>
            
            <button type="submit" class="btn btn-success">Sign in</button><br>
            <label>
                <input type="checkbox" name="rememberme" id="rememberme" value="true"> Remember me
              </label>
              <a href="https://www.post2dost.com/forgot.php" style="color:white"><span style="padding-left:85px;"></span>Forgot Password?</a>
          </form>
      </div>
      
        <div class="navbar-header pull-right">
          
 <?php
       if(!isset($_SESSION['id']))
          {
          
if (isset($authUrl)){
    
	//show login url
	echo '<div align="center">';

	echo '<a class="login" href="' . $authUrl . '"><img src="images/google-login-button.png" /></a>';
	echo '</div>';
	
} else {
	
	$user = $service->userinfo->get(); //get user info 
	
	// connect to database
	$mysqli = new mysqli($host_name, $db_username, $db_password, $db_name);
    if ($mysqli->connect_error) {
        die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
    }
	
	//check if user exist in database using COUNT
	$result = $mysqli->query("SELECT COUNT(google_id) as usercount FROM google_users WHERE google_id=$user->id");
	
	$user_count = $result->fetch_object()->usercount; //will return 0 if user doesn't exist
	
	

	if($user_count) //if user already exist change greeting text to "Welcome Back"
    {
 
    }
	else //else greeting text "Thanks for registering"
	{ 
	  
		
		$pic_link=$user->link;
		$link=$user->picture;
		$id=$user->id;
		$email=$user->email;
		$name=$user->name;
$parts = explode(" ", $name);
$lastname = array_pop($parts);
$firstname = implode(" ", $parts);
		
	
		$statement = $mysqli->prepare("INSERT INTO google_users (google_id,google_firstname, google_lastname, google_email, google_link, google_picture_link) VALUES (?,?,?,?,?,?)");
	 	$statement->bind_param('isssss',$user->id, $firstname,  $lastname, $user->email, $user->link, $user->picture);
		$statement->execute();
		echo $mysqli->error;
		
    
    }
    if(!isset($_SESSION['id']))
    {
        $_SESSION['id']=$user->id;
        $_SESSION['name']=$user->name;
        	echo'<script type="text/javascript">
  window.location="http://www.post2dost.com"; 
</script>';
    }
    
    
    
}
}
?>
        </div>
    </div></nav>;
	<?php
	}   ?>

<script type="text/javascript">
function submitdata()
{
//alert("**");
//console.log("**");
var email,pass;
//window.onload = function() {
  email=document.getElementById("login_form").elements[0].value;
  pass=document.getElementById("login_form").elements[1].value;

//}
 //alert(email);
   // console.log(document.getElementById("form").elements[0].value);

 $.ajax({
 async: true,
  type: 'post',
  url: 'logindb.php',
  data: {
   user_email:email,
   user_pass:pass
  },
  success: function (result) {
	if(result==1)
	{
		//alert("done");
		location.href = "https://www.post2dost.com/DashBoard.php";
	}
	else if(result==2)
	{
		//alert("not verified");
		location.href = "https://www.post2dost.com/welcome.php";
	}
	else
	{
		document.getElementById("e_err").textContent=JSON.parse(result).email;
		document.getElementById("p_err").textContent=JSON.parse(result).pass;
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
	
 return false;
}

function submitdataXs()
{
//alert("**");
//console.log("**");
var email,pass;
//window.onload = function() {
  email=document.getElementById("login_form_xs").elements[0].value;
  pass=document.getElementById("login_form_xs").elements[1].value;

//}
 //alert(email);
   // console.log(document.getElementById("form").elements[0].value);

 $.ajax({
 async: true,
  type: 'post',
  url: 'logindb.php',
  data: {
   user_email:email,
   user_pass:pass
  },
  success: function (result) {
	if(result==1)
	{
		//alert("done");
		location.href = "https://www.post2dost.com/DashBoard.php";
	}
	else if(result==2)
	{
		//alert("not verified");
		location.href = "https://www.post2dost.com/welcome.php";
	}
	else
	{
		document.getElementById("e_err_xs").textContent=JSON.parse(result).email;
		document.getElementById("p_err_xs").textContent=JSON.parse(result).pass;
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
	
 return false;
}

</script>
  

	<!-- 
	 <form action="login_process.php" method="POST">
										<h4>LogIn</h4>
											<b>Username:</b>
											<br><input type="text" name="usrnm"><br>
										
											<br>
											<b>Password:</b>
											<br><input type="password" name="pwd">
											<br><br><input type="submit" id="x" value="Login" />
										</form> 
										-->
	
<!--menu bar-->
    <div class="navbar-wrapper cus-menu-bar">
      <div class="container">
        <nav class="navbar navbar-inverse navbar-static-top">
          <div class="container">
            <div class="navbar-header">
              <button id="dLabel" type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
            </div>
            <div id="navbar-menu" class="navbar-collapse collapse">
              <ul class="nav navbar-nav" aria-labelledby="dLabel">
                <li class="active"><a href="https://www.post2dost.com/">Home</a></li>
                <li><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
				<?php
				if(!isset($_SESSION['id']))
                    echo '<li><a href="https://www.post2dost.com/Register.php">Register</a></li>';
			    else 
			    {
				   echo '<li><a href="https://www.post2dost.com/logout.php">Logout</a></li>';
			      echo '<li><a href="https://www.post2dost.com/viewprofile.php">View Profile</a></li>';
			      echo '<li><a href="https://www.post2dost.com/editprofile.php">Edit Profile</a></li>';
			        
			    }
			    ?>
                <li><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

<!--login for xs-->
<?php

if(isset($_SESSION['id']))
{
    echo '<div class="container cus-form-xs visible-xs">
  
    <label for="inputEmail3" class="col-sm-2 control-label"> Hello :'.$_SESSION['name'].'</label>

</div>';
    
}
else
{
    
?> <div class="container cus-form-xs visible-xs">
  <form id="login_form_xs" class="form-horizontal"  onsubmit="return submitdataXs();" method="POST">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
       <input type="text" placeholder="Email" class="form-control" name="usrnm"  >
              <span class="error" id="e_err_xs"></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
       <input type="password" placeholder="Password" class="form-control" name="pwd">
              <span class="error" id="p_err_xs"></span>
    </div>
  </div>
  <a href="https://www.post2dost.com/forgot.php" style="color:white"><span style="padding-left:85px;"></span>Forgot Password?</a>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <div class="checkbox">
        <label>
          <input type="checkbox"> Remember me
        </label>
      </div>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn btn-success">Sign in</button>
    </div>
  </div>
  </form>
</div>
<?php
};
?>

  


        <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide cus-carousel" data-ride="carousel">
      <!-- Indicators -->
      <ol class="carousel-indicators">
        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
        <li data-target="#myCarousel" data-slide-to="1" class=""></li>
        <li data-target="#myCarousel" data-slide-to="2" class=""></li>
    <!--    <li data-target="#myCarousel" data-slide-to="3"></li>
        <li data-target="#myCarousel" data-slide-to="4"></li>
        <li data-target="#myCarousel" data-slide-to="5"></li>
      -->
      </ol>
      <div class="carousel-inner" role="listbox">
        <div class="item active">
          <img class="first-slide" src="./Homepage-Post2Dost_files/1st.jpeg" alt="First slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Achieve your life goals</h2>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="second-slide" src="./Homepage-Post2Dost_files/2nd.jpeg" alt="Second slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Remember the important things in life</h2>
            </div>
          </div>
        </div>
        <div class="item">
          <img class="third-slide" src="./Homepage-Post2Dost_files/3rd.jpeg" alt="Third slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Preserve your thoughts and ideas</h2>
            </div>
          </div>
        </div>
      </div>
 <!--       <div class="item">
          <img class="third-slide" src="Carousel-image/4th.jpeg" alt="Fourth slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Get reminders in the future</h2>
            </div>
          </div>
        </div>
      </div>
        <div class="item">
          <img class="third-slide" src="Carousel-image/5th.jpeg" alt="Fifth slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Your messages are safe with us</h2>
            </div>
          </div>
        </div>
      </div>
        <div class="item">
          <img class="third-slide" src="Carousel-image/6th.jpeg" alt="Sixth slide">
          <div class="container">
            <div class="carousel-caption">
              <h2>Get your messages delivered via Letters</h2>
            </div>
          </div>
        </div>
      -->
      </div>
      <a class="left carousel-control " href="http://www.post2dost.com/#myCarousel" role="button" data-slide="prev">
        <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="right carousel-control" href="http://www.post2dost.com/#myCarousel" role="button" data-slide="next">
        <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    <!-- /.carousel -->



<div class="panel panel-default z-top">
  <div class=" panel panel-primary center-block why-us"><h3>Why Us?</h3></div>
  <div class="panel-heading">
    <h3 class="panel-title">Schedule your Letter</h3>
  </div>
  <div class="panel-body">
    Here you can schedule your letter at your desired date to the desired one.
  </div>
  <div class="panel-heading">
    <h3 class="panel-title">Heart to heart secure connection.</h3>
  </div>
  <div class="panel-body"><h3 class="panel-title">No compromise on expressing your thought and feeling.</h3>
  </div>
  <div class="panel-heading">
    <h3 class="panel-title">Customize your letter easily and smartly.</h3>
  </div>
  <div class="panel-body">
    <h3 class="panel-title">Make your own interactive diary.</h3>
  </div>
  <div class="panel-heading"><h3 class="panel-title">Capture your daily thoughts and feelings effectively.</h3>
  </div>
  <div class="panel-body">
    <h3 class="panel-title">Add text image or even pdf.</h3>
  </div>
</div>

<div class="container-fluid subs text-center">
  <div class="row">
      <div class="col-md-6 col-xs-12 form-group subs-col">
        <h2>Follow us</h2>
          <a href="https://www.facebook.com/post2dost">@facebook</a><br>
          <a href="https://plus.google.com/112792994118406364550">@google+</a><br>
          <a href="https://twitter.com/post2dost">@twitter</a><br>
          <a href="https://www.linkedin.com/company/post2dost">@linkedIn</a>
      </div>
      <div class="col-md-3 col-xs-6 col-md-offset-0 col-xs-offset-3 form-group text-center clearfix">
        <h2>Subscribe Us</h2>
            <form action="index.php" method="POST">
               <input class="form-control" type="email" name="mail" placeholder="Email" value="<?php echo $mail;?>">
  <span class="error"><?php echo $mailErr;?></span>
                <input type="submit" class="btn btn-warning">
            </form>
      </div>
  </div>
</div>


<footer class="panel foot"><h6 class="foot-text text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>



  
<?php
session_write_close();
?>


<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- CAROUSEL Placed at the end of the document so the pages load faster -->
    <script src="./bootstrap-3/jquery.min.js.download"></script>
    <script>window.jQuery || document.write('<script src="./bootstrap-3/jquery.min.js"><\/script>')</script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./bootstrap-3/ie10-viewport-bug-workaround.js.download"></script>






</body></html>