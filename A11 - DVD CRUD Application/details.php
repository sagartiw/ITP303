<?php
// Check that dvd_title_id has been passed.
if(!isset($_GET["dvd_title_id"]) || empty($_GET["dvd_title_id"])) {
	$error = "Invalid DVD Title ID.";
}
else {
	// A DVD id is given so continue to connect to the DB.
	$host = "303.itpwebdev.com";
	$user = "sagartiw_db_user";
	$password = "ThisIsMyUSC1.";
	$db = "sagartiw_dvd_db";

	// DB Connection
	$mysqli = new mysqli($host, $user, $password, $db);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	$mysqli->set_charset('utf8');

	// Generate a SQL statement to get details of the specific song
	$sql = "SELECT d.title AS title, d.release_date AS release_date, d.award AS award, 
	l.label AS label, s.sound AS sound, g.genre AS genre, r.rating AS rating, f.format AS format
	FROM dvd_titles d
	LEFT JOIN labels l
		ON d.label_id = l.label_id
	LEFT JOIN sounds s
		ON d.sound_id = s.sound_id
	LEFT JOIN genres g
		ON d.genre_id = g.genre_id
	LEFT JOIN ratings r
		ON d.rating_id = r.rating_id
	LEFT JOIN formats f
		ON d.format_id = f.format_id
	WHERE dvd_title_id =" . $_GET["dvd_title_id"]  . ";";

	// Submit the query!
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

	// We only get ONE result back about ONE song so no need to run a while loop to get all the results
	$row = $results->fetch_assoc();

	$mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Details | DVD Database</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>

	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item"><a href="search_results.php">Results</a></li>
		<li class="breadcrumb-item active">Details</li>
	</ol>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Details</h1>
		</div> <!-- .row -->
	</div> <!-- .container -->

	<div class="container">

		<div class="row mt-4">
			<div class="col-12">
				<?php if( isset($error) && !empty($error)):?>				
					<div class="text-danger font-italic">
						<?php echo $error; ?>
					</div>
				<?php else: ?>
								
					<table class="table table-responsive">
						<tr>
							<th class="text-right">Title:</th>
							<td><?php echo $row["title"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Release Date:</th>
							<td><?php echo $row["release_date"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Genre:</th>
							<td><?php echo $row["genre"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Label:</th>
							<td><?php echo $row["label"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Rating:</th>
							<td><?php echo $row["rating"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Sound:</th>
							<td><?php echo $row["sound"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Format:</th>
							<td><?php echo $row["format"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Award:</th>
							<td><?php echo $row["award"]; ?></td>
						</tr>
					</table>

				<?php endif;?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_results.php" role="button" class="btn btn-primary">Back to Search Results</a>

				<a href="edit_form.php?dvd_title_id=<?php echo $_GET['dvd_title_id'] ?>&dvd_name=<?php echo $row['title']?>" class="btn btn-warning">Edit This Track</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>