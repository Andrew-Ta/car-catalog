<?php
session_start();
include ("includes/header.php");

$currentYear = date("Y");

?>
<div class="jumbotron clearfix" style="background-color: rgb(180, 179, 174) ;">
  <h1>Catalog</h1>
</div>
<div class="container rounded bg-white pt-4">
<div class="row bg-white mt-0">
<!--Filter Options sections-->
<div class="col-md-3 mb-5">
  <div class="container-fluid">
    <h5>Filter Options</h5>
  <hr>
    <a href="catalog.php" >All Vehicles</a><br />
    <br/>
    
    <label class="filter-header">By Type:</label><br/>
    <a href="catalog.php?displayby=ata_type&displayvalue=Convertible">Convertible</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Coupe">Coupe</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Hatchback">Hatchback</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Minivan">Minivan</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Pickup">Pickup Truck</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Sedan">Sedan</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=SUV">SUV</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Sports">Sports Car</a><br />
    <a href="catalog.php?displayby=ata_type&displayvalue=Super">Super Car</a><br />
    <br/>
    

    <label class="filter-header" for="entryselect">By Make:</label>
    <select class="form-control" name="entryselect" id="entryselect" onchange="go()">
      <option value="catalog.php">Select</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Acura">Acura</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Audi">Audi</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Bentley">Bentley</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=BMW">BMW</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Bugatti">Bugatti</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Ferrari">Ferrari</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Ford">Ford</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Infiniti">Infiniti</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Lamborghini">Lamborghini</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Land Roverr">Land Rover</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Lexus">Lexus</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Maserati">Maserati</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Mazda">Mazda</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=McLaren">McLaren</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Mercedes">Mercedes</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Porsche">Porsche</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Rolls-Royce">Rolls-Royce</option>
      <option value="catalog.php?displayby=ata_make&displayvalue=Tesla">Tesla</option>
    </select>
    <br/>    
    
    <p class="filter-header">By Year:</p>
    <a href="catalog.php?min=1900&max=1999">Past - 1999</a><br />
    <a href="catalog.php?min=2000&max=2010">2000 - 2010</a><br />
    <a href="catalog.php?min=2011&max=2020">2011 - 2020</a><br />
    <a href="catalog.php?min=2021&max=<?php echo $currentYear; ?> ">2021 - Current Year</a><br />
    
    <br/>
    <form id="myform" name="myform" method="get" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
      <label class="filter-header">Enter a Year Range:</label>
      <div class="d-flex">
        <input type="number" name="minYear" placeholder="min" class="form-control w-50">
        <input type="number" name="maxYear" placeholder="max" class="form-control w-50">
      </div>

       <input type="submit" name="YearRange" class="mt-2 btn btn-info btn-block" value="Search">      
    </form>
    <br/>
  <!--RANDOM VEHICLE DISPLAY WIDGET-->
    <form id="randomForm" name="randomForm" method="GET" action="<?php echo BASE_URL?>display.php?cid=<?php echo $cid; ?>">
      <label class="filter-header">Select a random vehicle:</label>
      <button class="btn btn-block btn-warning my-2 my-sm-0" type="submit" name="random">Random Vehicle <i class="fa fa-search" aria-hidden="true"></i></button>
    </form>        


  </div> <!-- end Filter option sections-->  
</div> <!--  end container -->


<!--Filter results sections-->
<div class="col-md-9">
<?php

$errorMsg = "";


//filtering the DB results
//DEFAULT return all entries
$result = mysqli_query($con, "SELECT * FROM ata_catalog") or die (mysqli_error($con));

if(isset($_GET['displayby'])){
  $displayby = $_GET['displayby'];
}

if(isset($_GET['displayvalue'])){
  $displayvalue = $_GET['displayvalue'];
}

if(isset($_GET['searchterm'])){
  $searchterm = $_GET['searchterm'];
}

if(isset($_GET['random'])){
  $random = $_GET['random'];
}

if(isset($_GET['min'])){
  $min = $_GET['min'];
}

if(isset($_GET['max'])){
  $max = $_GET['max'];
}

// USER ENTERED MINYEAR MAXYEAR
if(isset($_GET['YearRange'])){
  $minYear = $_GET['minYear'];
  $maxYear = $_GET['maxYear'];  

  if(isset($minYear) && isset($maxYear)){
    $result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_year BETWEEN '$minYear' AND '$maxYear' ORDER BY ata_year") or die (mysqli_error($con));
    
    if((mysqli_num_rows($result)) == 0){
      $errorMsg = "No results found between years $minYear and $maxYear.";
    }
  }

  if(isset($minYear) && isset($maxYear) && ($maxYear == "")){
    $errorMsg="Enter a max year.";
  }
  
  if(isset($minYear) && isset($maxYear) && ($minYear == "")){
    $errorMsg="Enter a min year.";
  }
  if(isset($minYear) && isset($maxYear) && ($minYear == "") &&($maxYear =="")){
    $errorMsg="Enter a min and max year.";
  }
}

//by MAKE drop down
if(isset($displayby) && isset($displayvalue)) {
	$result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE $displayby LIKE '$displayvalue'") or die (mysqli_error($con));
}

// by premade YEAR Ranges
if(isset($min) && isset($max)) {
	$result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_year BETWEEN '$min' AND '$max' ORDER BY ata_year") or die (mysqli_error($con));
}  

// by SEARCHTERM
$searchterm = (isset($_GET['searchterm'])) ? $_GET['searchterm'] : "";
if(isset($_GET['searchterm'])){
  $searchterm = $_GET['searchterm'];
  $result = mysqli_query($con, "SELECT * FROM ata_catalog 
                                      WHERE ata_type LIKE '%$searchterm%'                 
                                      OR ata_make LIKE '%$searchterm%' 
                                      OR ata_model LIKE '%$searchterm%' 
                                      OR ata_year LIKE '%$searchterm%'") or die (mysqli_error($con));
  if((mysqli_num_rows($result)) == 0){
    $errorMsg = "No results found."; 
  }
}

// RANDOM WIDGET
$random = (isset($_GET['random'])) ? $_GET['random'] : "";  

//HEADER UPDATES TO SEARCH TERMS/FILTER OPTIONS
$resultTitle = "";
//reults for : "user filter options"
if(isset($displayvalue) && $displayvalue != ""){
  $resultTitle = "for: \"$displayvalue\"";
}
  //search bar searchterm
if($searchterm != ""){
  $resultTitle = "for: \"$searchterm\"";
}
  
echo "<h5 class=\"\">Results $resultTitle </h5><hr><br/>";
echo "<p style=\"color:firebrick;\"> $errorMsg </p>";

while ($row = mysqli_fetch_array(!is_null($result) ? $result  : $defaultresult)){
  $cid = $row['ata_cid'];
  $type = $row['ata_type'];
  $make = $row['ata_make'];
  $model = $row['ata_model'];
  $year = $row['ata_year'];
  $baseprice = $row['ata_baseprice'];
  $hp = $row['ata_hp'];
  $torque = $row['ata_torque'];
  $zerosixty = $row['ata_zerotosixty'];
  $desc = $row['ata_description'];
  $image = $row['ata_image'];

  $vehicleFullName = $year. " " .$make. " " .$model;
       
      echo "<div class=\"card border mb-3\">";
      echo "<div class=\"row no-gutters\">";
  
      //image
      echo "<div class=\"col-md-4\">";
      echo "<img style=\"width: 100%;\" class=\"img-fluid\" src=\"thumbs/$image\" alt=\"$model\">";
      echo "</div>";//end image
    
      //card body
      echo "<div class=\"col-md-6\">";
      echo "<div class=\"card-body\">";
      echo "<h5 class=\"card-title\">$vehicleFullName</h5>";
      echo "<p class=\"card-text font-weight-normal\">MSRP: $$baseprice USD</p>";
      echo "<p class=\"card-text font-weight-normal\">0-60 time: $zerosixty seconds</p>";
      echo "</div>"; //end body  
      echo "</div>";//end image
  
      //card footer
      echo "<div class=\"col-md-2 card-footer bg-white border-top\">";
      echo "<a href=\"display.php?cid=$cid\" class=\"btn btn-info btn-sm m-2 \">More Info</a>";
        if(isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])){
          echo "<a href=\"admin/edit.php?cid=$cid\" class=\"btn btn-success btn-sm m-2\">Edit Entry</a>";
        }
      echo "</div>"; //end footer
    echo "</div>"; //end row no gutters
    echo "</div>"; //end card

}//end while
?>
  
</div> <!--end results section-->

</div>  
</div> <!--end container-->

<?php
include ("includes/footer.php");
?>