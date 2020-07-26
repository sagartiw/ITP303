<?php
//The code in this file will actually add the new song to the database
if ( !isset($_POST['title']) || 
	empty($_POST['title']) || !isset($_POST['event_date']) || empty($_POST['event_date'])){
		$isInserted = False;
}
else {
	require "config/config.php";

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
	}

    $mysqli->set_charset('utf8');
    
    $titleSQL = $mysqli->real_escape_string($_POST['title']);
    $dateSQL = "'" . $_POST['event_date'] . "'";
    $city_id = "'" . $_POST['city'] . "'";
    $category_id = "'" . $_POST['category'] . "'";

    // Handle all optional variables! Release date and award are dumped regardless.
    // Info URL
	if( isset($_POST['info']) && !empty($_POST['info'])) {
		$infoURL = "'" . $_POST['info'] . "'";
    }
    else{
        $infoURL = "null";
    }
	// Event URL
	if( isset($_POST['eventURL']) && !empty($_POST['eventURL'])) {
		$eventURL = "'" . $_POST['eventURL'] . "'";
	}
	else {
		$eventURL = "null";
	}
	// Email
	if( isset($_POST['email']) && !empty($_POST['email'])) {
		$email = "'" . $_POST['email'] . "'";
	}
	else {
		$email = "null";
	}

	// Write SQL to insert this record into the DB
	$sql = "INSERT INTO events (name, date, city_id, category_id, info_url, event_url, email) 
		VALUES('" . $titleSQL . "'," 
		. $dateSQL
		. ", "
		. $city_id
		. ", "
		. $category_id
		. ", "
		. $infoURL
		. ", "
		.  $eventURL
		. ", "
		. $email
		. ");";

	// Submit the query
	$results = $mysqli->query($sql);
	if(!$results) {
		echo $mysqli->error;
		exit();
	}

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
	<title>CIVIC Add Confirmation</title>
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
                    <li class="nav-item active">
                        <a class="nav-link" href="advocate.html">ADVOCATE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="participate.php">PARTICIPATE</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


	<div class="container">
		<div class="row">
			<h1 class="col-12 mt-4">Add an Event</h1>
		</div> <!-- .row -->
    </div> <!-- .container -->
    
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if($isInserted) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST["title"]?></span> was successfully added.
					</div>
                <?php else:?>
                    <div class="text-danger">
						<h3>Invalid submission attempt. Your event was not added. Please fill out all required fields.</h3>
					</div>
                <?php endif;?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
            <div class="col-12 col-md-6">
                <a href="add_form.php" class="btn btn-primary btn-lg btn-block mt-4 mt-md-2" role="button">Back to Add Form</a>
            </div>
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>