<?php
include 'config.php';
$emailErr="";
if($_SERVER["REQUEST_METHOD"] == "POST")
{
	if(empty($_POST['email']))
		$emailErr= "Email is requred.";
	else
	{
		$email = test_input($_POST["email"]);
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) 
			$emailErr= "Invalid email format";
		else
		{
			$email=mysqli_real_escape_string($conn,$email);
			$query="SELECT email,verified,id FROM users WHERE email='$email'";
			$result=mysqli_query($conn,$query);
			$row=mysqli_fetch_row($result);
			if($row[0]==$email && (int)$row[1]==1)
			{
				$time_stamp=time();
				$verify_code=bin2hex(openssl_random_pseudo_bytes(42));
				$up="UPDATE users SET time_stamp=$time_stamp,verify_code='$verify_code' WHERE email='$email'";
				mysqli_query($conn,$up);
				$p2d="post2dost@kansdee.com";
				$sub="Change Password";
				$msg="Please click on the link below to change your password.(The link expires in 15 minutes.)\r\n";
				$url="https://www.post2dost.com/password.php?id=".$row[2]."&code=".$verify_code;
				$msg=$msg.$url;
				//$msg = wordwrap($msg, 70, "\r\n");
				$headers = "From:Post2Dost";
				ini_set('sendmail_from',$p2d);
				ini_set('auth_username',$p2d);
				ini_set('auth_password','Dost2post');
				ini_set('SMTP','smtp.kansdee.com');
				ini_set('smtp_port',587);
				mail($email,$sub,$msg,$headers);
				$emailErr="Link to reset password has been sent to your email.";
			}
			else
				$emailErr= "Email is not registered/verified";
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
<!-- saved from url=(0048)https://www.post2dost.com/Register/Register.html -->
<html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="logo.jpg">
    <title>Forgot Password-Post2Dost</title>
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
                <input type="checkbox" name="remember" value="true"> <a class="text-white link-no-line">Remember me</a>
              </label>
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
    Find Your Account
  </h1>
  <form class="form-horizontal" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" >
  
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email Id</label>
    <div class="col-sm-10">
 <input class="form-control" type="text" name="email" placeholder="Email">
  <span class="error"><?php echo $emailErr;?></span>
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button type="submit" class="btn-lg btn-primary col-xs-offset-4 col-md-offset-4"  name="submit" value="Submit">Verify</button>
    </div>
  </div>
  </form>
  </div>
</div>


<footer class="foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>




<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>

</body></html>