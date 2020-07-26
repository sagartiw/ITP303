<?php
require 'config/config.php';
$isDeleted = false;

if ( !isset($_GET['id']) || empty($_GET['id']) 
		|| !isset($_GET['name']) || empty($_GET['name']) ) {
	$error = "Invalid Event.";
}
else {
	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
	}

	//Prepared Statement Way
	$statement = $mysqli->prepare("DELETE FROM events WHERE id = ?");
	$statement->bind_param("i", $_GET['id']);
	$executed = $statement->execute();
	if(!$executed){
		echo $mysqli->error;
		exit();
	}

	//Affected rows return how many records were deleted
	if($statement->affected_rows == 1) {
		$isDeleted = true;
	}

	$statement->close();
	$mysqli->close();
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>CIVIC Delete Confirmation</title>
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
			<h1 class="col-12 mt-4">Delete an Event</h1>
		</div> <!-- .row -->
    </div> <!-- .container -->
    
	<div class="container">
		<div class="row mt-4">
			<div class="col-12">
				<?php if ( isset($error) && !empty($error) ) : ?>
					<div class="text-danger">
						<?php echo $error; ?>
					</div>
				<?php endif; ?>

				<?php if ( $isDeleted ) :?>
					<div class="text-success"><span class="font-italic"><?php echo $_GET['name']; ?></span> was successfully deleted.</div>
				<?php endif; ?>

			</div> <!-- .col -->
		</div> <!-- .row -->
		<div class="row mt-4 mb-4">
			<div class="col-12">
                <a href="participate.php" class="btn btn-third btn-lg" role="button">Back to Participate</a>
			</div> <!-- .col -->
		</div> <!-- .row -->
	</div> <!-- .container -->
</body>
</html>