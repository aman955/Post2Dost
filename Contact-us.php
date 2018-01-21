<?php
session_start();
// define variables and set to empty values
//include 'config.php';

$firstnameErr = $lastnameErr = $emailErr =  $captchaErr= $messageErr="";
$firstname = $lastname= $email= $message= "";

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
    $email = test_input($_POST["email"]);
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format"; 
    }
	else {global $count; $count++;}
  }
  

if (empty($_POST["message"])) {
    $messageErr = "Message is required";
  } 
  
  else 
	   {
    $message = test_input($_POST["message"]);
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
    

		if($count==5)
{
                $gmail="post2dost@gmail.com";
                $p2d="post2dost@kansdee.com";
				$sub="Contact Us";
				$msg="Name: ".$firstname." ".$lastname."\n"."Email: ".$email."\n"."Message: ".$message;
				
				//$msg = wordwrap($msg, 70, "\r\n");
				$headers = "From:Post2Dost";
				ini_set('sendmail_from',$p2d);
				ini_set('auth_username',$p2d);
				ini_set('auth_password','Dost2post');
				ini_set('SMTP','smtp.kansdee.com');
				ini_set('smtp_port',587);
				mail($gmail,$sub,$msg,$headers);
				
	echo '<script type="text/javascript">
  window.location="https://www.post2dost.com"; 
</script>';			
	
}

}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

session_write_close();

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo.jpg">
    <title>Contact us-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js.download"></script>

    <link rel="stylesheet" type="text/css" href=".//Contact-us-Post2Dost_files/style-contact-us.css">
    <script src='https://www.google.com/recaptcha/api.js'></script>
  </head>

     <?php
	if(isset($_SESSION['id']))
	{
	echo '<nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
      <div class="container nav-head">
	  Hello :'.$_SESSION['name'].'
	  
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="./logo.jpg">
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
                <input type="checkbox" name="rememberme" id="rememberme" value="true"><a class="link-no-line text-white"> Remember me</a>
              </label>
              <a href="https://www.post2dost.com/forgot.php" style="color:white"><span style="padding-left:85px;"></span>Forgot Password?</a>
          </form>
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
<body>
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
              <a class="navbar-brand" href="http://www.post2dost.com">Post2Dost</a>
            </div>
            <div id="navbar-menu" class="navbar-collapse collapse">
              <ul class="nav navbar-nav" aria-labelledby="dLabel">
                <li><a href="https://www.post2dost.com">Home</a></li>
                <li><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
                <?php
				if(!isset($_SESSION['id']))
                echo '<li><a href="https://www.post2dost.com/Register.php">Register</a></li>';
			else 
				 echo '<li><a href="https://www.post2dost.com/logout.php">Logout</a></li>';
			 ?>
                <li class="active"><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

<div class="container">
<div class="panel feedback-form center-block">

  <h1 class="text-center register-h1">
     Contact Form
  </h1>
  <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">First Name*</label>
    <div class="col-sm-10">
      <input name="firstname" type="text" class="form-control" id="inputEmail3" placeholder="First Name">
      <span class="error"><?php echo $firstnameErr;?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Last Name*</label>
    <div class="col-sm-10">
      <input name="lastname" type="text" class="form-control" id="inputPassword3" placeholder="Last Name">
      <span class="error"><?php echo $lastnameErr;?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email Id*</label>
    <div class="col-sm-10">
      <input name="email" type="email" class="form-control" id="inputEmail3" placeholder="Email">
      <span class="error"><?php echo $emailErr;?></span>
    </div>
  </div>
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Message</label>
    <div class="col-sm-10">
      <input name="message" type="text" class="form-control" id="feedback" placeholder="Edit...">
      <span class="error"><?php echo $messageErr;?></span>
    </div>
  </div>
  <div class="g-recaptcha" data-sitekey="6LdTUCYUAAAAAFq-CtjWhypG1YpCTUZJlQ2sRpwy"></div>
  <span class="error"><?php echo $captchaErr;?></span>
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn-lg btn-primary col-xs-offset-4 col-md-offset-4">Submit</button>
    </div>
  </div>
  </form>
  </div>
</div>




<footer class="panel foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>

</body>


<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>
</html>
