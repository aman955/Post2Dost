<?php
session_start();
include 'config.php';

if(isset($_POST['date']))
{
	$id=$_SESSION['id'];
	$date=$_POST['date'];
	$_SESSION['date']=$date;
	
	$query="SELECT content,public,heading FROM diary WHERE user_id=$id AND date='$date'";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)==1)
	{
		$row=mysqli_fetch_row($result);
		$_SESSION['saved']=true;
		$result=array();
		$result['content']=$row[0];
		$result['pub']=$row[1];
		$result['heading']=$row[2];
		
		echo json_encode($result);
	}
	else
	{
		$_SESSION['saved']=false;
		$_SESSION['public']=0;
		echo 1;
	}
}

else if(isset($_POST['text']))
{
    $preview=$_POST['preview'];
    $heading=$_POST['heading'];
    $pub=(int)$_POST['pub'];
	$id=$_SESSION['id'];
	$date=$_SESSION['date'];
	$text=mysqli_real_escape_string($conn,$_POST['text']);
	$preview=mysqli_real_escape_string($conn,$preview);
	$heading=mysqli_real_escape_string($conn,$heading);
	if($_SESSION['saved'])
	{
		$query="UPDATE diary SET content='$text',public=$pub,heading='$heading',preview='$preview' WHERE user_id=$id AND date='$date'";
		mysqli_query($conn,$query);
	}
	else
	{
		$insert="INSERT INTO diary (user_id,content,date,public,heading,preview) VALUES ({$id},'{$text}','{$date}',{$pub},'{$heading}','{$preview}')";
		mysqli_query($conn,$insert);
		$_SESSION['saved']=true;
	}
}

mysqli_close($conn);
session_write_close();
?>
