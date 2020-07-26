<?php
//The code in this file will actually add the new song to the database
if ( !isset($_POST['title']) || 
	empty($_POST['title']) ){
		$isInserted = False;
		echo "No Title Provided. Invalid Submission.";
}
else {
	require "config/config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
	}

	$mysqli->set_charset('utf8');
	// Handle all optional variables! Release date and award are dumped regardless.
	// Release Date
	if( isset($_POST["release_date"]) && !empty($_POST["release_date"])) {
		$release_date = "'" . $_POST["release_date"] . "'";
	}
	else {
		$release_date = "null";
	}
	// Label
	if( isset($_POST["label_id"]) && !empty($_POST["label_id"])) {
		$label = "'" . $_POST["label_id"] . "'";
	}
	else {
		$label = "null";
	}
	// Sound
	if( isset($_POST["sound_id"]) && !empty($_POST["sound_id"])) {
		$sound = "'" . $_POST["sound_id"] . "'";
	}
	else {
		$sound = "null";
	}
	// Genre
	if( isset($_POST["genre_id"]) && !empty($_POST["genre_id"])) {
		$genre = "'" . $_POST["genre_id"] . "'";
	}
	else {
		$genre = "null";
	}
	// Rating
	if( isset($_POST["rating_id"]) && !empty($_POST["rating_id"])) {
		$rating = "'" . $_POST["rating_id"] . "'";
	}
	else {
		$rating = "null";
	}
	// Format
	if( isset($_POST["format_id"]) && !empty($_POST["format_id"])) {
		$format = "'" . $_POST["format_id"] . "'";
	}
	else {
		$format = "null";
	}
	// Award
	if( isset($_POST["award"]) && !empty($_POST["award"])) {
		$award = "'" . $_POST["award"] . "'";
	}
	else {
		$award = "null";
	}

	// real_escape_string escapes special characters like single quote, double quote, etc
	$title = $mysqli->real_escape_string($_POST["title"]);

	// Write SQL to insert this record into the DB
	$sql = "INSERT INTO dvd_titles (title, release_date, label_id, sound_id, genre_id, rating_id, format_id, award) 
		VALUES('" . $title . "'," 
		. $release_date
		. ", "
		. $label
		. ", "
		. $sound
		. ", "
		. $genre
		. ", "
		.  $rating
		. ", "
		. $format
		. ", "
		. $award . ");";

	// Submit the query
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	// affected_rows returns the number of rows inserted, udpated, or deleted by the sql command
	//echo "Inserted: " . $mysqli->affected_rows;

	// Knowing the above info, can display a success message
	if($mysqli->affected_rows == 1) {
		$isInserted = true;
	}

	$mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add Confirmation | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="add_form.php">Add</a></li>
		<li class="breadcrumb-item active">Confirmation</li>
	</ol>
	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add a DVD</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if( isset($error) && !empty($error) ) :?>
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php endif;?>

				<?php if($isInserted) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST["title"]?></span> was successfully added.
					</div>
				<?php endif;?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="add_form.php" role="button" class="btn btn-primary">Back to Add Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>