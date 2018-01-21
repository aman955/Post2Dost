
<?php
session_start();
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
    <title>About-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js"></script>
    <link rel="stylesheet" type="text/css" href="./About-us-Post2Dost_files/style-about-us.css">
</head>


   <?php
	if(isset($_SESSION['id']))
    {
	echo '<nav class="navbar navbar-inverse navbar-fixed-top page-head hidden-xs top-head">
      <div class="container nav-head">
	  Hello :'.$_SESSION['name'].'
        <div class="navbar-header pull-right">
          <a class="navbar-brand" href="https://www.post2dost.com/">Post2Dost</a>
          <img class="img-responsive navbar-logo" src="logo.jpg">
        </div>
        <div id="navbar" class="pull-left navbar-collapse collapse">
      </div>
    </div></nav>';
	}
	else
    {?> 
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
                <input type="checkbox" name="rememberme" id="rememberme" value="true"><a class="link-no-line text-white"> Remember me</a>
              </label>
              <a href="https://www.post2dost.com/forgot.php" style="color:white"><span style="padding-left:85px;"></span>Forgot Password?</a>
          </form>
      </div>
    </div>
</nav>;
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
  url: 'https://www.post2dost.com/logindb.php',
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
                <li class="active"><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
                <li><a href="https://www.post2dost.com/Register.php">Register</a></li>
                <li><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>
<!--
<!--login for xs-->
<!-- <div class="container cus-form-xs visible-xs">
  <form class="form-horizontal">
  <div class="form-group">
    <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
    <div class="col-sm-10">
      <input type="email" class="form-control" id="inputEmail3" placeholder="Email">
    </div>
  </div>
  <div class="form-group">
    <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
    <div class="col-sm-10">
      <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
    </div>
  </div>
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
</div> -->


<div class="container">
<div class="panel jumbotron">
    <div class=" panel panel-primary text-center faq"><h3 class="text-white">Our Team</h3></div>
    <div class="row pro-panel">
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Aditya Prakash Singh.jpg"></img>
      <h4 class="text-center">Aditya Prakash Singh</h4>
      <h5 class="text-center">Founder</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Shubhankar Sir.jpg"></img>
      <h4 class="text-center">Shubhankar Sir</h4>
      <h5 class="text-center">Designation</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Rahul Bhutani.jpg"></img>
      <h4 class="text-center">Rahul Bhutani</h4>
      <h5 class="text-center">Designation</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Mohak Maheshwari.jpg"></img>
      <h4 class="text-center">Mohak Maheshwari</h4>
      <h5 class="text-center">Designation</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Mayank.jpg"></img>
      <h4 class="text-center">Mayank Gupta</h4>
      <h5 class="text-center">Front-end Web Designer and Developer</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail : gupta.mayank417@gmail.com</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="https://www.facebook.com/mayank.gupta.417">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="https://www.linkedin.com/in/mayank-gupta-bb4699145/">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Himanshu Gupta.jpg"></img>
      <h4 class="text-center">Himanshu Gupta</h4>
      <h5 class="text-center">Back-End Web Developer</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail : hg24091996@gmail.com</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="https://www.facebook.com/himanshu.gupta.311493">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="https://www.linkedin.com/in/himanshu-gupta-3601b8115">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Aman Rathore.jpg"></img>
      <h4 class="text-center">Aman Rathore</h4>
      <h5 class="text-center">Designation</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
      </h6>
    </div>
    <div class="profile-container img-rounded">
      <img class="img-responsive img-rounded profile-img" src="About-us-Post2Dost_files/profile pics/Rajan Jaiswal.jpg"></img>
      <h4 class="text-center">Rajan Jaiswal</h4>
      <h5 class="text-center">Designation</h5>
      <h6 class="text-center" style="word-wrap: break-word">E-mail :</h6>
      <h6 class="text-center" style="word-wrap: break-word">
        <a target="_blank" href="#">Facebook</a>&ensp;&ensp;
        <a target="_blank" href="#">LinkedIn</a>
        </h6>
    </div>
  </div>
</div>
</div>

<div class="container">
  <div class="panel jumbotron">
    <div class=" panel panel-primary text-center faq">
      <h3 class="text-white">Work Culture</h3>
    </div>
    <div class="row quotes">
      <img class="img-responsive img-circle pull-left" src="About-us-Post2Dost_files/500x500.png">
      <blockquote class="blockquote-reverse clearfix blockquote-success">
        <p>A quote from a team member</p>
        <footer>
          Team Member
        </footer>
      </blockquote>
    </div>
    <div class="row quotes">
      <img class="img-responsive img-circle pull-right" src="About-us-Post2Dost_files/500x500.png">
      <blockquote class="blockquote clearfix blockquote-info">
        <p>A quote from a team member</p>
        <footer>
          Team Member
        </footer>
      </blockquote>
    </div>
    <div class="row quotes">
      <img class="img-responsive img-circle pull-left" src="About-us-Post2Dost_files/500x500.png">
      <blockquote class="blockquote-reverse clearfix blockquote-warning">
        <p>A quote from a team member</p>
        <footer>
          Team Member
        </footer>
      </blockquote>
    </div>
    <div class="row quotes">
      <img class="img-responsive img-circle pull-right" src="About-us-Post2Dost_files/500x500.png">
      <blockquote class="blockquote clearfix blockquote-danger">
        <p>A quote from a team member</p>
        <footer>
          Team Member
        </footer>
      </blockquote>
    </div>
  </div>
</div>

<div class="container-fluid">
  <div class="jumbotron text-center group-panel panel">
    <img classs="img-responsive img-rounded" src="About-us-Post2Dost_files/500x300.png">
    <img classs="img-responsive img-rounded" src="About-us-Post2Dost_files/500x300.png">
    <img classs="img-responsive img-rounded" src="About-us-Post2Dost_files/500x300.png">
  </div>
</div>


<footer class="panel foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>


</body>


<!-- Java script-->

<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3/bootstrap.min.js.download"></script>
<script type="text/javascript">
$('#myModal').on('shown.bs.modal', function () {
  $('#myInput').focus()
})
</script>
</html>