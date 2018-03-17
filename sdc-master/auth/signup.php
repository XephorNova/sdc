	<?php 
	require '../config/config.php';

	//Form submits
	if(isset($_POST['submit'])) {
		$somaiya_id = mysqli_real_escape_string($connec, $_POST['s_id']);
		$name = mysqli_real_escape_string($connec, $_POST['name']);
		$u_name = mysqli_real_escape_string($connec, $_POST['u_name']);
		$pass = mysqli_real_escape_string($connec, $_POST['pass']);

		//Error handlers
		if(empty($somaiya_id) || empty($u_name) || empty($name) || empty($pass)) {
			exit();
		} else {
			//Check for valid characters
			if(!preg_match("/^[a-zA-Z]*$/", $u_name)) {
				echo 'ENTER VALID CHARACTERS';
				exit();
			} else {

				//Check if username already exists
				$query = "SELECT * FROM users WHERE somaiya_id='$somaiya_id'";
				$result = mysqli_num_rows(mysqli_query($connec, $query));

				if($result > 0) {
					echo 'Username exists';
				} else {
					//Hash the password
					$hashedPWD = password_hash($pass, PASSWORD_DEFAULT);

					//Create a user
					$query = "INSERT INTO users (somaiya_id, user_name, user_uid, user_pass) VALUES ('$somaiya_id', '$name', '$u_name', '$hashedPWD')";

					if(!mysqli_query($connec, $query)) {
						echo 'Error description: '. mysqli_error($connec);
					} else {
						header("Location: ./login.php");
						exit();
					}
				}
			}
		}
	}

?>

	<?php include('../includes/header.php'); ?>
	<head>
		<link rel="stylesheet" href="../assets/styles.css">
    	<title>Sign Up</title>
	</head>
	<div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
      <?php if(!isset($_SESSION['user_id']) && !isset($_SESSION['admin_id'])) { 
        echo '
      <li class="nav-item">
        <a class="nav-link" href="../index.php">Home</a>
      </li>
      <li class="nav-item">
         <a href="./login.php" class="nav-link">Login</a>
       </li>
       <li class="nav-item">
         <a href="./signup.php" class="nav-link">Signup</a>
       </li>
       ';
        }
       ?>
    </ul>
  </div>
  </div>
</nav>

	<div class="container mt-4">
		<h2>Signup</h2>
		<form class="mt-4" action="./signup.php" method="POST">
			<div class="form-group">
				<label for="name">Somaiya ID: </label>
				<input class="form-control" type="number" name="s_id" placeholder="Your Somaiya ID" required>
			</div>
			<div class="form-group">
				<label for="name">Name: </label>
				<input class="form-control" type="text" name="name" placeholder="John Smith" required>
			</div>
			<div class="form-group">
				<label for="u_name">Username: </label>
				<input class="form-control" type="text" name="u_name" placeholder="john" required>
			</div>
			<div class="form-group">
				<label for="pass">Password: </label>
				<input class="form-control" type="password" name="pass" required>
			</div>
			<input class="btn btn-success" type="submit" name="submit" value="Create">
		</form>
	</div>
<?php include('../includes/footer.php') ?>
