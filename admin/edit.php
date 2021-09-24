<?php
  session_start();
	
	if(!isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])) {
		header("Location:login.php");
	}
	include("../includes/header.php");
  
  $errorMsg = "";
  $successMsg = "";

  if(isset($_POST['submit'])){
  
    $boolValidated = true;

    
    ///CID
    $catalogID = $_POST['catalogID'];
    if($cid = null){
      $errorMsg .= "<li>Select an entry.</li>";
      $boolValidated=false;
    }

    ////TYPE SELECT VALIDATION
    $type = $_POST['type'];
    if($type == "0"){
      $errorMsg .= "<li>Select a vehicle type.</li>";
      $boolValidated = false;
    }
    
    ////MAKE SELECT VALIDATION
    $make = $_POST['make'];
    if($make == "0"){
      $errorMsg .= "<li>Select a make. </li>";
      $boolValidated = false;
    }
    
    ////MODEL VALIDATION
    $model = trim($_POST['model']);
    if(strlen($model) == 0){
      $errorMsg .= "<li>Enter a model name.</li>";
      $boolValidated = false;
    } else {
      if(strlen($model) > 30){
        $errorMsg .= "<li>Model name max length is 30 characters.</li>";
        $boolValidated = false;
      }
    }
    
    ////YEAR VALIDATION
    $year = trim($_POST['year']);    
    $currentyear = date("Y");
//     $yearrange = array(range(1900,$currentyear));
    if(strlen($year) == 0){
      $errorMsg .= "<li>Enter a model year.</li>";
      $boolValidated = false;
    } else {
      if(!range(1900, $yearrange)){
        $errorMsg .= "<li>Enter a year between 1900 - $currentyear.</li>";
        $boolValidated = false;
      }
    }
    
    ////BASEPRICE VALIDATION
    $baseprice = trim($_POST['baseprice']);
    if(strlen($baseprice) == 0){
      $errorMsg .= "<li>Enter a base price.</li>";
      $boolValidated = false;
    } else {
      if(strlen($baseprice) > 20){
        $errorMsg .= "<li>Baseprice max length is 20 characters.</li>";
        $boolValidated = false;
      }
    }
    
    ////HP VALIDATION
    $hp = trim($_POST['hp']);
    if(strlen($hp) == 0){
      $errorMsg .= "<li>Enter a horsepower value.</li>";
      $boolValidated = false;
    } else {
      if(strlen($hp) > 5){
        $errorMsg .= "<li>Horsepower has a max of 5 digits... are you driving a rocket??</li>";
        $boolValidated = false;
      }
    }
    
    ////Torque VALIDATION
    $torque = trim($_POST['torque']);
    if(strlen($torque) == 0){
      $errorMsg .= "<li>Enter a torque value.</li>";
      $boolValidated = false;
    } else {
      if(strlen($torque) > 5){
        $errorMsg .= "<li>Torque has a max of 5 digits... are you driving a rocket??</li>";
        $boolValidated = false;
      }
    }
    
    ////0-60mph VALIDATION
    $zerotosixty = trim($_POST['zerotosixty']);
    if(strlen($zerotosixty) == 0){
      $errorMsg .= "<li>Enter a 0 - 60 time.</li>";
      $boolValidated = false;
    } else {
      if(strlen($zerotosixty) > 10){
        $errorMsg .= "<li>0 - 60 max character length is 10. Format examples: 5.0s, 5.0, 5.0 sec etc.</li>";
        $boolValidated = false;
      }
    }
    
    ////DESCRIPTION VALIDATION
    $description = $_POST['description'];

      if(strlen($description) > 500){
        $errorMsg .= "<li>Description max length is 500 characters.</li>";
        $boolValidated = false;
      
    }
    
    if($boolValidated == true){
      //save data to database
      $sql = "UPDATE ata_catalog 
              SET 
                  ata_type = '$type',
              
                 
                  ata_make = '$make',
                  ata_model ='$model',
                  ata_year = '$year',
                  ata_baseprice = '$baseprice',
                  ata_hp = '$hp',
                  ata_torque = '$torque',
                  ata_zerotosixty = '$zerotosixty',
                  ata_description = '$description'
              WHERE ata_cid = '$catalogID'";
      
      mysqli_query($con,$sql) or die (mysqli_error($con));
//             echo "cid:" .$catalogID. "<br/> type:" .$type. "<br/> make:" .$make. "<br/> model:" .$model. "<br/>" .$year. "<br/>" .$baseprice. "<br/>" .$hp. "<br/>" .$torque. "<br/>" .$zerotosixty. "<br/>" .$description;
      
      $successMsg = "Edit was successful.";
      
    }  
  }


  //////DELETE
  if(isset($_POST['delete'])){
      $deleteCid = $_POST['catalogID'];
      if($deleteCid == "" || $deleteCid == null || $deleteCid == 0){
        $errorMsg = "<li>Select an entry to delete. </li>";
      }else{
        mysqli_query($con, "DELETE FROM ata_catalog WHERE ata_cid='$deleteCid'") or die (mysqli_error($con));
        $successMsg = "Entry was deleted successfully.";
      }

  }

?>
<body class="bg-secondary p-4">
  <div class="bg-white rounded container py-3">
  <h2>Edit/Delete Vehicle Entry</h2>
<hr>
  <form style="max-width:100vw !important;" id="myform" name="myform" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <div class="row mt-4">        
      <div class="col-md-10">
        <div class="form-group">
            <label class="font-weight-bold" for="entryselect">Select an entry:</label>
            <select class="form-control" name="entryselect" id="entryselect" onchange="go()">
              <option value="edit.php">Select an entry</option>
              <?php 
              
                $isSeletected = "";
                $resultList = mysqli_query($con, "SELECT * FROM ata_catalog") or die(mysqli_error($con));
              
                /////POPULATE DDL
                while($row = mysqli_fetch_array($resultList)){
                  $year = $row['ata_year'];
                  $make = $row['ata_make'];
                  $model = $row['ata_model'];
                  $cid = $row['ata_cid'];
                  $ddlName = $year. " " .$make. " " .$model;

                  if($cid == $_GET['cid']){
                    $isSelected = "selected";                
                  }else{
                    $isSelected ="";
                  }

                  echo "<option " .$isSelected. " value=\"edit.php?cid=$cid\">$ddlName</option>";
                }       
                
                /////POPULATE FORM WITH DDL LIST CID
                if(isset($_GET['cid'])){
                $catalogID = $_GET['cid'];

                $result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_cid=$catalogID" ) or die(mysqli_error($con));
                echo mysqli_error($con);

                while($row = mysqli_fetch_array($result)){
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
                }
              }
            ?>
            </select> 
        </div>        
      </div>
    </div> 
<!--     607267dacc0973.49846054.jpg -->

    <hr>
    <!--BEGIN EDIT FORM-->
    <div class="row">
      <div class="col-md-4">
        <div class="form-group">
          <label for="type">Type of vehicle:</label>
          <select class="form-control" name="type" id="type" value="<?= isset($_POST['type']) ? $_POST['type'] : ''; ?>">
            <option value="0"> select an option </option>
            <?php 
            
              if(isset($_GET['cid'])){
                $typeCid = $_GET['cid'];
                $result = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_cid=$typeCid") or die(mysqli_error($con));
                
                while($row = mysqli_fetch_array($result)){
                $queryTypeCid = $row['ata_cid'];
                $queryType = $row['ata_type'];
                  
                }
              }
                   
            ?>
            <option value="Convertible"<?php if($queryType == 'Convertible') echo 'selected';?>>Convertible</option>
            <option value="Coupe"<?php if($queryType == 'Coupe') echo 'selected';?>>Coupe</option>
            <option value="Hatchback"<?php if($queryType == 'Hatchback') echo 'selected';?>>Hatchback</option>             
            <option value="Pickup"<?php if($queryType == 'Pickup') echo 'selected';?>>Pickup Truck</option>   
            <option value="Sedan"<?php if($queryType == 'Sedan') echo 'selected';?>>Sedan</option>        
            <option value="SUV"<?php if($queryType == 'SUV') echo 'selected';?>>SUV</option>        
            <option value="Sports"<?php if($queryType == 'Sports') echo 'selected';?>>Sports Car</option>        
            <option value="Super"<?php if($queryType == 'Super') echo 'selected';?>>Super Car</option>   
          </select>
        </div>
        <div class="form-group">
          <label for="make">Make:</label>
          <select class="form-control" name="make" id="make" value="<?= isset($_POST['make']) ? $_POST['make'] : ''; ?>">
            <option value="0"> select an option </option>
            <?php
            
              if(isset($_GET['cid'])){
                $makeCid = $_GET['cid'];
                $resultMake = mysqli_query($con, "SELECT * FROM ata_catalog WHERE ata_cid=$makeCid") or die(mysqli_error($con));
                
                while($row = mysqli_fetch_array($resultMake)){
                $queryMakeCid = $row['ata_cid'];
                $queryMake = $row['ata_make'];
                  
                }
              }
            ?>
            <option value="Acura"<?php if($queryMake == 'Acura') echo 'selected';?>>Acura</option>
            <option value="Aston Martin"<?php if($queryMake == 'Aston Martin') echo 'selected';?>>Aston Martin</option>        
            <option value="Audi"<?php if($queryMake == 'Audi') echo 'selected';?>>Audi</option>
            <option value="Bentley"<?php if($queryMake == 'Bentley') echo 'selected';?>>Bentley</option>
            <option value="BMW"<?php if($queryMake == 'BMW') echo 'selected';?>>BMW</option>
            <option value="Bugatti"<?php if($queryMake == 'Bugatti') echo 'selected';?>>Bugatti</option>     
            <option value="Ferrari"<?php if($queryMake == 'Ferrari') echo 'selected';?>>Ferrari</option>
            <option value="Ford"<?php if($queryMake == 'Ford') echo 'selected';?>>Ford</option>    
            <option value="Infiniti"<?php if($queryMake == 'Infiniti') echo 'selected';?>>Infiniti</option>   
            <option value="Lamborghini"<?php if($queryMake == 'Lamborghini') echo 'selected';?>>Lamborghini</option>
            <option value="Land Rover"<?php if($queryMake == 'Land Rover') echo 'selected';?>>Land Rover</option>
            <option value="Lexus"<?php if($queryMake == 'Lexus') echo 'selected';?>>Lexus</option>      
            <option value="Maserati"<?php if($queryMake == 'Maserati') echo 'selected';?>>Maserati</option>
            <option value="Mazda"<?php if($queryMake == 'Mazda') echo 'selected';?>>Mazda</option>
            <option value="McLaren"<?php if($queryMake == 'McLaren') echo 'selected';?>>McLaren</option>
            <option value="Mercedes"<?php if($queryMake == 'Mercedes') echo 'selected';?>>Mercedes</option>      
            <option value="Porsche"<?php if($queryMake == 'Porsche') echo 'selected';?>>Porsche</option>
            <option value="Rolls-Royce"<?php if($queryMake == 'Rolls-Royce') echo 'selected';?>>Rolls-Royce</option>      
            <option value="Tesla"<?php if($queryMake == 'Tesla') echo 'selected';?>>Tesla</option>
          </select>
        </div>
        <div class="form-group">
          <label for="model">Model:</label>
          <input type="text" name="model" class="form-control" value="<?php echo $model ?>">
        </div>
        <div class="form-group">
          <label for="year">Year:</label>
          <input type="number" name="year" class="form-control" value="<?php echo $year ?>">
        </div>
      </div> <!--end left column-->

      <!-- middle column-->
      <div class="col-md-2">

        <div class="form-group">
          <label for="baseprice">Base Price:</label>
          <input type="number" name="baseprice" class="form-control" value="<?php echo $baseprice?>">
        </div>
        <div class="form-group">
          <label for="hp">Horsepower:</label>
          <input type="number" name="hp" class="form-control" value="<?php echo $hp ?>">
        </div>
        <div class="form-group">
          <label for="torque">Torque:</label>
          <input type="number" name="torque" class="form-control" value="<?php echo $torque ?>">
        </div>
        <div class="form-group">
          <label for="zerotosixty">0-60MPH Time:</label>
          <input type="text" name="zerotosixty" class="form-control" value="<?php echo $zerotosixty ?>">
        </div>
      </div>
      
      <div class="col-md-4"> <!--right column-->
        <div class="form-group">
          <label for="description">Description:</label>
          <textarea name="description" class="form-control"><?php echo $description ?></textarea>
        </div>
        <div class="form-group">
          <label for="submit"></label>
          <!--HIDDEN INPUTS-->
          <input type="hidden" name="catalogID" value="<?php echo $catalogID ?>">
          <input type="submit" name="submit" class="btn btn-info btn-block" value="Submit">
          <input type="submit" name="delete" class="btn btn-danger btn-block" value="Delete" onclick="return confirm('Are you sure you want to delete this entry?')">
        </div>

      </div>  <!--end right column-->
      
      <!--ERROR COL-->
      <div class="col-md-2">
        <!-- Error Msg Here-->
        <div style="color:firebrick;">
            <?php echo $errorMsg;?>
        </div>
        <!-- Success Msg Here-->
        <div>
          <p style="color:green;">
            <?php echo $successMsg ?>
          </p>
        </div>
      </div>
    </div>

  </div>
</body>    
    
    
    
    

  </form>
  <?php
	include("../includes/footer.php");
?>