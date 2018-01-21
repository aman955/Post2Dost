
<?php
session_start();
require('config.php');
// define variables and set to empty values

$email = $pass="";
$_SESSION=array();
  $result=null;
  $ac=false;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["user_email"])) {
    $_SESSION['errors']['email'] = "Email is required";
  } else {
    $email = test_input($_POST["user_email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $_SESSION['errors']['email'] = "Invalid email format"; 
    }
	else{
		$email=mysqli_real_escape_string($conn,$email);
		$query="SELECT email FROM users WHERE email='$email'";
		$result=mysqli_query($conn,$query);
		$row=mysqli_fetch_row($result);
		if($row[0]==$email)
			$ac=true;
		else
			$_SESSION['errors']['email'] = "Email not registered."; 
	}
  }
    
  if (empty($_POST["user_pass"])) {
    $_SESSION['errors']['pass'] = "Password is required";
  } else {
    $pass = test_input($_POST["user_pass"]);
	if($ac)
	{
	    $pass=md5($pass);
		$pass=mysqli_real_escape_string($conn,$pass);
		$query="SELECT id,verified,firstname FROM users WHERE email='$email' and password='$pass'";
		$result=mysqli_query($conn,$query);
		if($row=mysqli_fetch_row($result))
		{
		    if(!(int)$row[1])
				echo 2;
			else
			{
			    
	$id=$row[0];
		$que = "INSERT INTO user_data (id) VALUES ('$id')";
	   	$resulti=mysqli_query($conn,$que);
				
        
				$_SESSION['id']=(int)$row[0];
				$_SESSION['name']=$row[2];
				echo 1;
			}
		}
		else
		{
			$_SESSION['errors']['pass'] = "Password is incorrect";
		}
	}
  }
  if(isset($_SESSION['errors'])){
	    //This is for ajax requests:
            if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
             }
  }
	
	
	session_write_close();
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

mysqli_close($conn);
?>