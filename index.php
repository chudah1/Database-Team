 <!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">

     <meta name="viewport" content="width=device-width, initial-scale=1.0">
   </head>
<body>
  <div class="sidebar">
    <div class="logo-details">
      <i class='bx bxl-c-plus-plus'></i>
      <span class="logo_name">Tranquillo Inc</span>
    </div>
      <ul class="nav-links">
        <li>
          <a href="Preffered Packages.php" class="active">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Preferred Packages</span>
          </a>
        </li>
        <li>
          <a href="Top Products.php">
            <i class='bx bx-box' ></i>
            <span class="links_name">Top Products</span>
          </a>
        </li>
        <li>
          <a href="Product_category.php">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Top Product Category</span>
          </a>
        </li>
        <li>
          <a href="fav_brands.php">
            <i class='bx bx-pie-chart-alt-2' ></i>
            <span class="links_name">Preferred Brands</span>
          </a>
        </li>
        <li>
          <a href="Preferred Subscriptions.php">
            <i class='bx bx-coin-stack' ></i>
            <span class="links_name">Preferred Subsciptions</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-book-alt' ></i>
            <span class="links_name">Product Category Revenu</span>
          </a>
        </li>
        <li>
          <a href="#">
            <i class='bx bx-user' ></i>
            <span class="links_name">Team</span>
          </a>
        </li>
        
        <li class="log_out">
          <a href="#">
            <i class='bx bx-log-out'></i>
            <span class="links_name">Log out</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
      </div>
      <div class="search-box">
        <input type="text" placeholder="Search...">
        <i class='bx bx-search' ></i>
      </div>

    </nav>

    <?php
	 	//database connection parameters
	 	//change the database name to suite what you have in phpmyadmin
		$servername = "localhost";
		$username = "root";
		$password = "";
		$dbname = "ecommerce_platform";

		// Create connection
		$conn = new mysqli($servername, $username, $password, $dbname);
		
		// Check connection
		if ($conn->connect_error) {
		  die("Connection failed: " . $conn->connect_error);
		}
		 
		$sql = "Select count(*) from customers";

        //execute sql
        $result = $conn->query($sql);
        //check if any record was found
        if ($result->num_rows > 0){
          //create 
        }
        else{
          echo("No records found");
        }

        //close the connection to database
        $conn->close();
        ?> 

      <div class="container">
      <div class="row">
      <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">text title here...</h5>
              <p class="card-text">Add additional content here...</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
        </div>
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">text title here...</h5>
              <p class="card-text">Add additional content here...</p>
              <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
          </div>
        </div>
      </div>
      </div>



    
      
  </section>

  <script>
   let sidebar = document.querySelector(".sidebar");
let sidebarBtn = document.querySelector(".sidebarBtn");
sidebarBtn.onclick = function() {
  sidebar.classList.toggle("active");
  if(sidebar.classList.contains("active")){
  sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
}else
  sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
}
 </script>

</body>
</html>