<head>
    <link rel="stylesheet" href="../assets/styles.css">
	<title>Admin</title>
</head>

<?php include('../includes/header.php') ?>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <?php 
            if(isset($_SESSION['admin_id'])) {
            echo '
            	<li class="nav-item">
                	<a class="nav-link" href="./admin.php">Home</a>
            	</li>';

            $out = '<form action="../auth/logout.php" class="form-inline my-2" method="POST">
                    <button type="submit" name="submit" class="btn btn-light btn-sm my-2 my-sm-0 ml-4">Logout</button>
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
	
	<div class="container mt-4">
		<?php 
			if(isset($_SESSION['admin_id'])) {
				echo '<div class="jumbotron" style="background: none">
        <h1 class="display-4 text-center">Admin Home</h1>
        <p class="lead wrap-user-buttons">
	        <a href="./show_instance_data.php"><button class="btn btn-primary">Show Instance Data</button></a>
		<a href="./show_inactive_instances.php"><button class="btn btn-primary">Show Inactive Instances</button></a>
        </p>';
			}

		 ?>
        
    </div> 
	</div>
<?php include('../includes/footer.php') ?>
