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
		$sql = "select category_name as 'Category', sum(`Total Revenue`) as `Total Revenue`,  
		round(sum(`Total Revenue`)*100/(select sum(Unit_price*quantity) 
		from products as P, order_items as O where P.product_id=O.product_id),2) as 'Percentage of Revenue'
		from(
		select C.category_name, P.Unit_price*O.quantity as 'Total Revenue'
		from products P
		inner join 
		order_items O
		on O.product_id= P.product_id
		inner join Product_categories C
		using(Category_id) ) as s
		group by  category_name
		order by `Total Revenue` desc LIMIT 5";

		//execute sql
		$result = $conn->query($sql);
		//check if any record was found
		if ($result->num_rows > 0){
			$categories  = array();
			$revenue = array();
			$percentage_count =array();
			  // loop through the query result and fetch one record at a time
			  while($row = $result->fetch_assoc()) {
				  	array_push($categories, $row["Category"]);
					array_push($revenue, $row["Total Revenue"]);
					array_push($percentage_count, $row["Percentage of Revenue"]);

			   }

		}
		else{
			echo("No records found");
		}

		//close the connection to database
		$conn->close();
	?> 

	<canvas id="bar" style="margin: 70px; width:100%;max-width:800px"></canvas>
	<canvas id="pie" style="margin: 50px; width:100%;max-width:500px"></canvas>


	<script>
	var xValues = <?php  echo json_encode($categories) ?>;
	var yValues = <?php echo json_encode($revenue)?>;
	var percentages = <?php echo json_encode($percentage_count)?>;

	var barColors = ["#fb5c00", "#c0ca32", "#00897b", "#3949ab", "#d81b60", "#827717"];

	new Chart("bar", {
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
	      text: "Revenue From Each Product Category"
	    }
	  }
	});

	new Chart("pie", {
	  type: "doughnut",
	  data: {
	    labels: xValues,
	    datasets: [{
	      backgroundColor: barColors,
	      data: percentages
	    }]
	  },
	  options: {
	    legend: {display: true},
	    title: {
	      display: true,
	      text: "Revenue From Each Product Category In Percentages"
	    }
	  }
	});
	</script>


</body>
</html>