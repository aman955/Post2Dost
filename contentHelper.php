<?php
session_start();
include 'config.php';

if($_POST['section']=='letter')
{
	$id=$_SESSION['id'];
	$query="SELECT heading,preview,content,deliver,letter_id,public FROM letters WHERE user_id=$id AND email <> '' ORDER BY deliver ASC";
	$result=mysqli_query($conn,$query);
	$n1=mysqli_num_rows($result);
	$content=array();
	$j=1;
	if($n1>0)
	{		
		for($i=1;$i<=$n1;$i++)
		{
			$row=mysqli_fetch_row($result);
			if(strtotime($row[3])-time()>30*24*60*60 || strtotime($row[3])-time()<0) continue;
			$temp=array();
			$temp['heading']=$row[0];
			$temp['preview']=$row[1];
			$temp['content']=$row[2];
			$temp['date']=$row[3];
			$temp['letter_id']=$row[4];
			$temp['pub']=$row[5];
			$content[$j++]=json_encode($temp);
		}
	}
	$query="SELECT heading,preview,content,letter_id,public FROM letters WHERE user_id=$id AND email=''";
	$result=mysqli_query($conn,$query);
	$n2=mysqli_num_rows($result);
	if($n2>0)
	{
		for($i=1;$i<=$n2;$i++)
		{
			$row=mysqli_fetch_row($result);
			$temp=array();
			$temp['heading']=$row[0];
			$temp['preview']=$row[1];
			$temp['content']=$row[2];
			$temp['date']="";
			$temp['letter_id']=$row[3];
			$temp['pub']=$row[4];
			$content[$j++]=json_encode($temp);
		}		
	}
	if($j==1)
		echo 1;
	else
		echo json_encode($content);
}
else if($_POST['section']=='diary')
{
	$id=$_SESSION['id'];
	$query="SELECT heading,preview,content,date,public FROM diary WHERE user_id=$id ORDER BY date ASC";
	$result=mysqli_query($conn,$query);
	$n=mysqli_num_rows($result);
	$content=array();
	if($n>0)
	{
		for($i=1;$i<=$n;$i++)
		{
			$row=mysqli_fetch_row($result);
			$temp=array();
			$temp['heading']=$row[0];
			$temp['preview']=$row[1];
			$temp['content']=$row[2];
			$temp['date']=$row[3];
			$temp['pub']=$row[4];
			$content[$i]=json_encode($temp);
		}
		echo json_encode($content);
	}
	else
		echo 1;
}

mysqli_close($conn);
session_write_close();
?>