<h1 align='center'> Profile Details</h1><br>


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
            $firstname="Not Updated";
			$lastname="Not Updated";
			$email="Not Updated";
			$gender ="Not Updated";
			$contactno= "Not Updated";
			$address = "Not Updated";
			$dob = "Not Updated";
			

$id=$_SESSION['id'];
$query = "select firstname,lastname,email,gender from users where id= '$id' ";
			
			$res = mysqli_query($conn,$query) or die("wrong query");
			
			$row = mysqli_fetch_assoc($res);
			$firstname=$row['firstname'];
			$lastname=$row['lastname'];
			$email=$row['email'];
			if($row['gender']!="")
			$gender =$row['gender'];
			
			$quer = "select dob,contactno,address from user_data where id= '$id' ";
			
			$resi = mysqli_query($conn,$quer) or die("wrong query");
			
			$rowi = mysqli_fetch_assoc($resi);
				if($rowi['contactno']!="")
			$contactno= $rowi['contactno'];
			if($rowi['dob']!="")
			$dob= $rowi['dob'];
				if($rowi['address']!="")
			$address = $rowi['address'];
			
?>
<h2>Full Name: <?php echo $firstname.' '.$lastname;?></h2>
<br>
<h2>Date of Birth: <?php echo $dob;?></h2>
<br>
<h2>Gender: <?php echo $gender;?></h2>
<br>
<h2>Email Id: <?php echo $email;?> </h2>
<br>
<h2>Contact Number: <?php echo $contactno;?></h2>
<br>
<h2>Address: <?php echo $address;?></h2>

