#!/usr/bin/php
<?php
session_start();
require('config.php');
date_default_timezone_set('Asia/Kolkata');
$date= date("Y-m-d");
$hour=(int)date("H");
$query= "SELECT letter_id,email,user_id FROM letters WHERE deliver='$date' AND time=$hour";
$result = mysqli_query($conn, $query);
//echo mysqli_num_rows($result);
 if(true)
    {
       while($row = mysqli_fetch_row($result))
       {
           $lid=$row[0];
           $email=$row[1];
           $id=$row[2];
           $code=$row[3];
           $q= "SELECT firstname,lastname FROM users WHERE id=$id";
           $res=mysqli_query($conn, $q);
           $r=mysqli_fetch_row($res);
           $name=$r[0]." ".$r[1];
           $code=bin2hex(openssl_random_pseudo_bytes(42));
           $q="UPDATE letters SET code='$code' WHERE letter_id=$lid";
           mysqli_query($conn, $q);
				$p2d="post2dost@kansdee.com";
				$sub="Message from ".$name;
				$msg="Click on the link below to see the message.\r\n";
				$url="https://www.post2dost.com/showLetter.php?lid=".$lid."&code=".$code;
				$msg=$msg.$url;
				//$msg = wordwrap($msg, 70, "\r\n");
				$headers = "From:Post2Dost";
				ini_set('sendmail_from',$p2d);
				ini_set('auth_username',$p2d);
				ini_set('auth_password','Dost2post');
				ini_set('SMTP','smtp.kansdee.com');
				ini_set('smtp_port',587);
				mail($email,$sub,$msg,$headers);
        }
}
?>