<?php
session_start();
include ("includes/header.php");

?>

  <div class="jumbotron clearfix">
    <h1><?php echo APP_NAME ?></h1>
    <h4 class="font-weight-light">by: Andrew Ta</h4>
  </div>
  <div class="container rounded bg-light py-3">
    <h3>
      Intro
    </h3>
    <p>
      Since I was young, I have always had an interest in automobiles. I was mainly interested in sports cars and exotics because I loved their low and sleek body shapes. As I grew older, my interest in vehicles continued to grow. Now, I appreciate vehicles of all different types, makes, and models. 

      This project is a catalog of some of the vehicles that I like and have been interested in.
    </p>
    <h3>
      User Functionality:
    </h3>
    <p>
      User’s are able to navigate through this website via navigation links. They will be able to filter through the catalog using a search bar, which will lead them to the catalog page. 
      
      In the catalog page users will have access to a side bar that contains options for filtering through the list of vehicles. Results from the filtering options will appear in the "Results" section of the catalog page in a horizontal layout with a thumbnail of the vehicle, the year, make, model, base price, and 0-60 time. 
      
      Clicking the "More Info" button leads the user to a more detailed display page for that vehicle and it will display all information relating to that vehicle including: Type, Make, Model, Year, Base MSRP, Horsepower, Torque, 0-60 MPH time, and a description of the vehicle.
       
    </p>
    <h3>
      How to Access Admin features:
    </h3>
    <p>
      Admin features are locked behind a secure admin login page. Once logged in, an admin dropdown option will appear that gives access to the insert and update/delete vehicle entries pages. While logged in as admin, the user will also have access to the edit page through the individual catalog filter results which will populate the edit form with the corresponding information for that vehicle. More features will be added in the future as this project progresses.
    </p>
    <h3>
      Features/Extras:
    </h3>
    <ul>
      <li>Used JavaScript to allow the user to clear the Insert Page Form without reloading the page</li>      
      <li>Used Font-Awesome for responsive icons</li>
      <li>Made a search bar in the nav that allows the user to search for a vehicle</li>
      <li>In the catalog page, user's are able to input their own vehicle year range to search against</li>
      <li>The website is fully responsive and works in different screen sizes</li>
      <li>Made a "Random Vehicle Widget" that sends the user to a random vehicle details page
      </li>
      <li class="font-weight-bold">Try it out!</li><br/>
      <div class="col text-center">
        <!--RANDOM VEHICLE DISPLAY WIDGET-->
        <form id="randomForm" name="randomForm" method="GET" action="<?php echo BASE_URL?>display.php?cid=<?php echo $cid; ?>">
          <button class="btn btn-warning" type="submit" name="random">Random Vehicle <i class="fa fa-search" aria-hidden="true"></i></button>
        </form>        
      </div>
      <br/>

    </ul>
    <h3>
      Known Issues
    </h3>
    <ul>
      <li>The results cards can be wonky at certain resolutions (around 615px - 780px) and images could look weird depending on their original ratio (this part could be fixed by increasing the upload thumbnail size).</li>
    </ul>
  </div>





<?php
include ("includes/footer.php");
?>