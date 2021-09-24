<?php
  session_start();
	
	if(!isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])) {
		header("Location:login.php");
	}
	include("../includes/header.php");


  $errorMsg = "";
  $successMsg = "";

  if(isset($_POST['submit'])){
  
    $boolValidate = true;

    $originalsFolder = "../uploads/";
    $thumbsFolder = "../thumbs/";
    $displayFolder = "../display/";
    
    ////TYPE SELECT VALIDATION
    $type = $_POST['type'];
    if($type == ""){
      $errorMsg .= "<li>Select a type.</li>";
      $boolValidated = false;
    }
    
    ////MAKE SELECT VALIDATION
    $make = $_POST['make'];
    if($make == ""){
      $errorMsg .= "<li>Select a make. </li>";
      $boolValidated = false;
    }
    
    ////MODEL VALIDATION
    $model = trim($_POST['model']);
    if(strlen($model) == 0){
      $errorMsg .= "<li>Enter a model name.</li>";
      $boolValidate = false;
    } else {
      if(strlen($model) > 30){
        $errorMsg .= "<li>Model name max length is 30 characters.</li>";
        $boolValidate = false;
      }
    }
    
    ////YEAR VALIDATION
    $year = trim($_POST['year']);    
    $currentyear = date("Y");
//     $yearrange = array(range(1900,$currentyear));
    if(strlen($year) == 0){
      $errorMsg .= "<li>Enter a year.</li>";
      $boolValidate = false;
    } else {
      if(!range(1900, $yearrange)){
        $errorMsg .= "<li>Enter a year between 1900 - $currentyear.</li>";
        $boolValidate = false;
      }
    }
    
    ////BASEPRICE VALIDATION
    $baseprice = trim($_POST['baseprice']);
    if(strlen($baseprice) == 0){
      $errorMsg .= "<li>Enter a base  price (MSRP).</li>";
      $boolValidate = false;
    } else {
      if(strlen($baseprice) > 20){
        $errorMsg .= "<li>Baseprice max length is 20 characters.</li>";
        $boolValidate = false;
      }
    }
    
    ////HP VALIDATION
    $hp = trim($_POST['hp']);
    if(strlen($hp) == 0){
      $errorMsg .= "<li>Enter a horsepower value.</li>";
      $boolValidate = false;
    } else {
      if(strlen($hp) > 5){
        $errorMsg .= "<li>Horsepower has a max of 5 digits... are you driving a rocket??</li>";
        $boolValidate = false;
      }
    }
    
    ////Torque VALIDATION
    $torque = trim($_POST['torque']);
    if(strlen($torque) == 0){
      $errorMsg .= "<li>Enter a torque value.</li>";
      $boolValidate = false;
    } else {
      if(strlen($torque) > 5){
        $errorMsg .= "<li>Torque has a max of 5 digits... are you driving a rocket??</li>";
        $boolValidate = false;
      }
    }
    
    
    ////0-60mph VALIDATION
    $zerotosixty = trim($_POST['zerotosixty']);
    if(strlen($zerotosixty) == 0){
      $errorMsg .= "<li>Enter a 0 - 60 time.</li>";
      $boolValidate = false;
    } else {
      if(strlen($zerotosixty) > 10){
        $errorMsg .= "<li>0 - 60 max character length is 10. Format examples: 5.0s, 5.0, 5.0 sec etc.</li>";
        $boolValidate = false;
      }
    }
    
    ////DESCRIPTION VALIDATION
    $description = $_POST['description'];

      if(strlen($description) > 500){
        $errorMsg .= "<li>Description max length is 500 characters.</li>";
        $boolValidate = false;
      
    }
    
    ////FILE UPLOAD VALIDATION
    $file = $_FILES['file'];
    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));
    $allowed = array('jpg', 'jpeg');
    
    if (in_array($fileActualExt,$allowed)){
      if($fileError === 0){

         if($fileSize < 16000000){         
         } else {
           $errorMsg .= "Your file is too big. <br/>";
           $boolValidate = false;
         }
      } else {
        $errorMsg .= "There was an error uploading your file. <br/>";
        $boolValidate = false;
      }
    } else {
      $errorMsg .= "Cannot upload files of this type (.jpeg or .jpg only). <br/>";
      $boolValidate = false;
    }
    
    ////SUCCESSFUL VALIDATION
    if($boolValidate == true){

      $fileNameNew = uniqid('', true).".".$fileActualExt;
      $fileDestination = '../uploads/'.$fileNameNew;
      ///Move uploaded file to uploads folder
      move_uploaded_file($fileTmpName,$fileDestination);
      
      //create thumbnails and display images
      createThumbnail($fileDestination, $thumbsFolder, 240 );
	    createThumbnail($fileDestination, $displayFolder, 920 );
      
      //save data to database
      $sql = "INSERT INTO ata_catalog (ata_type,ata_make,ata_model,ata_year,ata_baseprice,ata_hp,ata_torque,ata_zerotosixty,ata_description,ata_image) VALUES ('$type','$make','$model','$year','$baseprice','$hp','$torque','$zerotosixty','$description','$fileNameNew')";
      mysqli_query($con,$sql);
//       echo $type. "<br/>" .$make. "<br/>" .$model. "<br/>" .$year. "<br/>" .$baseprice. "<br/>" .$hp. "<br/>" .$torque. "<br/>" .$zerotosixty. "<br/>" .$description. "<br/>" .$fileNameNew;
      
      $successMsg = "Upload successful.";
      
    }  
  }



 function createThumbnail($file, $folder, $newwidth) {

	list($width, $height) = getimagesize($file);
	$imgRatio = $width/$height;
	$newheight = $newwidth / $imgRatio;

	// Load
	$thumb = imagecreatetruecolor($newwidth, $newheight);
	$source = imagecreatefromjpeg($file);
	
	// Resize
	imagecopyresampled($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
	
	// Output
	//print_r($file); test
	$newFileName = $folder .  basename( $file);// get original filename for dest filename

	imagejpeg($thumb,$newFileName,80);
	imagedestroy($thumb); 
	imagedestroy($source); 

	echo "<p><img src=\"$newFileName\" />";
}

?>
<body class="bg-secondary p-4">
  <div class="bg-white rounded container py-3">
  <h2>Insert New Vehicle</h2>
<hr>
  <form style="max-width:100vw !important;" id="myform" name="myform" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
    <div class="row mt-4">
      <div class="col-md-3">
        <div class="form-group">
          <label for="type">Type of vehicle:</label>
          <select class="form-control" name="type" id="type" value="<?= isset($_POST['type']) ? $_POST['type'] : ''; ?>">
            <option disabled selected value> select an option </option>
            <option value="Convertible"<?php if(isset($_POST['type']) && $_POST['type'] == 'Convertible') echo ' selected="selected"';?>>Convertible</option>
            <option value="Coupe"<?php if(isset($_POST['type']) && $_POST['type'] == 'Coupe') echo ' selected="selected"';?>>Coupe</option>
            <option value="Hatchback"<?php if(isset($_POST['type']) && $_POST['type'] == 'Hatchback') echo ' selected="selected"';?>>Hatchback</option>        
            <option value="Minivan"<?php if(isset($_POST['type']) && $_POST['type'] == 'Minivan') echo ' selected="selected"';?>>Minivan</option>      
            <option value="Pickup"<?php if(isset($_POST['type']) && $_POST['type'] == 'Pickup') echo ' selected="selected"';?>>Pickup Truck</option>   
            <option value="Sedan"<?php if(isset($_POST['type']) && $_POST['type'] == 'Sedan') echo ' selected="selected"';?>>Sedan</option>        
            <option value="SUV"<?php if(isset($_POST['type']) && $_POST['type'] == 'SUV') echo ' selected="selected"';?>>SUV</option>        
            <option value="Sports"<?php if(isset($_POST['type']) && $_POST['type'] == 'Sports') echo ' selected="selected"';?>>Sports Car</option>        
            <option value="Super"<?php if(isset($_POST['type']) && $_POST['type'] == 'Super') echo ' selected="selected"';?>>Super Car</option>   
          </select>
        </div>
        <div class="form-group">
          <label for="make">Make:</label>
          <select class="form-control" name="make" id="make" value="<?= isset($_POST['make']) ? $_POST['make'] : ''; ?>">
            <option disabled selected value> select an option </option>
            <option value="Acura"<?php if(isset($_POST['make']) && $_POST['make'] == 'Acura') echo ' selected="selected"';?>>Acura</option>
            <option value="Aston Martin"<?php if(isset($_POST['make']) && $_POST['make'] == 'Aston Martin') echo ' selected="selected"';?>>Aston Martin</option>        
            <option value="Audi"<?php if(isset($_POST['make']) && $_POST['make'] == 'Audi') echo ' selected="selected"';?>>Audi</option>
            <option value="Bentley"<?php if(isset($_POST['make']) && $_POST['make'] == 'Bentley') echo ' selected="selected"';?>>Bentley</option>
            <option value="BMW"<?php if(isset($_POST['make']) && $_POST['make'] == 'BMW') echo ' selected="selected"';?>>BMW</option>
            <option value="Bugatti"<?php if(isset($_POST['make']) && $_POST['make'] == 'Bugatti') echo ' selected="selected"';?>>Bugatti</option>     
            <option value="Ferrari"<?php if(isset($_POST['make']) && $_POST['make'] == 'Ferrari') echo ' selected="selected"';?>>Ferrari</option>
            <option value="Ford"<?php if(isset($_POST['make']) && $_POST['make'] == 'Ford') echo ' selected="selected"';?>>Ford</option>    
            <option value="Infiniti"<?php if(isset($_POST['make']) && $_POST['make'] == 'Infiniti') echo ' selected="selected"';?>>Infiniti</option>   
            <option value="Lamborghini"<?php if(isset($_POST['make']) && $_POST['make'] == 'Lamborghini') echo ' selected="selected"';?>>Lamborghini</option>
            <option value="Land Rover"<?php if(isset($_POST['make']) && $_POST['make'] == 'Land Rover') echo ' selected="selected"';?>>Land Rover</option>
            <option value="Lexus"<?php if(isset($_POST['make']) && $_POST['make'] == 'Lexus') echo ' selected="selected"';?>>Lexus</option>      
            <option value="Maserati"<?php if(isset($_POST['make']) && $_POST['make'] == 'Maserati') echo ' selected="selected"';?>>Maserati</option>
            <option value="Mazda"<?php if(isset($_POST['make']) && $_POST['make'] == 'Mazda') echo ' selected="selected"';?>>Mazda</option>
            <option value="McLaren"<?php if(isset($_POST['make']) && $_POST['make'] == 'McLaren') echo ' selected="selected"';?>>McLaren</option>
            <option value="Mercedes"<?php if(isset($_POST['make']) && $_POST['make'] == 'Mercedes') echo ' selected="selected"';?>>Mercedes</option>      
            <option value="Porsche"<?php if(isset($_POST['make']) && $_POST['make'] == 'Porsche') echo ' selected="selected"';?>>Porsche</option>
            <option value="Rolls-Royce"<?php if(isset($_POST['make']) && $_POST['make'] == 'Rolls-Royce') echo ' selected="selected"';?>>Rolls-Royce</option>      
            <option value="Tesla"<?php if(isset($_POST['make']) && $_POST['make'] == 'Tesla') echo ' selected="selected"';?>>Tesla</option>
          </select>
        </div>
        <div class="form-group">
          <label for="model">Model:</label>
          <input type="text" name="model" class="form-control" value="<?= isset($_POST['model']) ? $_POST['model'] : '';?>">
        </div>
        <div class="form-group">
          <label for="year">Year:</label>
          <input type="number" name="year" class="form-control" value="<?= isset($_POST['year']) ? $_POST['year'] : '';?>">
        </div>
      </div> <!--end left column-->
      
      <!--middle column-->
      <div class="col-md-2">
        <div class="form-group">
          <label for="baseprice">Base Price:</label>
          <input type="number" name="baseprice" class="form-control" value="<?= isset($_POST['baseprice']) ? $_POST['baseprice'] : '';?>">
        </div>
        <div class="form-group">
          <label for="hp">Horsepower:</label>
          <input type="number" name="hp" class="form-control" value="<?= isset($_POST['hp']) ? $_POST['hp'] : '';?>">
        </div>
        <div class="form-group">
          <label for="torque">Torque:</label>
          <input type="number" name="torque" class="form-control" value="<?= isset($_POST['torque']) ? $_POST['torque'] : '';?>">
        </div>
        <div class="form-group">
          <label for="zerotosixty">0-60MPH:</label>
          <input type="text" name="zerotosixty" class="form-control" value="<?= isset($_POST['zerotosixty']) ? $_POST['zerotosixty'] : '';?>">
        </div>
      </div> <!--end middle col-->
      
       <div class="col-md-5">
          <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" class="form-control"><?php if (isset($_POST['description'])) echo $_POST['description'] ?></textarea>
          </div>
          <div class="form-group">
            <label for="file">Upload an image (.jpg or .jpeg):</label>
            <input type="file" name="file" id="file" class="form-control">
           </div>
        <div class="form-group">
          <input type="submit" name="submit" class="btn btn-info btn-block" value="Submit">
          <input type="submit" name="clear" class="btn btn-warning btn-block" value="Clear" onclick="resetForm('myform'); return false;">
        </div>
      </div> <!--end description column-->
      
      <div class="col-md-2"> <!--right column-->
        <!-- Error Msg Here-->
        <div style="color:firebrick;">
          <p style="color:firebrick;">
            <?php echo $errorMsg ?>
          </p>
        </div>
        <!-- Success Msg Here-->
        <div>
          <p style="color:green;">
            <?php echo $successMsg ?>
          </p>
        </div>
      </div>  <!--end right column-->
   
    </div> <!--end row 1-->
    <div class="row">

      </div>

    </div>
    
  </div>
</body>
    
    
    

  </form>
  <script type="text/javascript">
     function resetForm(myFormId)
     {
         var myForm = document.getElementById(myFormId);

         for (var i = 0; i < myForm.elements.length; i++)
         {
             if ('submit' != myForm.elements[i].type && 'reset' != myForm.elements[i].type)
             {
                 myForm.elements[i].checked = false;
                 myForm.elements[i].value = '';
                 myForm.elements[i].selectedIndex = 0;
             }
         }
     }
  </script>
  <?php
	include("../includes/footer.php");
?>