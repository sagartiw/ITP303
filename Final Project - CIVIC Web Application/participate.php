<?php
require "config/config.php";

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
	if ( $mysqli->connect_errno ) {
		echo $mysqli->connect_error;
		exit();
}

$mysqli->set_charset('utf8');

//Starter SQL Statement
$sql = "SELECT e.id AS id, e.name AS Name, e.date AS Date, c.name AS City, a.category AS Category
			FROM events e
			LEFT JOIN cities c
				ON e.city_id = c.id
			LEFT JOIN categories a
				ON e.category_id = a.id
			WHERE 1=1";

//Parse Title
if ( isset($_GET['title']) && !empty($_GET['title']) ) {
	$sql = $sql .  " AND e.name LIKE '%" . $_GET['title'] . "%'";
}
//Parse City
if ( isset($_GET['city']) && !empty($_GET['city']) ) {
	$sql = $sql . " AND e.city_id LIKE '%" . $_GET['city'] . "%'";
}
//Parse Category
if ( isset($_GET['category']) && !empty($_GET['category']) ) {
	$sql = $sql . " AND e.category_id LIKE '%" . $_GET['category'] . "%'";
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
<html lang="en">
    <head>
        <title>CIVIC Participate Page</title>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
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
                            <a class="nav-link" href="#">PARTICIPATE</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Image Slider -->
        <div id="slideshow" class="carousel slide" data-ride="carousel">
            <ul class="carousel-indicators">
                <li data-target="#slideshow" data-slide-to="0" class="active"></li>
            </ul>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="img/city.jpg">
                    <div class="carousel-caption">
                        <h1 class="display-2 d-none d-sm-block">PARTICIPATE</h1>
                        <h4>Engage with local jobs, programs, or events that build your community.</h4>
                    </div>
                </div>
            </div>
        </div>
        <!--Main Engine-->
        <div class="container-fluid padding mt-4 mb-4">
            <div class="row justify-content-center">
                <div class="col-auto">
                    <table id="eventTable" class="table table-bordered table-hover table-responsive mt-4">
                        <thead>
                            <tr>
                                <th>Event Title</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>City</th>
                                <th>Event Details</th>
                                <th>Update Event</th>
                                <th>Delete Event</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ( $row = $results->fetch_assoc() ) : ?>
                                <tr>
                                    <td><?php echo $row['Name']; ?></td>
                                    <td><?php echo $row['Date']; ?></td>
                                    <td><?php echo $row['Category']; ?></td>
                                    <td><?php echo $row['City']; ?></td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to be redirected from this page? You may lose your search!')" href="details.php?id=<?php echo $row['id'] ?>&name=<?php echo $row['Name']?>" class="btn btn-outline-primary">
                                            Details
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to be redirected from this page? You may lose your search!')" href="edit_form.php?id=<?php echo $row['id'] ?>&name=<?php echo $row['Name']?>" class="btn btn-outline-success">
                                            Update
                                        </a>
                                    </td>
                                    <td>
                                        <a onclick="return confirm('Are you sure you want to be redirected from this page? You may lose your search!')" href="delete.php?id=<?php echo $row['id']; ?>&name=<?php echo $row['Name']?>" class="btn btn-outline-danger delete-btn">
                                            Delete
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- Info -->
        <div class="container-fluid">
            <div class="row jumbotron snapshot">
                <div class="col-xs-12 col-sm-4 mt-4">
                    <img src="img/bullhorn.png">
                </div>
                <div class="col-xs-12 col-sm-8 mt-4">
                    <p>
                        The "Participate" section of the CIVIC platform allows you to actually see the results of our community building initiative. Based on your location and interests, you are given a detailed list of programs and events that are happening in your community right NOW. We provide you with all the tools necessary for you to actively engage with this information, finding events to parttake in and (eventually) people to meet!
                    </p>
                    <p>
                        With newfound job loss and the ever-changing definition of “normal” work, people have the time and the drive to participate more in their communities. It is the primary goal of CIVIC to capture this motivation and translate it into positive social impact. If we can provide individuals with easy access to civic information and give organizations a platform to promote initiatives that solve community-wide issues, we can mobilize a generation of citizens, eager to collectively improve the human condition.
                    </p>
                </div>
            </div>
        </div>
        <!-- Footer -->
       <footer>
           <div class="container-fluid">
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