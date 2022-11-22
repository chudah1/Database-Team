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
          <a href="Preferred Subscriptions.php" class="active">
            <i class='bx bx-grid-alt' ></i>
            <span class="links_name">Packages</span>
          </a>
        </li>
        <li>
          <a href="Top Products.php">
            <i class='bx bx-box' ></i>
            <span class="links_name">Products</span>
          </a>
        </li>
        <li>
          <a href="Product_category.php">
            <i class='bx bx-list-ul' ></i>
            <span class="links_name">Product Category</span>
          </a>
        </li>
        <li>
          <a href="fav_brands.php">
            <i class='bx bx-pie-chart-alt-2' ></i>
            <span class="links_name">Brands</span>
          </a>
        </li>
        <li>
          <a href="Preferred Subscriptions.php">
            <i class='bx bx-coin-stack' ></i>
            <span class="links_name">Subsciptions</span>
          </a>
        </li>
        <li>
          <a href="product_category_revenue">
            <i class='bx bx-book-alt' ></i>
            <span class="links_name">Product CategoryRevenue</span>
          </a>
        </li>
      </ul>
  </div>
  <section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Dashboard</span>
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
		 
		$sql = "Select count(*) as total from customers";
    $sql_orders = "Select count(*) as total from orders";

    $sql_revenue = "select FORMAT(sum(`Total Revenue`),'#,0.00') as Total
    from 
    (select category_name, sum(`Total Revenue`) as `Total Revenue` from(
      select C.category_name, P.Unit_price*O.quantity as 'Total Revenue'
      from products P
      inner join 
      order_items O
      on O.product_id= P.product_id
      inner join Product_categories C
      using(Category_id)
      ) as s
      ) as c";
      $sql_products = "select count(*) as Total from products";

        //execute sql
        $result = mysqli_query($conn,$sql);
        $data = mysqli_fetch_assoc($result);

        $result_orders = mysqli_query($conn,$sql_orders);
        $data_orders = mysqli_fetch_assoc($result_orders);

        $total_revenue = mysqli_query($conn,$sql_revenue);
        $revenue = mysqli_fetch_assoc($total_revenue);

        $products_count = mysqli_query($conn,$sql_products);
        $products = mysqli_fetch_assoc($products_count);

        //close the connection to database
        $conn->close();
        ?> 
      <div class="home-content">
      <div class="overview-boxes">
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Orders</div>
            <div class="number"><?php echo($data_orders["total"]); ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bx-cart-alt cart'></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-topic">Total Customers</div>
            <div class="number"><?php echo($data["total"]); ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bx-group cart two' ></i>
        </div>
        <div class="box">
          <div class="right-side">
            <div class="box-group">Total Revenue</div>
            <div class="number">$<?php echo($revenue["Total"]); ?></div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Up from yesterday</span>
            </div>
          </div>
          <i class='bx bx-money cart three' ></i>
          </div>

          <div class="box">
          <div class="right-side">
            <div class="box-group">Number Of Products</div>
            <div class="number"><?php echo($products["Total"]);?> </div>
            <div class="indicator">
              <i class='bx bx-up-arrow-alt'></i>
              <span class="text">Increase</span>
            </div>
          </div>
          <i class='bx bx-shopping-bag cart three' ></i>
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