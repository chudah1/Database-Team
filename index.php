<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Ecommerce_databse</title>
	<!-- //connect to the library -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
</head>
<body>
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
		$sql = "SELECT * FROM `customers`";
		$sql = " "

		//execute sql
		$result = $conn->query($sql);
		//check if any record was found
		if ($result->num_rows > 0){
			//create an array
			$country_list  = array();
			  // loop through the query result and fetch one record at a time
			  while($row = $result->fetch_assoc()) {
				  	//add record to array 
				  	//the curtomer_counrtry is a field/column in the customer table based on the query on line 27
				  	array_push($country_list, $row["firstname"]);
			   }

		}//end of  if condition
		else{
			echo("No records found");
		}

		//close the connection to database
		$conn->close();
	?> 

	<canvas id="myChart" style="width:100%;max-width:600px"></canvas>

	<script>


	// example of record coming from database below
	var xValues = <?php  
				//echo the array list on 39 and 46 as json list of items
				echo json_encode($country_list)
				?>;
	
	// the data list below are hardcoded
	var yValues = [55, 49, 44,40, 50];
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
	      text: "World Wine Production 2018"
	    }
	  }
	});
	</script>


</body>
</html>