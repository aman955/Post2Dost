<?php 
session_start();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>DashBoard</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  


	<!-- Include stylesheet -->
	<link href="https://cdn.quilljs.com/1.2.6/quill.snow.css" rel="stylesheet">
	
<!--<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.css' />
<script src='https://cdn.jsdelivr.net/momentjs/2.18.1/moment.min.js'></script>
<script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.js'></script>

<script src="https://fullcalendar.io/js/fullcalendar-2.1.1/lib/jquery-ui.custom.min.js"></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/lib/moment.min.js'></script>
<script src='https://fullcalendar.io/js/fullcalendar-2.1.1/fullcalendar.min.js'></script>-->

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


</head>


<body style="background-color: #34577a;" onload="loadEditor();search();content();">

	<nav class="navbar navbar-inverse">
	  <div class="container-fluid">
	    <div class="navbar-header">
		    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>
	        <span class="icon-bar"></span>                        
	     	</button>
		    <a class="navbar-brand" href="https://www.post2dost.com/"><span class="glyphicon glyphicon-home" title="Home"></span></a>
	    </div>

	<div class="collapse navbar-collapse" id="myNavbar">
	    <ul class="nav navbar-nav">
	      <p class="navbar-text" style="font-size: 1.15em;">DashBoard</p>
	    </ul>


		<ul class="nav navbar-nav navbar-right">

		    <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><img src="logo.jpg"  class="img-circle" width="30" height="30"></a>
		        <ul class="dropdown-menu">
		          <li><a href="viewprofile.php">View Profile</a></li>
		          <li><a href="editprofile.php">Edit Profile</a></li>
		          <li><a href="myletters.php">My Letters</a></li>
		          <li><a href="logout.php">Logout</a></li>
		        </ul>
	     	</li>
		</ul>

		</div>
	  </div>
	</nav>

	<div class="row">
		<div class="col-sm-3" style="border: 1px solid black; height: 40px;">
			<form style="border: 1px solid black; width: 105%;" onsubmit="return search();">
			  <div class="input-group">
			    <input type="text" class="form-control" placeholder="Get Inspired..." id="search_text">
			    <div class="input-group-btn">
			      <button class="btn btn-default" type="submit">
			        <i class="glyphicon glyphicon-search"></i>
			      </button>
			    </div>
			  </div>
			  
			</form>
		</div>

		<div class="col-sm-6" style="border: 1px solid black; height: 40px;">
			
			<p style="color: white; font-size: 1.5em;">Quote Of The Day</p>

		</div>

		<div class="col-sm-3" style="border: 1px solid black; height: inherit; height: 40px;">
			<p style="color: white; font-size: 1.5em;">Hello <?php echo $_SESSION['name'];?></p>

		</div>

	</div>


	<div class="row" style="top: 100px; border: 1px solid black; width: 100%; margin: 0px;">
		<div class="col-sm-3" style="border: 1px solid black; color: white; padding: 0;">

			<div style="border: 1px solid black; background-image: url('Calender.png'); background-size: contain; height: 440px; overflow:auto;">
			<form>
			<input type="radio" name="gender" id="search_diary" checked> Diary &emsp;
                <input type="radio" name="gender" id="search_letter"> Letter<br>
                </form>
                <span id="searchErr"></span>
			<ul id="inspiration">
			</ul>
			</div>
			

		</div>

		<div class="col-sm-6" style="border: 1px solid black; color: black; padding: 0; background-color: rgb(255,255,255);">
			
			<div style="border: 1px solid black;">
				<button class="btn-primary" style="align-self: left;" onclick="section='diary';loadEditor();">My Diary</button>
				<span style="margin-left: 220px;" id="head"></span>
				<button class="btn-primary" style="float: right;" onclick="section='letter';loadEditor();">My Letter</button>
			</div>


			<div id="form-container" class="container" style="max-width: 100%; height: inherit;">
				  <form id="form" method="post" onsubmit="return submitData();">
				    <div class="row form-group" >
				        <input id="heading" placeholder="Heading..." style="width:200px;">
				        <span id="headErr"></span>
				      <input name="about" type="hidden" >
				      <div id="editor-container" style="width: inherit; background-color: rgb(255,255,255); color: black; height: 350px;" >
				      </div>
				    </div>
				    <div class="row" overflow="hidden">

    				<div id="editor" style="border: 1px solid black;"></div>
    					<input id="save" class="btn btn-primary" style="float:left; left: 0px; margin-right:20px;" type="submit" onclick="clicked='save'" value="Save">
    					<input id="schedule" class="btn btn-primary" style="float:left; right: 0px; margin-right:20px;" type="submit" onclick="clicked='send'" value="Schedule">
    					<div id="saved" style="float: left"></div>
    					<div id="pub" style="float: right; margin-right:10px;"><input id="public" type="checkbox">Make Public</div>
				    </div>
				  </form>


				  <form action="uploadpdf.php" method="post" enctype="multipart/form-data">
	<input type="file" name="file" />
	<button type="submit" name="btn-upload">upload</button>
	</form>
    <br />
    <?php
	if(isset($_GET['success']))
	{
		?>
        <label>File Uploaded Successfully...  <a href="viewpdf.php">click here to view pdf file.</a></label>
        <?php
	}
	else if(isset($_GET['fail']))
	{
		?>
        <label>Problem While File Uploading !</label>
        <?php
	}
	else
	{
		?>
        <label>Upload any PDF here.</label>
        <?php
	}
	?>









				  
			</div>


		</div>

		<div class="col-sm-3" style="border: 1px solid black; color: white; padding: 0;">


		<div style="border: 1px solid black; height: 300px;overflow:auto;">
			<form>
			My Content : <input type="radio" name="cont" onclick="my_cont='letter';content();" id="content_letter" checked> Letter &emsp;
                <input type="radio" name="cont" onclick="my_cont='diary';content();" id="content_diary"> Diary<br>
                </form>
                <span id="contentErr"></span>
                <ul id="content">
			</ul>
		</div>

		<div style="border: 1px solid black; height:200px;">

	
			


		</div>
	</div>



<footer class="panel foot" style="background-color: rgb(25,25,25); color: rgb(200,200,200);"><h6 class="text-center">Ⓒ copyrights reserved by Post2Dost.com</h6></footer>

<!--Add External Libraries - JQuery and jspdf-->
<script src="https://code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/0.9.0rc1/jspdf.min.js"></script>






<script type="text/javascript">
	

var doc = new jsPDF();
var specialElementHandlers = {
    '#editor': function (element, renderer) {
        return true;
    }
};

$('#cmd').click(function () {   
    doc.fromHTML($('#editor-container').html(), 15, 15, {
        'width': 170,
            'elementHandlers': specialElementHandlers
    });
    doc.save('solution.pdf');
});

// This code is collected but useful, click below to jsfiddle link.


</script>





	<!-- Include the Quill library -->
		<script src="https://cdn.quilljs.com/1.2.6/quill.js"></script>



<script type="text/javascript">


	var quill = new Quill('#editor-container', {
  modules: {
    toolbar: [
  ['bold', 'italic', 'underline', 'strike'],        // toggled buttons
  ['blockquote', 'code-block'],

  [{ 'header': 1 }, { 'header': 2 }],               // custom button values
  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
  [{ 'script': 'sub'}, { 'script': 'super' }],      // superscript/subscript
  [{ 'indent': '-1'}, { 'indent': '+1' }],          // outdent/indent
  [{ 'direction': 'rtl' }],                         // text direction

  [{ 'size': ['small', false, 'large', 'huge'] }],  // custom dropdown
  [{ 'header': [1, 2, 3, 4, 5, 6, false] }],

  [{ 'color': [] }, { 'background': [] }],          // dropdown with defaults from theme
  [{ 'font': [] }],
  [{ 'align': [] }],

  ['clean'],                                         // remove formatting button
  ['image']								   // Add Image
]
  },
  placeholder: 'Write something...',
  theme: 'snow'
});

var section='diary';
var check;

function loadEditor()
{
    document.getElementById("head").textContent=section.toUpperCase();
    if(section=='diary')
    {
        var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January is 0!
var yyyy = today.getFullYear();
if(dd<10){
    dd='0'+dd;
} 
if(mm<10){
    mm='0'+mm;
}
var today = yyyy+'-'+mm+'-'+dd;
$.ajax({
 async: true,
  type: 'post',
  url: 'diaryHelper.php',
  data: {
   date:today
  },
  success: function (result) {
	if(result!=1)
	{
	    var data=JSON.parse(result);
	    check=data.pub;
		quill.setContents(JSON.parse(data.content));
		document.getElementById("heading").value=data.heading;
		
		 if(check==1) check=true;
     else check=false;
    document.getElementById("public").checked = check;
	}
	else
	{
	    quill.setText('');
	    document.getElementById("heading").value="";
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
 $("#schedule").hide();
 $("#save").show();
 $("#pub").show();
 
    }
    
    else
    {
        $.ajax({
 async: true,
  type: 'post',
  url: 'letterHelper.php',
  data: {
   action:"load"
  },
  success: function (result) {
	if(result!=1)
	{
	    var data=JSON.parse(result);
	    check=data.pub;
		quill.setContents(JSON.parse(data.content));
		document.getElementById("heading").value=data.heading;
		
		 if(check==1) check=true;
 else check=false;
 document.getElementById("public").checked = check;
	}
	else
	{
	    quill.setText('');
	    document.getElementById("heading").value="";
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
 $("#schedule").show();
 $("#pub").show();
 $("#save").show();
    }
    

}

var clicked;

function submitData()
{
    var head=document.getElementById("heading").value;
    if(head=="")
    {
        document.getElementById("headErr").textContent="Please provide a heading.";
        return false;
    }
    document.getElementById("headErr").textContent="";
    
    var x = document.getElementById("public").checked;
    if(x) x=1;
    else x=0;
    if(section=='diary')
    {
        	var page =  JSON.stringify(quill.getContents());
        	var pre=quill.getText(0,50);
	//alert(pre);
	$.ajax({
 async: true,
  type: 'post',
  url: 'diaryHelper.php',
  data: {
   text:page,
   pub:x,
   heading:head,
   preview:pre
  },
  success: function (result) {
	
	$('#saved').html('Saved.');
	
	setTimeout(function(){
         document.getElementById("saved").innerHTML="";
         },1000);
  },
  error: function() {
              alert('could not connect!!');
          }
 });
    }
    
    else
    {
        	var page =  JSON.stringify(quill.getContents());
        	var pre=quill.getText(0,50);
	//alert(page);
	$.ajax({
 async: true,
  type: 'post',
  url: 'letterHelper.php',
  data: {
   text:page,
   action:clicked,
   pub:x,
   heading:head,
   preview:pre
  },
  success: function (result) {
	
	$('#saved').html('Saved.');
	
	setTimeout(function(){
         document.getElementById("saved").innerHTML="";
         },1000);
		 
	if(result==1)
		location.href = "scheduleLetter.php";
  },
  error: function() {
              alert('could not connect!!');
          }
 });
    }
    
    return false;
}
</script>


<script>
    var data;
    function search()
    {
        $("#inspiration").empty();
        var q=document.getElementById("search_text").value;
        var s;
        if(document.getElementById("search_diary").checked)
        s="diary";
        else
        s="letters";
        $.ajax({
 async: true,
  type: 'post',
  url: 'searchHelper.php',
  data: {
   section:s,
   query:q
  },
  success: function (result) {
	if(result!=1)
	{
	    data=JSON.parse(result);
	    for(var key in data)
	    {
	        if(!data.hasOwnProperty(key)) continue;
	        var details=JSON.parse(data[key]);
	        var newItem = document.createElement("LI");
            newItem.setAttribute("onclick","loadInspiration("+key+");");
            var newHead = document.createElement("h4");
            var headnode = document.createTextNode(details.heading);
            newHead.appendChild(headnode);
            var textnode = document.createTextNode(details.preview);
            newItem.appendChild(newHead);
            newItem.appendChild(textnode);
            var list = document.getElementById("inspiration");
            list.insertBefore(newItem, list.childNodes[11]);
	    }
	    
	}
	else
	{
	    document.getElementById("searchErr").textContent="Nothing to show.";
	    setTimeout(function(){
         document.getElementById("searchErr").textContent="";
         },1000);
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
 
 return false;
    }
    
    function loadInspiration(k)
    {
        var details=JSON.parse(data[k]);
        document.getElementById("head").textContent="INSPIRATION";
        document.getElementById("heading").value=details.heading;
        quill.setContents(JSON.parse(details.content));
        $("#schedule").hide();
        $("#save").hide();
        $("#pub").hide();
        
    }
    
</script>

<script>
    var my_cont='letter';
    var mydata;
    
    function content()
    {
        $("#content").empty();
        
        $.ajax({
 async: true,
  type: 'post',
  url: 'contentHelper.php',
  data: {
   section:my_cont
  },
  success: function (result) {
	if(result!=1)
	{
	    document.getElementById("contentErr").textContent="";
	    mydata=JSON.parse(result);
	    for(var key in mydata)
	    {
	        if(!mydata.hasOwnProperty(key)) continue;
	        //alert(key);
	        var details=JSON.parse(mydata[key]);
	        var newItem = document.createElement("LI");
            newItem.setAttribute("onclick","loadContent("+key+");");
            var newHead = document.createElement("h4");
            var headnode = document.createTextNode(details.heading+" "+details.date);
            newHead.appendChild(headnode);
            var textnode = document.createTextNode(details.preview);
            newItem.appendChild(newHead);
            newItem.appendChild(textnode);
            var list = document.getElementById("content");
            list.insertBefore(newItem, list.childNodes[100]);
	    }
	    
	}
	else
	{
	    document.getElementById("contentErr").textContent="Nothing to show.";
	}
  },
  error: function() {
              alert('could not connect!!');
          }
 });
 
 return false;
    }
    
    function loadContent(k)
    {
        section=my_cont;
        var details=JSON.parse(mydata[k]);
        document.getElementById("head").textContent="MY CONTENT";
        document.getElementById("heading").value=details.heading;
        quill.setContents(JSON.parse(details.content));
        $("#pub").show();
        var check;
            if(details.pub==1) check=true;
 else check=false;
 document.getElementById("public").checked = check;
 
        if(my_cont=='letter')
        {
            $("#schedule").show();
        $("#save").show();
        
        
        $.ajax({
 async: true,
  type: 'post',
  url: 'letterHelper.php',
  data: {
   action:'content',
   letter_id:details.letter_id
  },
  success: function (result) {
  },
  error: function() {
              alert('could not connect!!');
          }
 });
        }
        else
        {
            $("#schedule").hide();
            $("#save").hide();
        }
    }
    
    
</script>

</body>
</html>
<?php session_write_close();
?>