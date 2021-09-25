<?php
ob_start();
include("mysql_connect.php");// here we include the connection script; since this file(header.php) is included at the top of every page we make, the connection will then also be included. Also, config options like BASE_URL are also available to us.

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Car catalog website made with PHP">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico"/>
   
    <!--  This CONSTANT is defined in your mysql_connect.php file. -->
    <title><?php echo APP_NAME; ?></title>
  
    <!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
  <style>
    body{
      color:#1b1b1b;
    }
      h1 {
        color:white;
      }
    
    .jumbotron{
      background-color: rgb(180, 179, 174) ;
    }
    
    a{
      color: #1b1b1b;
    }
    
   
    
    .filter-header{
      color: #D79922;
      font-weight: bold;
    }
    
    .admin{
      font-size: 1.2rem;
    }
    
    
    </style>


<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
function go()
{
  box = document.getElementById('entryselect'); // gets form element by the id.
  destination = box.options[box.selectedIndex].value;
  if (destination) location.href = destination;
}
</script>

<!-- Google Icons: https://material.io/tools/icons/
  also, check out Font Awesome or Glyphicons -->
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


 <!-- Your Custom styles for this project -->
     <!-- FONT AWESOME LINK-->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
 <!--  Note how we can use BASE_URL constant to resolve all links no matter where the file resides. -->
<link href="<?php echo BASE_URL ?>css/styles.css" rel="stylesheet">
<!-- Themes from https://bootswatch.com/ : Use the Themes dropdown to select a theme you like; copy/paste the bootstrap.css. Here, we have named the downloaded theme as a new file and can overwrite the default.  -->
<!-- <link href="<?php echo BASE_URL ?>css/bootstrap-lumen.css" rel="stylesheet"> -->

</head>

  <body style="background-color:rgb(223, 222, 219);" class="p-4">
    
    <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4 fixed-top">
      <a class="navbar-brand" href="<?php echo BASE_URL ?>index.php"><i class="text-warning fa fa-car" aria-hidden="true" style="font-size:36px;"></i></a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
         
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo BASE_URL ?>">Home</a>
          </li>
          <li class="nav-item active">
            <a class="nav-link" href="<?php echo BASE_URL ?>catalog.php">Vehicle Catalog</a>
          </li>
          
        <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@   ADMIN ACCESS LOGIN/SESSION HERE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
            <?php if(isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])): ?>
            <li class="nav-item active dropdown">   
            <a class="nav-link dropdown-toggle text-warning" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Admin</a>
            <div class="dropdown-menu" aria-labelledby="dropdown01">
              <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/insert.php">Insert</a>
              <a class="dropdown-item" href="<?php echo BASE_URL ?>admin/edit.php">Edit</a>
            </div>
          </li>
            <?php else: ?> 
            <li></li>
            <?php endif; ?>  
        </ul>
         <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@     NAV SEARCH FUNCTION HERE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  -->
          
        <form class="form-inline my-2 my-lg-0 mr-4" id="searchForm" name="searchForm" method="GET" action="<?php echo BASE_URL?>catalog.php?searchterm=<?php echo trim($_GET['searchterm']); ?>">
          <input class="form-control mr-sm-2" type="text" name="searchterm" placeholder="Search the Catalog" aria-label="Search">
          <button class="btn btn-outline-warning my-2 my-sm-0" type="submit" name="searchButton">Search <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>
          
        <ul class="navbar-nav mr-0">
          <!-- @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@  LOGGOUT FUNCTION HERE @@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@ -->
          <?php if(isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])): ?>          
          <li class="nav-item active admin"><a class="nav-link text-warning" href="<?php echo BASE_URL ?>admin/logout.php">Logout</a></li>

          <?php else: ?> 
          <li class="nav-item active admin"><a class="nav-link text-warning" href="<?php echo BASE_URL ?>admin/login.php">Login</a></li>
          <?php endif; ?>
        </ul>
        <!-- Search Bar: 
        <form class="form-inline mt-2 mt-md-0">
          
          <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
          <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form> -->
      </div>
    </nav>

    <main role="main" class="container">



    

      

    




