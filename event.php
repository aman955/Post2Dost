<?php
	require 'config.php';
	isset($_SESSION['id']) ? '' : header('location:index.php');
	$time = strtotime("$_GET[day]-" . "$_GET[month]-" . "$_GET[year]");
	$date = date('Y-m-d', $time);
	$events = new Event($conn, $date);

	if ( isset($_POST['submit']) ) {
		$events->set($conn, $date);
	}
	
	$eventlist = $events->daily;

?>
<!DOCTYPE html>
<html>
	<head>
		<title>My events</title>
		<link rel="stylesheet" href="css/style.css">
	</head>
	<body>
		<div class="container">
			<nav>
				<a href="<?php echo "home.php?year=$_GET[year]&month=$_GET[month]&day"; ?>">back</a>	
				<a href="logout.php">log out</a>
			</nav>
			<section id="add-event">
				<ul>
					<form method="post">
							<li>
								<label hidden="hidden" for="title">Title</label>
								<input name="title" type="text" placeholder="Enter a title" required="required">
							</li>
							<li>
								<label hidden="hidden" for="description">Description</label>
								<textarea name="description" placeholder="Enter a Description" required="required"></textarea>
							</li>
							<li>
								<label for="is_private">Share this event with other users?</label>
								<input name="is_private" id="is_private" type="checkbox">
							</li>
							<li>
								<label hidden="hidden" for="submit">Submit</label>
								<input name="submit" type="submit" value="Submit">
							</li>
					</form>
				</ul>
			</section>
			<section class="events">
				<?php foreach ($eventlist as $event => $info) : ?> 
					<div class="event-item">
						<h3><?php echo $info->title; ?></h3>
						<ul>
							<li>Description: <?php echo $info->body ?></li>
							<li>Date: <?php echo date('m-d-Y', strtotime($info->date)); ?></li>
						</ul>
						<?php if ( $info->user_id == $_SESSION['id']): ?>
							<a href="<?php echo "delete.php?postid=$info->id&id=$_SESSION[id]&userid=$info->user_id"; ?>">Delete Post</a>
						<?php endif ?>
					</div>
				<?php endforeach; ?>
			</section>
		</div>
	</body>
</html>