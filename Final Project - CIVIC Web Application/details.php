<?php
// Check that an event has been passed.
if(!isset($_GET["id"]) || empty($_GET["id"])) {
	$error = "Invalid Event ID.";
}
else {
	require "config/config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
	}

    $mysqli->set_charset('utf8');

	// Generate a SQL statement to get details of the specific song
	$sql = "SELECT e.name AS name, e.date AS date, c.name AS city, 
	a.category AS category, e.info_url AS info_url, e.event_url AS event_url, e.email AS email
	FROM events e
	LEFT JOIN cities c
		ON e.city_id = c.id
	LEFT JOIN categories a
		ON e.category_id = a.id
	WHERE e.id =" . $_GET["id"]  . ";";

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
	<title>CIVIC Event Details</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Jost Font -->
    <link href="https://fonts.googleapis.com/css?family=Jost&display=swap" rel="stylesheet" type="text/css">
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
        <div class="container-fluid">
            <a id="btn-click" class="navbar-brand" href="#">
                <img src="img/logo.png" width="300px">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="home.html">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="learn.html">LEARN</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="advocate.html">ADVOCATE</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="participate.php">PARTICIPATE</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Event Details</h1>
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
							<td><?php echo $row["name"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Date:</th>
							<td><?php echo $row["date"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Category:</th>
							<td><?php echo $row["category"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">City:</th>
							<td><?php echo $row["city"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Information URL:</th>
							<td><?php echo $row["info_url"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Event URL:</th>
							<td><?php echo $row["event_url"]; ?></td>
						</tr>
						<tr>
							<th class="text-right">Email:</th>
							<td><?php echo $row["email"]; ?></td>
						</tr>
					</table>
				<?php endif;?>
			</div> <!-- .col -->
        </div> <!-- .row -->
        <div class="row mt-4 mb-4">
            <div class="col-12 col-md-6">
                <a href="participate.php" class="btn btn-third btn-lg" role="button">Back to Participate</a>
                <a href="edit_form.php?id=<?php echo $_GET['id'] ?>&name=<?php echo $row['name']?>" class="btn btn-third btn-lg" role="button">Update</a>
                <a href="delete.php?id=<?php echo $_GET['id']; ?>&name=<?php echo $row['name']?>" class="btn btn-third btn-lg" role="button">Delete</a>
            </div>
		</div> <!-- .row -->
	</div> <!-- .container -->
	<!-- Footer -->
	<footer>
		<div class="container-fluid padding mt-4">
			<div class="row text-center">
				<div class="col-md-4">
					<hr class="light">
					<h5>Contact Details</h5>
					<hr class="light">
					<p>630-885-9331</p>
					<p>sagartiw@usc.edu</p>
					<p>Los Angeles, CA</p>
				</div>
				<div class="col-md-4">
					<hr class="light">
					<h5>Service Areas</h5>
					<hr class="light">
					<p>Los Angeles</p>
					<p>Chicago</p>
					<p>New York City</p>
				</div>
				<div class="col-md-4">
					<hr class="light">
					<h5>Final Project Details</h5>
					<hr class="light">
					<p>Class: ITP303</p>
					<p>Teacher: Nayeon Kim</p>
					<p>Semester: Spring 2020</p>
				</div>
			</div>
		</div>
		<hr class="light closed">
		<div class="row text-center">
			<div class="col-12">
				<h3>CIVIC</p>
			</div>
		</div>
	</footer>
	<!-- Optional JavaScript -->
	<!-- jQuery first, then Popper.js, then Bootstrap JS -->
	<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script src="main.js"></script>
</body>
</html>