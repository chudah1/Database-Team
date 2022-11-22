<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tranquillo Ecommerce Databse</title>
	<link rel="stylesheet" href="css/style.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>
<div class="nav-section">
				<nav class="navbar navbar-expand-lg navbar-light bg-light  fixed-top">
			<a class="navbar-brand px-5" href="#"><h5 class="brand">Tranquillo Inc</h5></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav mx-l">
				<li class="nav-item mx-5 ">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="Preferred Subscriptions.php">Packages</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="product_category_revenue.php">Product Category Revenue</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="Top Products.php">Rated Products</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="Product_category.php">Top Product Category</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="fav_brands.php">Brands</a>
				</li>
			</ul>
			</div>
		</nav>
		</div>
        <div class="container">
        <canvas id="myChart" style=" margin:50px;width:100%;max-width:800px"></canvas>;
    <canvas id="barChart" style="margin: 50px; width:60%;max-width:800px"></canvas>;
</div>

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
		 

		//write sql
		$sql = "Select P.Product_name as 'Product', sum(O.quantity) as 'Quantity Purchased'
        from products P
        inner join order_items O
        using(product_id)
        group by P.Product_name
        order by (O.quantity) desc";

        $sql_products = "select products.Product_name as 'Product',  round(avg(rating),2 ) as 'Average rating'
        from rating
        right join products
        on rating.product_id = products.product_id
        group by product_name
        order by avg(rating) desc";

		//execute sql
		$result = $conn->query($sql);
        $rating_query = $conn->query($sql_products);

		//check if any record was found
		if ($result->num_rows > 0){
			//create an array
			$products  = array();
			$quantity = array();
			  // loop through the query result and fetch one record at a time
			  while($row = $result->fetch_assoc()) {
				  	array_push($products, $row["Product"]);
					array_push($quantity, $row["Quantity Purchased"]);
			   }

		}
		else{
			echo("No records found");
		}

        if ($rating_query->num_rows > 0){
			$rating = array();
			  // loop through the query result and fetch one record at a time
			  while($row = $rating_query->fetch_assoc()) {
					array_push($rating, $row["Average rating"]);
			   }

		}
		else{
			echo("No records found");
		}

		//close the connection to database
		$conn->close();
	?> 
	<script>
	var xValues = <?php  echo json_encode($products) ?>;
	var yValues = <?php echo json_encode($quantity)?>;
	var barColors = ["red", "blue", "yellow", "green", "purple", "orange", "pink", "violet", "#ffd74c", "#00e5ff", "#ffebee", "#7bffa2"];

	var ratings = <?php echo json_encode($rating)?>;

    new Chart("barChart", {
	  type: "bar",
	  data: {
	    labels: xValues,
	    datasets: [{
	      backgroundColor: barColors,
	      data: yValues
	    }]
	  },
	  options: {
	    legend: {display: false},
	    title: {
	      display: true,
	      text: "Top Products Based on the Quantity Purchased"
	    }
	  }
	});

	new Chart("myChart", {
	  type: "bar",
	  data: {
	    labels: xValues,
	    datasets: [{
	      backgroundColor: barColors,
	      data: ratings
	    }]
	  },
	  options: {
	    legend: {display: false},
	    title: {
	      display: true,
	      text: "Top Products Based on the Average Rating of customers"
	    }
	  }
	});
   
	</script>


</body>
</html>