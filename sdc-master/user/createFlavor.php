<?php 
    if (isset($_POST['submit-form'])) {
        $flavorName = escapeshellarg($_POST['flavorName']);
        $ram = escapeshellarg($_POST['RAM']);
        $vcpu = escapeshellarg($_POST['VCPU']);
        $disk = escapeshellarg($_POST['DISK']);
        $output = '';
        
        $temp = shell_exec('. /home/controller/admin-openrc;openstack flavor create --id auto --vcpu '.$vcpu.' --ram '.$ram.' --disk '.$disk.' '.$flavorName);
        //print_r($temp);

        if(!temp) {
            $output = '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                      <strong>Error</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        } else {
             $output = '<div class="alert alert-success alert-dismissible fade show" role="alert">
                      <strong>Success</strong>
                      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                      </button>
                    </div>';
        }   

        header("refresh:2; url=index.php");
    }
    ?> 

<?php include('../includes/header.php') ?>
    <head>
        <link rel="stylesheet" href="../assets/styles.css">
        <title>Create a Flavor - User</title>
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
<!-- Let the user create a flavor by filling up the form below -->
<form action="" method="POST">
        <div class="form-group">
            <label for="flavorName">Name of flavor</label>
            <input name="flavorName"  type="text" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="RAM">RAM</label>
            <input name="RAM" type="number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="VCPU">VCPU</label>
            <input name="VCPU" type="number" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="DISK">DISK</label>
            <input name="DISK" type="number" class="form-control" required>
        </div>
        <input type="submit" name="submit-form" class="btn btn-success">
    </form>
</div>

<?php include('../includes/footer.php') ?>
    
