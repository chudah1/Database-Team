<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Tranquillo Ecommerce Databse</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
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
				<a class="nav-link" href="#home">Home <span class="sr-only">(current)</span></a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="#about">Packages</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="#projects">Product Category Revenue</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="#contact">Rated Products</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="#contact">Top Product Category</a>
				</li>
				<li class="nav-item mx-3">
				<a class="nav-link" href="#contact">Preferred Payments</a>
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
		$dbname = "ecommerce_database";

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

		//execute sql
		$result = $conn->query($sql);
		//check if any record was found
		if ($result->num_rows > 0){
			//create an array
			$packages_list  = array();
			$subscribers = array();
			  // loop through the query result and fetch one record at a time
			  while($row = $result->fetch_assoc()) {
				  	//add record to array 
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

	<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

	<script>
	var xValues = <?php  
				//echo the array list on 39 and 46 as json list of items
				echo json_encode($packages_list)?>;
	var yValues = <?php
	echo json_decode($subscribers)?>;
	var barColors = ["red", "green","blue", "yellow"];

	new Chart("myChart", {
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
	      text: "Most Preferred Subscribed Package"
	    }
	  }
	});
	</script>


</body>
</html>