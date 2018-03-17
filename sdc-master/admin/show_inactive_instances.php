<?php
 	include('../includes/header.php');
  	require '../config/config.php';
	<head>
<link rel="stylesheet" href="../assets/styles.css">
    	<title>Show Inactive Requests- Admin</title>
	</head>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <?php 
            if(isset($_SESSION['admin_id'])) {
            echo '
            	<li class="nav-item">
               	 <a class="nav-link" href="./admin.php">Home</a>
            	</li>
                <form action="../auth/logout.php" class="form-inline" method="POST">
                    <button type="submit" name="submit" class="btn btn-light ml-4 btn-sm">Logout</button>
                </form>
            ';
        }
         ?>
         </ul>
  </div>
  </div>
</nav>
	<div class="container mt-4">
		<?php echo $output; ?>
		<table class="table">
			<thead>
				<tr>
					<th scope="col">ID</th>
					<th scope="col">Somaiya ID</th>
	                <th scope="col">Instance Name</th>
	                <th scope="col">Flavor Name</th>
	                <th scope="col">Image Name</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//Create a query to select all from db.
				    $query = 'SELECT * FROM Inactive_log_data';
				    $result = mysqli_query($connec, $query);

				    //Get the inactive instances as an array from DB.
				    $instances = mysqli_fetch_all($result, MYSQLI_ASSOC);
				    
				    //Loop through the array and display them to the user
				    for($i = 0; $i < count($instances); $i++) {
				    	echo '<tr>';
				    	echo "<th scope=`row`>{$instances[$i][id]}</th>";
				    	echo "<th scope=`row`>{$instances[$i][somaiya_id]}</th>";
				    	echo "<td>{$instances[$i][instance_name]}</td>";
				    	echo "<td>{$instances[$i][instance_flavor_name]}</td>";
				    	echo "<td>{$instances[$i][instance_image_name]}</td>";
					echo '</tr>';
				   }
				    mysqli_free_result($result);
				    //Close the connection
				    mysqli_close($connec);
				?>
			</tbody>
		</table>
	</div>
 <?php include('../includes/footer.php') ?>