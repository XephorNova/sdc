<?php 

	include('../includes/header.php');
	require '../config/config.php';

	if(isset($_POST['login'])) {
		$u_name = mysqli_real_escape_string($connec, $_POST['u_name']);
		$pass = mysqli_real_escape_string($connec, $_POST['pass']);

		if($u_name == 'admin' && $pass == 'admin123') {
			$_SESSION['admin_id'] = 'admin';
			$_SESSION['admin_pwd'] = 'admin123';
			header("Location: ../admin/admin.php");
		}

		//Error handlers
		if (empty($u_name) || empty($pass)) {
			echo 'SOMETHING IS EMPTY';
			exit();
		} else {
			$query = "SELECT * FROM users WHERE user_uid='$u_name'";
			$result = mysqli_num_rows(mysqli_query($connec, $query));

			if($result < 1) {
				echo 'USERNAME NOT FOUND';
				exit();
			} else {
 				if($row = mysqli_fetch_assoc(mysqli_query($connec, $query))) {
 					//De-hash the password
 					$dehashedPass = password_verify($pass, $row['user_pass']);
 					if($dehashedPass == false) {
 						echo 'PASSWORD INVALID';
 						exit();
 					} elseif ($dehashedPass == true) {
 						//Log in the user over here
 						$_SESSION['user_id'] = $row['user_uid'];
 						$_SESSION['user_name'] = $row['user_name'];
 						$_SESSION['user_s_id'] = $row['somaiya_id'];
 						header("Location: ../user/user.php");
 						exit();
 					}
 				}
			}
		}
	}
?>
	<head>
		<link rel="stylesheet" href="../assets/styles.css">
    	<title>Login - Home</title>
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
	<form action="./login.php" method="POST">
		<div class="form-group">
			<label for="u_name">Username: </label>
			<input type="text" name="u_name" required class="form-control">
		</div>
		<div class="form-group">
			<label for="pass">Password: </label>
			<input type="password" name="pass" required class="form-control">
		</div>
		<input type="submit" class="btn btn-light" style="background: rgba(136, 0, 21, 1) !important;
	border: none; color: #fff;" name="login" value="Login">
	</form>
</div>

<?php include('../includes/footer.php') ?>