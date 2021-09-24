<?php

	if(isset($_SESSION['LAB8kaskhdEFa45skhjasdass54dk'])) {
		header("Location:../index.php");
	}

session_start();

$error = "<b></b>";

if(isset($_POST['submit'])){

  $username = $_POST['username'];
  $password = $_POST['password'];

  if(($username == "user") && ($password == "pass")){
    
    //successful login: create session and redirect user
    $_SESSION['LAB8kaskhdEFa45skhjasdass54dk'] = session_id();
    header("Location:../index.php");
    
  }else{

    if($username != "" && $password != ""){
      $error = "<b>Incorrect Login</b>";
    }
    if($username == "" && $password == ""){
      $error = "<b>Please Enter a Username and Password</b>";
    }
    if($username !="" && $password ==""){
      $error = "<b>Please Enter a Password</b>";
    }
    if($username =="" && $password !=""){
      $error = "<b>Please Enter a Username</b>";
    }
  }
}
include ("../includes/header.php");
?>
<div class="row justify-content-center">
  <div class="container max-width border border-light bg-white rounded m-0 p-4 col-md-5">
    <div class="d-flex justify-content-center  align-items-center">
      <div class="flex-column">
        <h2 class="mb-3">
          Admin Login
        </h2>
        <p>
          Login to access Admin features
        </p>
        <div class="">
          <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <div class="form-group py-2">
              <label for="username">Username:</label>
              <input class="form-control" type="text" name="username" id="username">
            </div>
            <div class="form-group py-2">
              <label for="password">Password:</label>
              <input class="form-control" type="password" name="password" id="password">
            </div>
            <div class="d-grid gap-2 d-md-block my-3">
              <input name="submit" type="submit" class="btn btn-info" value="Login">
            </div>
            <div>
              <p class="text-danger">
                <?php echo $error; ?>
              </p>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
  



<?php 
include ("../includes/footer.php");
?>