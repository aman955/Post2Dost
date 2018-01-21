<?php
session_start();
include 'config.php';

if($_POST['action']=="load")
{
	$id=$_SESSION['id'];
	
	$query="SELECT content,public,heading,letter_id FROM letters WHERE user_id=$id AND email=''";
	$result=mysqli_query($conn,$query);
	if(mysqli_num_rows($result)>0)
	{
		$row=mysqli_fetch_row($result);
		$_SESSION['saved']=true;
		$_SESSION['letter_id']=$row[3];
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

else if($_POST['action']=="content")
{
    $_SESSION['letter_id']=$_POST['letter_id'];
    $_SESSION['saved']=true;
}

else
{
    $preview=$_POST['preview'];
    $heading=$_POST['heading'];
    $pub=(int)$_POST['pub'];
	$id=$_SESSION['id'];
	$text=mysqli_real_escape_string($conn,$_POST['text']);
	$preview=mysqli_real_escape_string($conn,$preview);
	$heading=mysqli_real_escape_string($conn,$heading);
	if($_SESSION['saved'])
	{
	    $lid=(int)$_SESSION['letter_id'];
		$query="UPDATE letters SET content='$text',public=$pub,heading='$heading',preview='$preview' WHERE user_id=$id AND letter_id=$lid";
		mysqli_query($conn,$query);
	}
	else
	{
		$insert="INSERT INTO letters (user_id,content,public,email,scheduled,deliver,heading,preview) VALUES ({$id},'{$text}',{$pub},'','','','{$heading}','{$preview}')";
		mysqli_query($conn,$insert);
		$_SESSION['saved']=true;
	}
	
	if($_POST['action']=='send')
		echo 1;
	else
		echo 2;
}

mysqli_close($conn);
session_write_close();
?>
