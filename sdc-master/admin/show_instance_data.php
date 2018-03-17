<?php
 	include('../includes/header.php');
  	require '../config/config.php';

	$output = '';
        // Get Instance ID function
	function getInstanceID($input) {
	   //echo $input;
  	   $temp2 = array();
           $inputSplit = explode("\n", $input[0]);
	   //print_r($inputSplit);
           $inputR = explode($inputSplit[0], $input);
           $inputR = array_values(array_filter(array_map('trim',$inputR)));
	   //print_r($inputR);
           $valRow = explode("\n", $inputR[5]);
           /*foreach($valRow as $y) {
              $temp1 = explode("|", $y);
              $temp2 = array_filter(array_map('trim', $temp1));
           }*/
	   $temp1 = explode("|", $valRow[15]);
	   $temp2 = array_filter(array_map('trim', $temp1));
           return $temp2[2];
	   //return '7496e629-7d8a-4c25-959f-239f7bc28a14';
        }

	//Enter into block if flag is true
	if(isset($_GET['flag'])) {
		$accept = $_GET['ACCEPT'];
		//print_r($accept);
		//Get all names from params passed to url
		$flavor_name = escapeshellarg($_GET['flavorName']);
		$instance_name = escapeshellarg($_GET['instanceName']);
		$image_name = escapeshellarg($_GET['imageName']);
		$user_name = escapeshellarg($_GET['user_name']);

	       //print_r($flavor_name, $instance_name, $image_name);	
		if($accept == 'true') {
			//var_dump($user_name, $flavor_name, $instance_name, $image_name);

			//Create an instance when ACCEPT button clicked.
			//This asks for Openstack password in my case. Should not be asking after deployment.
			$command = shell_exec('. /home/controller/demo-openrc;openstack server create --flavor '.$flavor_name.' --image cirros \
  --nic net-id=2a21b5d7-b47d-4a09-a6f8-8326eece003b --security-group default \
  --key-name mykey '.$instance_name.' 2>&1');
			//print_r($command);

			//if($command) {
			   $instance_id = getInstanceID('temp');
			   //print_r($instance_id);
			   $query = "INSERT INTO instance_id_data (user_name, instance_id) VALUES ($user_name, '$instance_id')";
			   //print_r($query);

                           if(!mysqli_query($connec, $query)) {
          			echo "Error" . mysqli_error($connec);
          			$output = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      				<strong>Error</strong>
                      				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        				<span aria-hidden="true">&times;</span>
                      				</button>
                    		           </div>';
        		  } else {
          			$output = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      				<strong>Success.</strong>
                      				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        				<span aria-hidden="true">&times;</span>
                      				</button>
                    			   </div>';
            			}
			//}
		} 
		else if($accept == 'false') {
			//INSERT the record into Inactive_log_data if Request is declined!!!
			$query = "INSERT INTO Inactive_log_data (user_name, instance_id) VALUES ($user_name, '$instance_id',$flavor_name,$image_name)";
			if(!mysqli_query($connec, $query))
			{
				echo "Error to insert" . mysqli_error($connec);
				$output = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
	                      <strong>ERROR!!!</strong>
	                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	                        <span aria-hidden="true">&times;</span>
	                      </button>
	                    </div>';
            } 
			else {
            	$output = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>Instance deactivated and not created.</strong>
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>';
            }
		}
		
	}
 ?>
 	<head>
 		<link rel="stylesheet" href="../assets/styles.css">
    	<title>Show Instances - Admin</title>
	</head>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <?php 
            if(isset($_SESSION['admin_id']))
	    {
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
	                <th scope="col">Accept</th>
	                <th scope="col">Decline</th>
				</tr>
			</thead>
			<tbody>
				<?php
					//Create a query to select all from db.
				    $query = 'SELECT * FROM instance_data';
				    $result = mysqli_query($connec, $query);

				    //Get the instances as an array from DB.
				    $instances = mysqli_fetch_all($result, MYSQLI_ASSOC);
				    
				    //Loop through the array and display them to the user
				    for($i = 0; $i < count($instances); $i++) {
				    	echo '<tr>';
				    	echo "<th scope=`row`>{$instances[$i][id]}</th>";
				    	echo "<th scope=`row`>{$instances[$i][somaiya_id]}</th>";
				    	echo "<td>{$instances[$i][instance_name]}</td>";
				    	echo "<td>{$instances[$i][instance_flavor_name]}</td>";
				    	echo "<td>{$instances[$i][instance_image_name]}</td>";
				    	//Create Accept and Decline buttons. Pass the current username logged in, flavor name, instance name, image name to the url. 
				    	echo "<td><a href='./show_instance_data.php?flag=true&ACCEPT=true&user_name={$instances[$i][instance_name]}&flavorName={$instances[$i][instance_flavor_name]}&instanceName={$instances[$i][instance_name]}&imageName={$instances[$i][instance_image_name]}'><button role='button' class='btn btn-success'>Accept</button><a/></td>";
				    	echo "<td><a href='./show_instance_data.php?flag=true&ACCEPT=false&flavorName={$instances[$i][instance_flavor_name]}&instanceName={$instances[$i][instance_name]}&imageName={$instances[$i][instance_image_name]}'><button role='button' class='btn btn-danger'>Decline</button><a/></td>";
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
