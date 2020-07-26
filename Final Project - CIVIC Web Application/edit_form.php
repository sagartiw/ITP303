<?php
require "config/config.php";
// Make sure track_is passed to this page
if ( !isset($_GET['id']) || empty($_GET['id']) 
		|| !isset($_GET['name']) || empty($_GET['name']) ) {
    $error = "Invalid Event.";
}
else{
    // DB Connection.
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ( $mysqli->connect_errno ) {
        echo $mysqli->connect_error;
        exit();
    }

    $mysqli->set_charset('utf8');

    // DVD SPECIFIC DETAILS
    $sql_event = "SELECT * FROM events 
    WHERE id = " . $_GET["id"] . ";";

    //echo "<hr>" . $sql_dvd . "<hr>";

    $results_event = $mysqli->query($sql_event);
    if( $results_event == false ) {
        echo $mysqli->error;
        exit();
    }

    // Store selected DVD in row variable
    $row_event = $results_event->fetch_assoc();

    //Dropdown Menus
    // Cities:
    $sql_cities = "SELECT * FROM cities;";
    $results_cities = $mysqli->query($sql_cities);
    if ( $results_cities == false ) {
        echo $mysqli->error;
        exit();
    }

    // Categories:
    $sql_categories = "SELECT * FROM categories;";
    $results_categories = $mysqli->query($sql_categories);
    if ( $results_categories == false ) {
        echo $mysqli->error;
        exit();
	}
	
    // Close DB Connection
    $mysqli->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CIVIC Edit Form</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <!-- Jost Font -->
    <link href="https://fonts.googleapis.com/css?family=Jost&display=swap" rel="stylesheet">
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
            <h1 class="display-4 col-12 mt-4 mb-4">Event Edit Form</h1>
        </div> <!-- .row -->
    </div> <!-- .container -->

	<div class="container">
		<form action="edit_confirmation.php" method="POST" id="editFormBox">
			<div class="form-group row">
                <label for="title-id" class="col-sm-3 col-form-label text-sm-right mt-3">
                    <h4>Title: <span class="text-danger">*</span></h4>
                </label>
				<div class="col-sm-9 mt-3">
					<input type="text" class="form-control" id="title-id" name="title" value="<?php echo $row_event['name'] ?>">
				</div>
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="date-id" class="col-sm-3 col-form-label text-sm-right"><h4>Date:<span class="text-danger">*</span></h4></label>
				<div class="col-sm-9">
					<input type="text" class="form-control" name="event_date" value="<?php echo $row_event['date']?>">
				</div> <!-- .col -->
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="city-id" class="col-sm-3 col-form-label text-sm-right"><h4>City:<span class="text-danger">*</span></h4></label>
				<div class="col-sm-9">
					<select name="city" id="city-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>
						<?php while( $row = $results_cities->fetch_assoc() ): ?>
							<?php if( $row['id'] == $row_event["city_id"]): ?>
								<option selected value="<?php echo $row['id']; ?>">
									<?php echo $row['name']; ?>
								</option>
							<?php else: ?>
								<option value="<?php echo $row['id']; ?>">
									<?php echo $row['name']; ?>
								</option>
							<?php endif;?>
						<?php endwhile; ?>
					</select>
				</div> <!-- .col -->
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="category-id" class="col-sm-3 col-form-label text-sm-right"><h4>Category:<span class="text-danger">*</span></h4></label>
				<div class="col-sm-9">
					<select name="category" id="category-id" class="form-control">
						<option value="" selected disabled>-- Select One --</option>
						<?php while( $row = $results_categories->fetch_assoc() ): ?>
							<?php if( $row['id'] == $row_event["category_id"]): ?>
								<option selected value="<?php echo $row['id']; ?>">
									<?php echo $row['category']; ?>
								</option>
							<?php else: ?>
								<option value="<?php echo $row['id']; ?>">
									<?php echo $row['category']; ?>
								</option>
							<?php endif;?>
						<?php endwhile; ?>
					</select>
				</div> <!-- .col -->
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="info-id" class="col-sm-3 col-form-label text-sm-right"><h4>Information URL:</h4></label>
				<div class="col-sm-9">
					<input type="url" class="form-control" name="infoURL" value="<?php echo $row_event['info_url']?>">
				</div> <!-- .col -->
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="event-id" class="col-sm-3 col-form-label text-sm-right"><h4>Event URL:</h4></label>
				<div class="col-sm-9">
					<input type="url" class="form-control" name="eventURL" value="<?php echo $row_event['event_url']?>">
				</div> <!-- .col -->
			</div> <!-- .form-group -->

			<div class="form-group row">
				<label for="email-id" class="col-sm-3 col-form-label text-sm-right"><h4>Email:</h4></label>
				<div class="col-sm-9">
					<input type="email" class="form-control" name="email" value="<?php echo $row_event['email']?>">
				</div> <!-- .col -->
			</div> <!-- .form-group -->
								
			<!-- Pass Event ID to edit_confirmation.php as a hidden input -->
			<input type="hidden" name="id" value="<?php echo $_GET['id'] ?>" />

			<div class="form-group row">
				<div class="col-sm-3"></div>
				<div class="col-sm-9 mt-2">
						<button type="submit" class="btn btn-third btn-lg">Submit</button>
                        <button type="reset" class="btn btn-third btn-lg">Reset</button>
                        <a href="participate.php" class="btn btn-third btn-lg" role="button">Back to Participate</a>
				</div>
			</div> <!-- .form-group -->
		</form>
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