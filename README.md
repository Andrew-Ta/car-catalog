# car-catalog

### Intro:

Since I was young, I have always had an interest in automobiles. I was mainly interested in sports cars and exotics because I loved their low and sleek body shapes. As I grew older, my interest in vehicles continued to grow. Now, I appreciate vehicles of all different types, makes, and models. 

This project is a catalog of some of the vehicles that I like and have been interested in.

### User Functionality:

User’s are able to navigate through this website via navigation links. They will be able to filter through the catalog using a search bar, which will lead them to the catalog page. 

In the catalog page users will have access to a side bar that contains options for filtering through the list of vehicles. Results from the filtering options will appear in the "Results" section of the catalog page in a horizontal layout with a thumbnail of the vehicle, the year, make, model, base price, and 0-60 time. 

Clicking the "More Info" button leads the user to a more detailed display page for that vehicle and it will display all information relating to that vehicle including: Type, Make, Model, Year, Base MSRP, Horsepower, Torque, 0-60 MPH time, and a description of the vehicle.

### How to access Admin features:

Admin features are locked behind a secure admin login page. Once logged in, an admin dropdown option will appear that gives access to the insert and update/delete vehicle entries pages. While logged in as admin, the user will also have access to the edit page through the individual catalog filter results which will populate the edit form with the corresponding information for that vehicle. More features will be added in the future as this project progresses.

### How to access your own database:

- If you are using this code to make your own catalog, you must modify the mysql_connect.php file to connect to your database.
- Change the BASE_URL to match your own.
- Change the session_id() to what ever you like or choose a more secure method.

### In Progress:

- Fix the undefined variable errors

### Languages Used:

- PHP
- SQL
- JavaScript
- HTML
- CSS

### Features/Dependencies:

- Used phpMyAdmin for the database
- JavaScript was used to allow the user to clear the Insert Page Form without reloading the page
- Font-Awesome used for responsive icons
- Made a search bar in the nav that allows the user to search for a vehicle
- In the catalog page, user's are able to input their own year range to filter results
- The website is fully responsive and works in different screen sizes
- Made a "Random Vehicle Widget" that sends the user to a random vehicle details page
