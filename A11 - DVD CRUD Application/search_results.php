<?php
require "config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
}

$mysqli->set_charset('utf8');

//Starter SQL Statement
$sql = "SELECT d.dvd_title_id AS dvd_title_id, d.title AS title, d.release_date AS release_date, d.award AS award, g.genre AS genre, r.rating AS rating
			FROM dvd_titles d
			LEFT JOIN genres g
				ON d.genre_id = g.genre_id
			LEFT JOIN ratings r
				ON d.rating_id = r.rating_id
			WHERE 1=1";

//Parse Title
if ( isset($_GET['title']) && !empty($_GET['title']) ) {
	$sql = $sql . " AND d.title LIKE '%" . $_GET['title'] . "%'";
}
//Parse Genre
if ( isset($_GET['genre']) && !empty($_GET['genre']) ) {
	$sql = $sql . " AND g.genre LIKE '%" . $_GET['genre'] . "%'";
}
//Parse Rating
if ( isset($_GET['rating']) && !empty($_GET['rating']) ) {
	$sql = $sql . " AND d.rating LIKE '%" . $_GET['rating'] . "%'";
}
//Parse release_date_from and release_date_to
if ( (isset($_GET['release_date_from']) && !empty($_GET['release_date_from'])) ||
(isset($_GET['release_date_to']) && !empty($_GET['release_date_to'])) ) {
	$from = $_GET['release_date_from'];
	$to = $_GET['release_date_to'];
	$sql = $sql. " AND d.release_date IS NOT NULL";
	if (empty($from)){
		$sql = $sql. " AND d.release_date
		BETWEEN '0000-01-01' AND '$to'";
	}
	else if(empty($to)){
		$sql = $sql. " AND d.release_date
		BETWEEN '$from' AND '3000-01-01'";
	}
	else{
		$sql = $sql. " AND d.release_date
		BETWEEN '$from' AND '$to'";	
	}
}
//Parse award
if (isset($_GET['award']) && !empty($_GET['award'])) {
	if($_GET['award'] == "yes"){
		$sql = $sql. " AND d.award IS NOT NULL";
	}
	else if($_GET['award'] == "no"){
		$sql = $sql. " AND d.award IS NULL";
	}
}

$sql = $sql . ";";
$results = $mysqli->query($sql);
if ( $results == false ) {
	echo $mysqli->error;
	exit();
}
// Close DB Connection.
$mysqli->close();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>DVD Search Results</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
</head>
<body>
	<ol class="breadcrumb">
		<li class="breadcrumb-item"><a href="index.php">Home</a></li>
		<li class="breadcrumb-item"><a href="search_form.php">Search</a></li>
		<li class="breadcrumb-item active">Results</li>
	</ol>
	<div class="container-fluid">
		<div class="row">
			<h1 class="col-12 mt-4">DVD Search Results</h1>
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
	<div class="container-fluid">
		<div class="row mb-4">
			<div class="col-12 mt-4">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row">
			<div class="col-12">

				Showing <?php echo $results->num_rows; ?> result(s).

			</div> <!-- .col -->
			<div class="col-12">
				<table class="table table-hover table-responsive mt-4">
					<thead>
						<tr>
							<th>DVD Title</th>
							<th>Release Date</th>
							<th>Genre</th>
							<th>Rating</th>
						</tr>
					</thead>
					<tbody>
						<?php while ( $row = $results->fetch_assoc() ) : ?>
							<tr>
								<td>
									<a onclick="return confirm('Are you sure you want to delete this record?')" href="delete.php?dvd_title_id=<?php echo $row['dvd_title_id']; ?>&dvd_name=<?php echo $row['title']?>" class="btn btn-outline-danger delete-btn">
										Delete
									</a>
								</td>
								<td>
									<a href="details.php?dvd_title_id=<?php echo $row['dvd_title_id'] ?>">
										<?php echo $row['title']; ?>
									</a>
								</td>
								<td><?php echo $row['release_date']; ?></td>
								<td><?php echo $row['genre']; ?></td>
								<td><?php echo $row['rating']; ?></td>
							</tr>
						<?php endwhile; ?>
					</tbody>
				</table>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="search_form.php" role="button" class="btn btn-primary">Back to Form</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container-fluid -->
</body>
</html>