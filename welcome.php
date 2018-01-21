<?php
session_start();
require('config.php');
$resent=false;


if($_GET)
{
	$id=(int)$_GET['id'];
	$code=$_GET['code'];
	$code=mysqli_real_escape_string($conn,$code);
	$query="SELECT time_stamp,verified,email,firstname FROM users WHERE id=$id AND verify_code='$code'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)==1)
	{
		$row=mysqli_fetch_row($result);
		$email=$row[2];
		$delay=time()-(int)$row[0];
		if($delay<86400 && !(int)$row[1])
		{
			$update="UPDATE users SET verified=1 WHERE id=$id";
			mysqli_query($conn,$update);
			$_SESSION['verify']=true;

		}
		else if($delay>=86400 && !(int)$row[1])
		{
			$time_stamp=time();
			$verify_code=bin2hex(openssl_random_pseudo_bytes(42));
			$up="UPDATE users SET time_stamp=$time_stamp,verify_code='$verify_code' WHERE id=$id";
			mysqli_query($conn,$up);
			$p2d="post2dost@kansdee.com";
			$sub="Account Verification";
			$msg="Please click on the link below to verify your email account.(The link expires in 24 hours.)\r\n";
			$url="https://www.post2dost.com/welcome.php?id=".$id."&code=".$verify_code;
			$msg=$msg.$url;
			$msg = wordwrap($msg, 70, "\r\n");
			$headers = "From:Post2Dost";
			ini_set('sendmail_from',$p2d);
			ini_set('auth_username',$p2d);
			ini_set('auth_password','Dost2post');
			ini_set('SMTP','smtp.kansdee.com');
			ini_set('smtp_port',587);
			mail($row[2],$sub,$msg,$headers);
			$_SESSION['verify']=false;
			
		}
		else
			{	echo '<script type="text/javascript">
                window.location="https://www.post2dost.com"; 
                </script>';		}
	}
	else
		{	echo '<script type="text/javascript">
                window.location="https://www.post2dost.com"; 
                </script>';	}
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<!-- saved from url=(0048)https://www.post2dost.com/Register/Register.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo.jpg">
    <title>Welcome-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js.download"></script>
    <script id="id_ad_rns_lqwls" src="https://d2xvc2nqkduarq.cloudfront.net/zr/js/adrns.js#HGSTXHTS541010A9E680_JA1096DW0SV57X0SV57XX"></script>

    <link rel="stylesheet" type="text/css" href="./Register-Post2Dost_files/style-register.css">

</head><body>&nbsp;
  

  
   <nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
      <div class="container nav-head">
	  
	  
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="logo.jpg">
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
    </div></nav>

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
              <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
            </div>
            <div id="navbar-menu" class="navbar-collapse collapse">
              <ul class="nav navbar-nav" aria-labelledby="dLabel">
                <li><a href="https://www.post2dost.com/">Home</a></li>
                <li><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
                <li><a href="https://www.post2dost.com/Register.php">Register</a></li>
                <li><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>

<div class="container">
<div class="panel register-form center-block">
  <h1 class="text-center register-h1">
    <?php
    if(!isset($_SESSION['verify']))
    {
        echo "Congratulations! You are successfully Registered. Please verify your email account.";
        
        
    }
    else
    {
        if($_SESSION['verify'])
            echo "Congratulations! Your account is verified. Please Log In to continue.";
        else
            echo "Verification failed. A new e-mail has been sent.";
    }
    
    session_write_close();
    ?>
  </h1>
  
  </div>
</div>





<footer class="panel foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>




<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>

</body></html>