<?php
session_start();
include 'config.php';

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	$q=$_POST['query']; $q='%'.$q.'%';
	$table=$_POST['section'];
	$field="";
	if($table=='diary') $field='date';
	else $field='scheduled';
	
	$query="SELECT heading,preview,content FROM $table WHERE public=1 AND heading LIKE '$q' ORDER BY $field DESC";
	$result=mysqli_query($conn,$query);
	$num=mysqli_num_rows($result);
	if($num>0)
	{
		$search=array();
		if($num>10) $num=10;
		for($i=1;$i<=$num;$i++)
		{
			$row=mysqli_fetch_row($result);
			$temp=array();
			$temp['heading']=$row[0];
			$temp['preview']=$row[1];
			$temp['content']=$row[2];
			$search[$i]=json_encode($temp);
		}
		
		echo json_encode($search);
	}
	else
	{
		echo 1;
	}
}

mysqli_close($conn);
session_write_close();
?>