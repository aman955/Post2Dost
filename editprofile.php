<h1> Edit Your Profile</h1>


<?php
session_start();
include 'config.php';
if(!$_SESSION['id'])
{
   echo '<script type="text/javascript">
  window.location="https://www.post2dost.com"; 
</script>';
}

                                      
											


$dobErr = $addressErr=$contactnoErr= $passwordErr = $npasswordErr =  $cnpasswordErr= "";
$dob = $address = $contactno= $password=  $cnpassword = $npassword = "";

session_start();
$id=$_SESSION['id'];
$query = "select * from user_data where id= '$id' ";
			
			$res = mysqli_query($conn,$query) or die("wrong query");
			
			$row = mysqli_fetch_assoc($res);
			$query = "select * from user_data where id= '$id' ";
			
			$resi = mysqli_query($conn,$query) or die("wrong query");
			
			$rowi = mysqli_fetch_assoc($resi);
			$opass= $rowi['password'];
			
			if ($_SERVER["REQUEST_METHOD"] == "POST") 
{  
if (!empty($_POST["address"])) 
	   {
    $address = test_input($_POST["address"]);
	
    if (!preg_match("/^[a-z A-Z 0-9 ,@+. ]*$/", $address)) {
      $addressErr = "Only letters, numbers are allowed"; 
      }
      $query = "UPDATE user_data SET address='$address' WHERE id='$id' ";
	$res = mysqli_query($conn,$query) or die("wrong query");
	 $addressErr = "Address updated successfully!"; 
	   }




if(!empty($_POST['contactno']))
{
   $contactno = test_input($_POST["contactno"]);
	
    if (!preg_match('/^[0-9]{10}+$/', $contactno)) 
	{
      $contactnoErr = "Please enter a valid contact number of 10 digits."; 
    }
		else
{
	$query = "UPDATE user_data SET contactno='$contactno' WHERE id='$id' ";
	$res = mysqli_query($conn,$query) or die("wrong query");
	 $contactnoErr = "Contact Number updated successfully!"; 
	
}
	
	
}



if (!empty($_POST["dob"]))
{
    $dob = test_input($_POST["dob"]);

    if (!preg_match("/^[0-9]{4}-[0-9]{1,2}-[0-9]{1,2}$/",$dob))
		{
      $dobErr = "Date must comply with this mask: YYYY-MM-DD"; 
      }	
	  		else
{
	$query = "UPDATE user_data SET dob='$dob' WHERE id='$id' ";
	$res = mysqli_query($conn,$query) or die("wrong query");
	$dobErr = "Date Of Birth updated successfully!";
}

}


	   
	   if(!empty($_POST['password'])&&!empty($_POST['npassword'])&&!empty($_POST['cnpassword']))
	   {
		   $npassword=$_POST['npassword'];
		   $cnpassword = $_POST['cnpassword'];
		   
		if(md5($_POST['password'])==$opass)
		{
			
			if(!preg_match('/\A(?=[\x20-\x7E]*?[A-Z])(?=[\x20-\x7E]*?[a-z])(?=[\x20-\x7E]*?[0-9])[\x20-\x7E]{1,}\z/', $npassword)) 
	{
		$npasswordErr= "The password must have atleast one number, one uppercase letter and one special symbol.";
	}
	else if(strlen($npassword)<8||strlen($npassword)>25)
	{
		
		$npasswordErr = "Password must be of at least 8 characters long and at most 25 characters long ".$npassword;
	}
	else if($npassword!=$cnpassword)
	{
		$npasswordErr = "Password do not match";
	}
	else
	{
		$npassword = md5($npassword);
		$query = "UPDATE users SET password='$npassword' WHERE id='$id' ";
	$res = mysqli_query($conn,$query) or die("wrong query");
		$passwordErr = "Password changed Successfully.";
	}
		}
		else
			$passwordErr = "Incorrect current password.";
			
	   }
	   else
	   {
		   $passwordErr="Fill all the password fields to change password";
	   }
		   

	
}
function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}
?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">  

  <b>Contact Number: <?php echo  $row['contactno']; ?></b><br><br>
  Change Contact Number: <input type="text" name="contactno" value="<?php echo $contactno;?>">
  <span class="error"> <?php echo $contactnoErr;?></span>
  <br><br>
  

  <input type="submit" name="submit" value="submit">  
</form>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">  

  <b>Address: <?php echo  $row['address']; ?></b><br><br>
  Change Address: <input type="text" name="address" value="<?php echo $address;?>">
  <span class="error"> <?php echo $addressErr;?></span>
  <br><br>
  

  <input type="submit" name="submit" value="submit">  
</form>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">  

  <b>Date of Birth: <?php echo  $row['dob']; ?></b><br><br>
  Change Date of Birth: <input type="text" name="dob" value="<?php echo $dob;?>">
  <span class="error">Date Format : YYYY-MM-DD <?php echo $dobErr;?></span>
  <br><br>
  

  <input type="submit" name="submit" value="submit">  
</form>
<h3>Change password</h3>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?> ">  

  
  Current Password: <input type="password" name="password" value="<?php echo $password;?>">
  <span class="error"> <?php echo $passwordErr;?></span>
  <br><br>
  
  New Password: <input type="password" name="npassword" >
  <span class="error"><?php echo $npasswordErr;?></span>
  <br><br>
  
  Retype New Password: <input type="password" name="cnpassword">
  <span class="error"><?php echo $cnpasswordErr;?></span>
  <br><br>
  
  

  <input type="submit" name="Changepass" value="Change Password">  
</form>