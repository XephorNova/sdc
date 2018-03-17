<head>
    <link rel="stylesheet" href="assets/styles.css">
    <title>Cloud - Home</title>
</head>

<?php include('includes/header.php') ?>

<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) { 
        echo '
      <li class="nav-item">
        <a class="nav-link" href="index.php">Home</a>
      </li>
      <li class="nav-item">
         <a href="auth/login.php" class="nav-link">Login</a>
       </li>
       <li class="nav-item">
         <a href="auth/signup.php" class="nav-link">Signup</a>
       </li>
       ';
        } elseif (isset($_SESSION['user_id']) || isset($_SESSION['admin_id'])) {
            echo '
                <form action="auth/logout.php" class="form-inline" method="POST">
                    <button type="submit" name="submit" class="btn btn-outline-secondary btn-sm">Logout</button>
                </form>
            ';
        }
       ?>
    </ul>
  </div>
  </div>
</nav>
<!-- This is the homepage-->
<div class="container mt-4">
    <div class="jumbotron" style="background: none">
        <h1 class="display-5 text-center">Home Page</h1>
        <hr>
        <p class="lead text-center">SignUp to create an instance !</p>
    </div> 
</div>
<?php include('includes/footer.php') ?>

