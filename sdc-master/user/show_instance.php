<?php 

  require '../config/config.php';

//Function to which accepts the script
function showInstances($comm) {
  $output=shell_exec($comm);
  //var_dump($output);
  $outputSplit = explode("\n",$output);
  $outputRows = explode($outputSplit[0],$output);
  $outputRows = array_values(array_filter(array_map('trim',$outputRows)));
  //print_r($outputRows);
  $values = $outputRows[1];
  $valueRow = explode("\n",$values);
  $value = array();
  $result = array();
  foreach($valueRow as $x) {
          $y = explode("|",$x);
          $y = array_values(array_filter(array_map('trim',$y)));
          array_push($value,$y);
  }foreach ($value as $x) {
          $result[$x[0]] = $x[1];
  }
  return $result;
}
 ?>
 <?php include('../includes/header.php') ?>
<head>
    <link rel="stylesheet" href="../assets/styles.css"> 
    <title>Show Instances - User</title>
</head>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(isset($_SESSION['user_id'])) { 
        echo '
      <li class="nav-item">
        <a class="nav-link" href="./user.php">Home</a>
      </li>
       ';
       $out = '<form action="../auth/logout.php" class="form-inline my-2" method="POST">
                    <button type="submit" name="submit" class="btn btn-outline-secondary btn-sm my-2 my-sm-0">Logout</button>
                </form>';
        }
       ?>
    </ul>
    <ul class="navbar-nav">
      <?php echo $out; ?>
    </ul>
  </div>
  </div>
</nav>
<div class="container">
    <h3> Show Instances</h3>
    <?php

        /* Show instance as per the current user logged in.  */
        $currentUserName = $_SESSION['user_id'];
	
	$query = "SELECT * FROM instance_id_data WHERE user_name='$currentUserName'";
	$tempRes = mysqli_query($connec, $query);
	//print_r($tempRes);
	//Get the instances as an array from db
	$instanceID = mysqli_fetch_all($tempRes, MYSQLI_ASSOC);
	print_r($instanceID[0][instance_id]);
        $result = showInstances('. /home/controller/admin-openrc;openstack console url show '.$instanceID[0][instance_id]);
	print_r($result);
	echo "<a href={$result['url']} target='_blank'>Open Instance</a>";
        ?>
</div>

<?php include('../includes/footer.php') ?>
