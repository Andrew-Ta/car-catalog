<?php
session_start();
include ("includes/header.php");
?>

  <div class="jumbotron clearfix">
    <h1>Details</h1>

  </div>

<?php
if(isset($_GET['random'])){
  $random = $_GET['random'];
}

  
if(isset($random)){
  $result = mysqli_query($con, "SELECT * FROM ata_catalog ORDER BY RAND() LIMIT 1") or die (mysqli_error($con));
}



if(isset($catalogID)){
  $catalogID = $_GET['cid'];
  $result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_cid = '$catalogID'") or die (mysqli_error($con));  
}


  echo "<div class=\"container pt-2 pb-4\">";
      
  while ($row = mysqli_fetch_array($result)){
    $cid = $row['ata_cid'];
    $type = $row['ata_type'];
    $make = $row['ata_make'];
    $model = $row['ata_model'];
    $year = $row['ata_year'];
    $baseprice = $row['ata_baseprice'];
    $hp = $row['ata_hp'];
    $torque = $row['ata_torque'];
    $zerotosixty = $row['ata_zerotosixty'];
    $description = $row['ata_description'];
    $image = $row['ata_image'];
  
    $vehicleFullName = $year. " " .$make. " " .$model;

    echo "<div class=\"row\">";
    echo "<div class=\"card col-md-8\">";
    echo "<div class=\"card-body\">";
    echo "<h3 class=\"card-title\">$vehicleFullName</h3>";
    echo "<hr>";
    echo "<img class=\"img-fluid\" src=\"display/$image\" />";
    echo "<p class=\"card-text mt-3\">$description </p>";
    echo "</div>";
    echo "</div>";//end col 1
    //spacer
    echo "<div class=\"col-md-1\"></div>";
    //end spacer
    echo "<div class=\"card col-md-3\">";
    echo "<div class=\"card-body\">";
    echo "<h5 class=\"card-title\">Vehicle Specs</h5>";
    echo "<hr>";
    echo "<p class=\"card-text font-weight-bold\">Type: </p>";
    echo "<p class=\"card-text \">$type </p>";
    echo "<p class=\"card-text font-weight-bold\">Make: </p>";
    echo "<p class=\"card-text \">$make </p>";
    echo "<p class=\"card-text font-weight-bold\">Model: </p>";
    echo "<p class=\"card-text \">$model </p>";
    echo "<p class=\"card-text font-weight-bold\">Year:</p>";
    echo "<p class=\"card-text \">$year </p>";
    echo "<p class=\"card-text font-weight-bold\">Base Msrp: </p>";
    echo "<p class=\"card-text \">$baseprice </p>";
    echo "<p class=\"card-text font-weight-bold\">Horsepower: </p>";
    echo "<p class=\"card-text \">$hp </p>";
    echo "<p class=\"card-text font-weight-bold\">Torque: </p>";
    echo "<p class=\"card-text \">$torque </p>";
    echo "<p class=\"card-text font-weight-bold\">0 - 60 MPH Time: </p>";
    echo "<p class=\"card-text \">$zerotosixty </p>";
    echo "</div>";
    echo "</div>"; //end col 2
    echo "</div>"; //end row
  }//end while
      
  echo "</div>";//end container div
      
include ("includes/footer.php");
?>