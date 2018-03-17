<?php 
  
  require '../config/config.php';
  session_start();

if (isset($_POST['instance_submit'])) {
  $user_somaiya_id = mysqli_real_escape_string($connec, $_SESSION['user_s_id']);
  $instance_name = mysqli_real_escape_string($connec, $_POST['instance_name']);
  $flavor_name = mysqli_real_escape_string($connec, $_POST['flavor_name']);
  $image_name = mysqli_real_escape_string($connec, $_POST['image_name']);

  $output = '';
  //var_dump($instance_name);
  $query = "INSERT INTO instance_data (somaiya_id, instance_name, instance_flavor_name, instance_image_name) VALUES ('$user_somaiya_id', '$instance_name', '$flavor_name', '$image_name')";
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
                      <strong>Success. Wait for approval.</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        }
}	
function listOutput($fileName) {
  $output=shell_exec($fileName);
  //var_dump($output);
  $outputSplit = explode("\n",$output);
  $outputRows = explode($outputSplit[0],$output);
  $outputRows = array_values(array_filter(array_map('trim',$outputRows)));
  //print_r($outputRows);
  $column = $outputRows[0];

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
    return $value;
}
            ?>
            <?php include('../includes/header.php') ?>
            <head>
              <link rel="stylesheet" href="../assets/styles.css">
              <title>Create an Instance - User</title>
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
            <div class="container mt-4">
              <?php echo $output; ?>
              <!-- Let the user create a VM instance by submitting the form below -->
              <h2>Create an Instance</h2>

              <div class="row">
                <div class="col-md-4">
                  <form method="post" action="./create_instance.php">
                    <div class="form-group row">
                      <div class="col-6">
                        <label for="instance_name">Instance name</label>
                        <input type="text" name="instance_name" class="form-control" value='<?php echo $_SESSION['user_id']; ?>'>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="flavor_name">Flavors Available</label>
                      <select name="flavor_name" id="flavor_name" onchange="valueselect(this.value);">
                        <?php
                          $flavorDetails = listOutput('. /home/theiyd/admin-openrc.sh;openstack flavor list'); 
                          //print_r($flavorDetails);
                          for($i=0; $i < count($flavorDetails); $i++) {
                            echo "<option value='{$flavorDetails[$i][2]}'>{$flavorDetails[$i][2]}</option>";
                          }
                        ?>
                        <!--<option value="t1">test1</option>
                        <option value="t2">test2</option>
                        <option value="t3">test3</option>
                        <option value="t4">test4</option>
                        <option value="t5">test5</option>-->
                      </select><br>

                      <!-- Button trigger modal 
                      <button type="button" class="btn btn-dark" data-toggle="modal" data-target="#exampleModal">
                        Show all flavors
                      </button>-->
                    </div>

                    <!-- Modal -->
                    <!--<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">All Flavors</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <div class="container mt-4">
                              <table class="table">
                                  <thead class="thead-dark">
                                      <tr>
                                          <th scope="col">ID</th>
                                          <th scope="col">Flavor</th>
                                          <th scope="col">RAM (MB)</th>
                                          <th scope="col">VCPU</th>
                                          <th scope="col">Disk (GB)</th>
                                      </tr>
                                  </thead>
                              <tbody>
                                  <?php 
                                     $res = listOutput('. /home/controller/admin-openrc;openstack flavor list');
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
                          </div>
                          <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          </div>
                        </div>
                      </div>
                    </div>-->

                    <div class="form-group">
                      <label for="image_name">Image name</label>
                      <select name="image_name" id="image_name">
                        <?php
                        $images = listOutput('. /home/theiyd/admin-openrc.sh;openstack image list');
                        //print_r($result);
                        for($x=0; $x < count($images); $x++) {
                          echo "<option value='{$images[$x][2]}'>{$images[$x][2]}</option>";
                        }
                        
                        ?>
                      </select>
                    </div>
                <input type="submit" value="Submit" name="instance_submit" class="btn btn-success">
              </form>
                </div>
                <div id="flavorDetail" class="col-md-8"></div>
            </div>

            <script>
              function valueselect(val) {
                let flavor_details = <?php echo(json_encode($flavorDetails)); ?>;
                console.log(flavor_details);
                //history.pushState(null, '', `/cloud/user/create_instance.php?q=${val}`);

                for(let i=0; i < flavor_details.length; i++) {
                  if(flavor_details[i][2] == val) {
                    console.log(flavor_details[i]);
                    document.querySelector('#flavorDetail').innerHTML = `
                      <table class="table">
                        <thead class="thead-dark">
                          <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Flavor</th>
                            <th scope="col">RAM (MB)</th>
                            <th scope="col">VCPU</th>
                            <th scope="col">Disk (GB)</th>
                          </tr>
                        </thead>

                        <tbody>
                          <tr>
                            <th scope="row">${flavor_details[i][1]}</th>
                              <td>${flavor_details[i][2]}</td>
                              <td>${flavor_details[i][3]}</td>
                              <td>${flavor_details[i][6]}</td>
                              <td>${flavor_details[i][4]}</td>
                          </tr>
                        </tbody>
                      </table>
                    `;
                  }
                }
              }

            </script>

            <?php include('../includes/footer.php') ?>
