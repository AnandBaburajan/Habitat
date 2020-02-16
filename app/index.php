<?php
session_start();
require $_SERVER['DOCUMENT_ROOT'].'/db_connect.php';
if (isset($_POST['report']))
{
    $mysqli = OpenCon();
    $lat = $_POST['lat'];
    $lon = $_POST['lon'];
    $time = $_POST['time'];
    $date = $_POST['date'];
    $sql = "INSERT INTO fires (lat, lon, timee, datee,reported)
    VALUES('$lat','$lon','$time','$date',0)";

    if($mysqli->query($sql)===TRUE)
    {
      session_start();
      header("location: https://hackathon.test/");
      exit();
    }
    else {
      $_SESSION['message']= 'Failed';
      header("location: https://google.com");
    }
    CloseCon($mysqli);
    exit();
  }
 ?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Hackathon</title>
  <link href="/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link href="/css/main.css" rel="stylesheet">

</head>

<body class="site-body">

  <nav class="navbar navbar-light navbar-expand-lg fixed-top custom-nav">
    <div class="container">
      <a class="navbar-brand" href="https://hackathon.test">
        Habitat
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <div class="navbar-nav ml-auto">
          <a class="nav-item nav-link nav-link-2" href="https://hackathon.test/admin"><b>Admin</b></a>
        </div>
      </div>
    </div>
  </nav>

  <div class="container py-4">
    <div class="row">
      <div class="col-md-8">
      <div class="card">
      <div class="card-body">
        <h3>Report a fire</h3><br><br>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"];?>" class="form-signin">
            <span id="geo_er"></span>
              <div class="form-label-group">
                <input placeholder="Latitude" type="text" name="lat" id="lat" class="form-control" required>
              </div>
              <div class="form-label-group">
                <input placeholder="Longitude" type="text" name="lon" id="lon" class="form-control" required>
              </div>
              <button onclick="getLocation()" class="btn btn-primary">Use GPS</button><br><br>
              <script>
              var lat = document.getElementById("lat");
              var lon = document.getElementById("lon");
              var geo_er = document.getElementById("geo_er");
              function getLocation() {
                if (navigator.geolocation) {
                  navigator.geolocation.getCurrentPosition(showPosition);
                } else {
                  geo_er.innerHTML = "Geolocation is not supported by this browser.";
                }
              }

              function showPosition(position) {
                lat.value = position.coords.latitude;
                lon.value = position.coords.longitude;
              }
              </script>
              <div class="form-label-group">
                <input placeholder="Time" type="text" name="time" id="time" class="form-control" required>
              </div>
              <div class="form-label-group">
                <input placeholder="Date" type="date" name="date" id="date" class="form-control" required>
              </div>
              <br><br>
              <button class="btn btn-lg btn-primary btn-block text-uppercase" id="report" name="report" type="submit">Report</button>
              </form>

      </div>
    </div>
      </div>
      <div class="col-md-4">
      <div class="card">
      <div class="card-body">
        <h3>Latest wildfires</h3>
        <?php
    $mysqli = OpenCon();
     $sql = "SELECT id,lat,lon,timee,datee FROM fires ORDER BY timee desc";
     $result = mysqli_query($mysqli, $sql);
     while ($row = mysqli_fetch_assoc($result)) {
         echo "<div class='card'>
         <div class='card-body'>";
         echo "Latitude: ".$row['lat']."<br>";
         echo "Longitude: ".$row['lon']."<br>";
         echo "Time: ".$row['timee']."<br>";
        echo "Date: ".$row['datee']."<br>";
        echo "<div><iframe frameborder='0' src='https://www.openstreetmap.org/export/embed.html?bbox=".$row['lon']."%2C".$row['lat']."%2C".$row['lon']."%2C".$row['lat']."'></iframe></div>";

       echo "</div></div><br>";
     }
    CloseCon($mysqli);
 ?>
      </div>
    </div>
      </div>
  </div>
</div>
<br>

  <footer class="py-3 customfooter">
    <div class="container myfoot">
      <div class="row">
        <div class="col-md-8">
          <p class="m-0 text-secondary">:D</p></div>
        <div class="col-md-4 footico">
          <p class="m-0 text-secondary">
          </p></div>
      </div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.bundle.min.js"></script>
  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>

</body>

</html>
