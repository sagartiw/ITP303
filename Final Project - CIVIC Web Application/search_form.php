<?php
require "config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
}

$mysqli->set_charset('utf8');

// Categories:
$sql_categories = "SELECT * FROM categories;";
$results_categories = $mysqli->query($sql_categories);
if ( $results_categories == false ) {
	echo $mysqli->error;
	exit();
}

// Close DB Connection
$mysqli->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <title>CIVIC Search Form</title>
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
                <h1 class="display-4 col-12 mt-4 mb-4">Event Search Form</h1>
            </div> <!-- .row -->
        </div> <!-- .container -->

        <div class="container">
            <form action="participate.php" method="GET" id="searchFormBox">
                <div class="form-group row mt-4">
                    <label for="title-id" class="col-sm-3 col-form-label text-sm-right"><h4>Event Title:</h4></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="title-id" name="title">
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="city-id" class="col-sm-3 col-form-label text-sm-right"><h4>City:</h4></label>
                    <div class="col-sm-9 mt-2">
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input mr-2" type="radio" name="city" id="inlineCheckbox3" value="0" checked>Los Angeles
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input mr-2" type="radio" name="city" id="inlineCheckbox1" value="1">New York City
                            </label>
                        </div>
                        <div class="form-check form-check-inline">
                            <label class="form-check-label">
                                <input class="form-check-input mr-2" type="radio" name="city" id="inlineCheckbox2" value="2">Chicago
                            </label>
                        </div>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <label for="category-id" class="col-sm-3 col-form-label text-sm-right"><h4>Category:</h4></label>
                    <div class="col-sm-9 mt-1">
                        <select name="category" id="category-id" class="form-control">
                            <option value="" selected>-- All --</option>

                            <!-- Category dropdown options here -->
                            <?php while ( $row = $results_categories->fetch_assoc() ) : ?>
                                <option value="<?php echo $row['id']; ?>">
                                    <?php echo $row['category']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div> <!-- .form-group -->

                <div class="form-group row">
                    <div class="col-sm-3"></div>
                    <div class="col-sm-9 mt-2">
                        <button type="submit" class="btn btn-third btn-lg">Search</button>
                        <button type="reset" class="btn btn-third btn-lg">Reset</button>
                        <a href="advocate.html" class="btn btn-third btn-lg" role="button">Back to Advocate</a>
                    </div>
                </div> <!-- .form-group -->
            </form>
        </div>

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