<head>
    <link rel="stylesheet" href="../assets/styles.css">
    <title>User - Home</title>
</head>

<?php include('../includes/header.php') ?>
<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
        <?php 
            if(isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            echo '
             <li class="nav-item">
                <a class="nav-link mr-4" href="./user.php">Home</a>
            </li>';

            $out = '<form action="../auth/logout.php" class="form-inline my-2" method="POST">
                    <button type="submit" name="submit" class="btn btn-light btn-sm my-2 my-sm-0">Logout</button>
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
        if (isset($_SESSION['user_id'])) {
            echo '<div class="jumbotron" style="background: none">
                    <h1 class="display-5 text-center">Welcome to the Cloud</h1>
                    <hr class="my-4">
                    <p class="lead">
                    <div class="wrap-user-buttons">
                      <!-- <a href="createFlavor.php"><button class="btn btn-primary">Create Flavor</button></a> -->
                      <a href="listFlavors.php"><button class="btn btn-primary">List Flavors</button></a>
                      <a href="create_instance.php"><button class="btn btn-primary">Create Instance</button></a>
                      <a href="show_instance.php"><button class="btn btn-primary">Show Instance</button></a>
                    </div>
                    </p>
                </div>';
        }

     ?>
</div>
<?php include('../includes/footer.php') ?>

