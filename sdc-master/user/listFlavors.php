<?php 
	function listFlavors($fileName) {
        $output=shell_exec($fileName);
        //var_dump($output);
        $outputSplit = explode("\n",$output);
        $outputRows = explode($outputSplit[0],$output);
        $outputRows = array_values(array_filter(array_map('trim',$outputRows)));
        //print_r($outputRows);
        $column = $outputRows[0];
        $values = $outputRows[1];
      
        $valueRow = explode("\n",$outputRows[1]);
        $val = array_diff($valueRow, array('+----+-----------+-------+------+-----------+-------+-----------+', '| ID | Name      |   RAM | Disk | Ephemeral | VCPUs | Is Public |'));
        $t2 = array();
        $value = array();
        foreach($val as $x) {
            $t1 = explode("|",$x);
            //$t2 = array_values(array_filter(array_map('trim', $t1)));
            $t2 = array_filter(array_map('trim', $t1), function($value) { return $value !== ''; });
            array_push($value,$t2);
        }
        /*foreach($val as $x) {
                $y = explode("|",$x);
                $y = array_values(array_filter(array_map('trim',$y)));
                array_push($value,$y);
        }*/
        //print_r($value);
        return $value;
        }
 ?>


<?php include('../includes/header.php') ?>
<head>
    <link rel="stylesheet" href="../assets/styles.css">
    <title>List all the flavors - User</title>
</head>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(isset($_SESSION['user_id'])) { 
        echo '
      <li class="nav-item">
        <a class="nav-link" href="./user.php">Home</a>
      </li>
       ';
        }
       ?>
    </ul>
  </div>
  </div>
</nav>
<!-- On acceptance from admin, flavors which are accepted will be seen over here -->
<div class="container mt-4">
    <table class="table">
        <thead>
            <tr>
                <th scope="col">ID</th>
                <th scope="col">Name of the Flavor</th>
                <th scope="col">RAM (MB)</th>
                <th scope="col">VCPU</th>
                <th scope="col">Disk (GB)</th>
            </tr>
        </thead>
    <tbody>
        <?php 
           $res = listFlavors('. /home/theiyd/admin-openrc.sh;openstack flavor list');
           //print_r($res);
		for($i=0; $i < count($res); $i++) {
			echo '<tr>';
			echo "<th scope=`row`>{$res[$i][1]}</th>";
			echo "<td>{$res[$i][2]}</td>";
			echo "<td>{$res[$i][3]}</td>";
			echo "<td>{$res[$i][6]}</td>";
			echo "<td>{$res[$i][4]}</td>";
			echo '</tr>';
		}
	?>
	
        </tbody>
    </table>
</div>

<?php include('../includes/footer.php') ?>
