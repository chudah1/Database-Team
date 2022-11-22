<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tranquillo Ecommerce Database</title>
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
		$sql = "select P.Package_name as 'Package', count(S.package_id) as 'Number of Subscribers'
		from Packages P
		inner join Subscribers S
		using(package_id)
		group by P.Package_name
		order by count(S.package_id) desc";

		print_r($sql);
		//execute sql
		$result = $conn->query($sql);
		//check if any record was found
		if ($result->num_rows > 0){
			//create an array
			$packages_list  = array();
			$subscribers = array();
			  // loop through the query result and fetch one record at a time
			  while($row = $result->fetch_assoc()) {
				  	array_push($packages_list, $row["Package"]);
					array_push($subscribers, $row["Number of Subscribers"]);
			   }

		}
		else{
			echo("No records found");
		}

		//close the connection to database
		$conn->close();
	?> 

	<canvas id="myChart" style="margin: 50px; width:60%;max-width:400px"></canvas>

	<script>
	var xValues = <?php  echo json_encode($packages_list) ?>;
	var yValues = <?php echo json_encode($subscribers)?>;
	var barColors = ["red", "blue"];

	new Chart("myChart", {
	  type: "doughnut",
	  data: {
	    labels: xValues,
	    datasets: [{
	      backgroundColor: barColors,
	      data: yValues
	    }]
	  },
	  options: {
	    legend: {display: true},
	    title: {
	      display: true,
	      text: "Most Preferred Subscribed Package"
	    }
	  }
	});
	</script>


</body>
</html>