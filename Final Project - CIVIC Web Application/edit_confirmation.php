<?php
//The code in this file will actually add the new song to the database
//var_dump($_POST);
require "config/config.php";
$isUpdated = false;
if ( !isset($_POST['title']) || 
	empty($_POST['title']) || !isset($_POST['event_date']) || empty($_POST['event_date'])){
		$error = "Please fill out all required fields";
}
else {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
		if ( $mysqli->connect_errno ) {
			echo $mysqli->connect_error;
			exit();
	}

    $mysqli->set_charset('utf8');
    
    // Using prepared statements
    $statement = $mysqli->prepare(
        "UPDATE events 
        SET name = ?, date = ?, city_id = ?, category_id = ?, info_url = ?, event_url = ?, email = ?
        WHERE id = ?"
    );

    // Bind the parameters
	$statement->bind_param("ssssssss", $_POST["title"], $_POST["event_date"], $_POST["city"], $_POST["category"], $_POST["infoURL"], $_POST["eventURL"], $_POST["email"], $_POST["id"]);

    $executed = $statement->execute();
    if(!$executed) {
        echo $mysqli->error;
    }

    // affected_rows will return how many records have been inserted/updated from the above statement
    if ($statement->affected_rows == 1) {
        $isUpdated = true;
    }
    $statement->close();

	$mysqli->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>CIVIC Edit Confirmation</title>
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
			<h1 class="col-12 mt-4">Edit Confirmation</h1>
		</div> <!-- .row -->
    </div> <!-- .container -->
    
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if($isUpdated) : ?>
					<div class="text-success">
						<span class="font-italic"><?php echo $_POST["title"]?></span> was successfully edited.
					</div>
                <?php else:?>
                    <div class="text-danger">
						<h3>Invalid submission attempt. Your event was not added.Please fill out all required fields.</h3>
					</div>
                <?php endif;?>
			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
				<a href="details.php?id=<?php echo $_POST['id']; ?>" role="button" class="btn btn-primary">Back to Details</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>