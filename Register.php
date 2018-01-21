<?php
session_start();
// define variables and set to empty values

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



include 'config.php';

$firstnameErr = $lastnameErr = $emailErr = $passwordErr = $cpasswordErr= $captchaErr="";
$firstname = $lastname= $email= $password=  $cpassword = "";

$count=0;

if ($_SERVER["REQUEST_METHOD"] == "POST") 
{  
 
if (empty($_POST["firstname"]))
	  {
    $firstnameErr = "First name is required";
      }
	   else 
	   {
    $firstname = test_input($_POST["firstname"]);
	
	if(strlen($firstname)>30)
	{
	    $firstnameErr= "First Name can be of max 30 length";
	}
    else if (!preg_match("/^[a-zA-Z ]*$/",$firstname)) 
	{
      $firstnameErr = "Only letters and white space allowed"; 
    }
	else {global $count; $count++;}
  }
  
  

if (empty($_POST["lastname"]))
	  {
	      $lastnameErr = "Last name is required";
      }
	   else 
	   {
    $lastname = test_input($_POST["lastname"]);
	if(strlen($lastname)>30)
	{
	    $lastnameErr= "First Name can be of max 30 length";
	}
    else if (!preg_match("/^[a-zA-Z ]*$/",$lastname)) {
      $lastnameErr = "Only letters and white space allowed"; 
      }
	else {global $count; $count++;}
  }  
  
  if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } 
  
  else 
	   {
	       $email=mysqli_real_escape_string($conn,$email);
    $email = strtolower(test_input($_POST["email"]));
	  $search = "SELECT email FROM users WHERE email= '$email' ";
  
$result = mysqli_query($conn, $search);

$counti = mysqli_num_rows($result);

if($counti>0)
{
	$emailErr= "Email already exists";
}
  else {
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
	else {global $count; $count++;}
  }
	   }
  

  if (empty($_POST["password"])) 
  {
    $passwordErr = "Password is required";
  } else
	  {
    $password = test_input($_POST["password"]);
 
    if(!preg_match('/\A(?=[\x20-\x7E]*?[A-Z])(?=[\x20-\x7E]*?[a-z])(?=[\x20-\x7E]*?[0-9])[\x20-\x7E]{1,}\z/', $password)) 
	{
		$passwordErr= "The password must have atleast one number, one uppercase letter and one special symbol.";
	}
	else if(strlen($password)<8||strlen($password)>25)
	{
		$passwordErr = "Password must be of at least 8 characters long and at most 25 characters long";
	}
	else {global $count; $count++;}
  }
  
  if (empty($_POST["cpassword"])) 
  {
    $cpasswordErr = "Password's don't  match.";
  } 
  else 
  {
    $cpassword = test_input($_POST["cpassword"]);
  if($password!=$cpassword)
	  {
		$cpasswordErr= "Password's don't match";
	}
	else {global $count; $count++;}
  }
   if(!empty($_POST['gender']))
 {
 $gender = $_POST['gender'];
 global $count; $count++;
 } 




if(isset($_POST['g-recaptcha-response'])){
          $captcha=$_POST['g-recaptcha-response'];
        }
        if(!$captcha){
          $captchaErr= "Please check the the captcha";
        }
        else
        {
            $secretKey = "6LdTUCYUAAAAAGtXYALKmW1rQT1CxtlU-KzvMkCM";
            $ip = $_SERVER['REMOTE_ADDR'];
            $response=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$secretKey."&response=".$captcha."&remoteip=".$ip);
            $responseKeys = json_decode($response,true);
            
            if(intval($responseKeys["success"]) !== 1) {
            $captchaErr='You are a spammer !';
            }
            else {
                global $count; $count++;
            }
        }



 /* session_start();
        $_SESSION = $_POST;
        session_write_close();*/
    

		if($count==7)
{
    $password = md5($password);
    $time_stamp=(int)time();
	$verify_code=bin2hex(openssl_random_pseudo_bytes(42));
	$query = "INSERT INTO users (firstname, lastname,gender , email, password, time_stamp, verify_code, verified) VALUES ('$firstname', '$lastname','$gender', '$email' , '$password' , '$time_stamp' , '$verify_code' , 0 )";
	if(mysqli_query($conn, $query))
	{
                $_SESSION=array();
                $id=mysqli_insert_id($conn);
                $p2d="post2dost@kansdee.com";
				$sub="Account Verification";
				$msg="Please click on the link below to verify your email account.(The link expires in 24 hours.)\r\n";
				$url="https://www.post2dost.com/welcome.php?id=".$id."&code=".$verify_code;
				$msg=$msg.$url;
				//$msg = wordwrap($msg, 70, "\r\n");
				$headers = "From:Post2Dost";
				ini_set('sendmail_from',$p2d);
				ini_set('auth_username',$p2d);
				ini_set('auth_password','Dost2post');
				ini_set('SMTP','smtp.kansdee.com');
				ini_set('smtp_port',587);
				mail($email,$sub,$msg,$headers);
				
			
	echo '<script type="text/javascript">
  window.location="https://www.post2dost.com/welcome.php"; 
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

session_write_close();
mysqli_close($conn);

?>

<!DOCTYPE html>
<!-- saved from url=(0048)https://www.post2dost.com/Register/Register.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./Register-Post2Dost_files/logo.jpg">
    <title>Register-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js.download"></script>
    <script id="id_ad_rns_lqwls" src="https://d2xvc2nqkduarq.cloudfront.net/zr/js/adrns.js#HGSTXHTS541010A9E680_JA1096DW0SV57X0SV57XX"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
     <script>
       function onSubmit(token) {
         document.getElementById("demo-form").submit();
       }
     </script>
    <link rel="stylesheet" type="text/css" href="./Register-Post2Dost_files/style-register.css">
</head>

<body>&nbsp;
  

  
    <nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
      <div class="container nav-head">
	  
	  
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="./logo.jpg">
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
                <input type="checkbox" name="remember" value="true"> <a class="text-white link-no-line">Remember me</a>
              </label>
              <a href="https://www.post2dost.com/forgot.php" style="color:white"><span style="padding-left:85px;"></span>Forgot Password?</a>
          </form>
      </div>
    </div>
</nav>
    
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
 //alert(name);
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
		location.href = "https://www.post2dost.com";
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

</script>
  

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
              <a class="navbar-brand" href="https://www.post2dost.com">Post2Dost</a>
            </div>
            <div id="navbar-menu" class="navbar-collapse collapse">
              <ul class="nav navbar-nav" aria-labelledby="dLabel">
                <li><a href="https://www.post2dost.com/">Home</a></li>
                <li><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
                <li class="active"><a href="https://www.post2dost.com/Register.php">Register</a></li>
                <li><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

<div class="container">
<div class="panel register-form center-block">
    
<div class="row text-center">
  <form style="display: inline-block" action="http://www.fb.com">
    <button class="loginBtn loginBtn--facebook">
    Continue with Facebook
    </button>
  </form>
  
  
  
  
  
  
  
  
  
  
  
  
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
  
  
  
  
  
  
  
  
  
  
  
  
  

  </form>
</div>
<h4 class="text-center">or</h4>


  <h1 class="text-center register-h1">
  <?php
  	if(isset($_SESSION['id']))
	{
	    echo'<script type="text/javascript"> window.location="https://www.post2dost.com"; </script>';
    }
  	/*if(isset($_GET['error']))
	{
		echo '<font color="red">'.$_GET['error'].'</font>';
		echo '<br><br>';
	}
	if(isset($_GET['submit']))
	{
		echo '<font color="red"><h2>Congratulations You are successfully Registered..</h2></font>';
	}
	else
	{*/
	?>
  
    Register Here !
  </h1>
  <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
  
   
  <div class="form-group">
    <label class="col-sm-2 control-label">First Name*</label>
    <div class="col-sm-10">
       <input class="form-control" type="text" name="firstname" placeholder= "Firstname" value="<?php echo $firstname;?>">
  <span class="error"><?php echo $firstnameErr;?></span>
    </div>
  </div>
  
  <div class="form-group">
    <label class="col-sm-2 control-label">Last Name*</label>
    <div class="col-sm-10">
        <input class="form-control" type="text" name="lastname" placeholder= "Lastname" value="<?php echo $lastname;?>">
  <span class="error"> <?php echo $lastnameErr;?></span>
    </div>
  </div>
  
  <div class="form-group">
  <label class="col-sm-2 control-label">Gender*  </label>
    <div class="form-check">
      <label class="form-check-label">
        <input type="radio" class="form-check-input" name="gender" id="Radio1" value="male" checked="">
        Male
      </label>
    </div>
    <label class="col-sm-2 control-label">  </label>
    <div class="form-check">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="gender" id="Radio2" value="female">
        Female
      </label>
    </div>
    <label class="col-sm-2 control-label">  </label>
    <div class="form-check">
    <label class="form-check-label">
        <input type="radio" class="form-check-input" name="gender" id="Radio3" value="other">
        Other
      </label>
    </div>
  </div>

  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email Id*</label>
    <div class="col-sm-10">
 <input class="form-control" type="text" name="email" placeholder="Email" value="<?php echo $email;?>">
  <span class="error"><?php echo $emailErr;?></span>
    </div>
  </div>
  
  
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label has-error">Password*</label>
    <div class="col-sm-10">
<input class="form-control" type="password" name="password" placeholder="Password">
  <span class="error"><?php echo $passwordErr;?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Confirm Password*</label>
    <div class="col-sm-10">
       <input class="form-control" type="password" name="cpassword" placeholder="Confirm Password">
  <span class="error"><?php echo $cpasswordErr;?></span>
    </div>
  </div>
  <div class="form-group">
    <div class="col-sm-10">
      <div class="g-recaptcha" data-sitekey="6LdTUCYUAAAAAFq-CtjWhypG1YpCTUZJlQ2sRpwy"></div>
      <span class="error"><?php echo $captchaErr;?></span>
    </div>
  </div>
  
<p class="text-center">By signing up you indicate that you have read and agree to the <a href="https://www.post2dost.com/Register.php">Terms and Conditions</a> and <a href="https://www.post2dost.com/Register.php">Privacy Policy.</a></p><br>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn-lg btn-primary col-xs-offset-4 col-md-offset-4"  name="submit" value="Submit">Register</button>
    </div>
  </div>
  </form>
  </div>
</div>
    <?php //};
	?>
	<div id="my-signin2"></div>


  <script src="https://apis.google.com/js/platform.js?onload=renderButton" async defer></script>





<footer class="panel foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>




<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>

</body></html>