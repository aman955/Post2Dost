
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
    <title>FAQ-Post2Dost</title>
    <link href="./bootstrap-3/bootstrap.min.css" rel="stylesheet">
    <link href="./bootstrap-3/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./bootstrap-3/jumbotron.css" rel="stylesheet">
    <link href="./bootstrap-3/carousel.css" rel="stylesheet">
    <script src="./bootstrap-3/ie-emulation-modes-warning.js"></script>
    <link rel="stylesheet" type="text/css" href="./FAQ-Post2Dost_files/style-faq.css">
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
                <input type="checkbox" name="rememberme" id="rememberme" value="true"> Remember me
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
              <a class="navbar-brand" href="https://www.post2dost.com">Post2Dost</a>
            </div>
            <div id="navbar-menu" class="navbar-collapse collapse">
              <ul class="nav navbar-nav" aria-labelledby="dLabel">
                <li><a href="https://www.post2dost.com">Home</a></li>
                <li><a href="https://www.post2dost.com/About.php">About us</a></li>
                <li class="active"><a href="https://www.post2dost.com/FAQ.php">FAQ</a></li>
                	<?php
				if(!isset($_SESSION['id']))
                echo '<li><a href="https://www.post2dost.com/Register.php">Register</a></li>';
			else 
				 echo '<li><a href="https://www.post2dost.com/logout.php">Logout</a></li>';
			 ?>
                <li><a href="https://www.post2dost.com/Contact-us.php">Contact us</a></li>
              </ul>
            </div>
          </div>
        </nav>
      </div>
    </div>




<div class="panel panel-default z-top">
  <div class=" panel panel-primary text-center faq"><h3>Frequently asked Questions</h3></div>

  <div class="panel-heading">
    <h3 class="panel-title">Q What is Post2Dost ?</h3>
  </div>
  <div class="panel-body">A Post2Dost is a future mailing website that allows user to schedule and send your letters, birthdays and anniversary cards to your friends and your loved ones. The main feature is to allow you to write a digital letter, Customize in any way (easily and smartly) and schedule it to your desired ones.  You can send letters via post and also through email.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Will I get notified when I am sending or receiving letters?</h3>
  </div>
  <div class="panel-body">A  Yes, your Post2Dost calendar will be updated every day showing you the upcoming events of that month and you’ll get more details about the nearby events through the notification bar.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q How does Post2Dost can help me?</h3>
  </div>
  <div class="panel-body">A Post2Dost helps you in sending your digitally typed letters to your friends and your loved ones through post or e-mail irrespective  of your location. You just have to type and schedule your letters and we will send them to your loved ones.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q How can I ensure that my letters are safe?</h3>
  </div>
  <div class="panel-body">A Question to be answered.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Where are the letters stored until they are sent?</h3>
  </div>
  <div class="panel-body">A Question to be answered.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q What does a PRIVATE,ANONYMOUS or PUBLIC letter mean?</h3>
  </div>
  <div class="panel-body">A If you have marked that the letter is "Private", this means that the text will not be published anywhere.Only the recipient can read this letter at the scheduled address and time. However, many people like to share their memories with others. In such a case you only have to mark that the letter is "Public" and the entire world will be able to read it.
  If you want to share your thoughts with others without revealing your identity then you can mark the letter as “ANONYMOUS”.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q What is the period for sending letters to the future?</h3>
  </div>
  <div class="panel-body">A  E-mails and letters may be sent within a period of 1 month to 10 years.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q How much does it cost to send a letter?</h3>
  </div>
  <div class="panel-body">A It does not cost anything to send an e-mail, it is free of charge. Attachment of a photo to an e-mail is also free of charge.
Also - it does not cost anything to save your letter digitally on the website
Sending of a paper letter costs XXX amount. The amount can be paid via abc ,  xxx.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q When do I have pay for the letter?
</h3>
  </div>
  <div class="panel-body">A You can make payement anytime you want but at least 15 days before the scheduled date.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q In case the address of the addressee changes, how can I change it?
</h3>
  </div>
  <div class="panel-body">A Yes, we understand that the residential address and e-mail address may change. In such cases write to us at post2dost@gmail.com Our employees will change the address manually and you will receive the letter at the new address.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q What if address of receiver gets changed?
</h3>
  </div>
  <div class="panel-body">A In that case we will contact the sender, and will ask him/her to update the address and other details. We’ll wait till your response and will make sure that the letter goes to the right hand.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Can I prefer timing of sending mails?
</h3>
  </div>
  <div class="panel-body">A At  present the feature of time preference is not available. But you can ask us to do so by mailing us  at post2dost@gmail.com and we will definitely consider your request.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Can I reschedule or change details of my sent letter?
</h3>
  </div>
  <div class="panel-body">A Yes you can change any details of your send letter atmost 15 days before the scheduled date.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q What  type of letter should I prefer, e-mail or post?
</h3>
  </div>
  <div class="panel-body">A Question to be answered.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q How many letters I can send?
</h3>
  </div>
  <div class="panel-body">A The number of letters is not limited. You can send as many letters as you want.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Can I attach a photo to a letter?
</h3>
  </div>
  <div class="panel-body">A Yes, you can attach a photo to your letters and also to your e-mail. The maximum size of a photo is 2MB. It will be sent together with your letter or mail.
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q Can I send my letters abroad?
</h3>
  </div>
  <div class="panel-body">A This feature is coming soon in Post2Dost, but if your letter is too post dated then you can send it(more than 3 years).
  </div>

  <div class="panel-heading">
    <h3 class="panel-title">Q I have a question, but I cannot find an answer to it?
</h3>
  </div>
  <div class="panel-body">A Write a question directly to us at: post2dost@gmail.com . Also, you may write it on our Facebook or twiiter page. We will answer you in a period of 24 hrs.
  </div>
</div>


<footer class="panel foot"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>

</body>


<script type="text/javascript" src="./bootstrap-3/jquery-3.1.1.min.js.download"></script>
<script type="text/javascript" src="./bootstrap-3//bootstrap.min.js.download"></script>
</html>