<?php require_once("includes/connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/constants.php"); ?>


<?php
$error = "";

if(isset($_POST['submit'])){
	if (empty($_POST['uname']) || empty($_POST['pwd'])) {
		$error = "Username or Password is invalid";
		//echo "not set";
	}
	else{
		
		$username = $_POST['uname']; 
		$password = $_POST['pwd'];
		
		$username = mysql_prep($username, $connection);
		$password = md5(mysql_prep($password, $connection));
		
		$query = mysqli_query($connection,"SELECT * from users where Password='$password' AND Email='$username'");
		if($query == FALSE){
			$error = "Username or Password is invalid";
			echo mysqli_error($connection);
			die(mysql_error());
		}
		
		$rows = mysqli_num_rows($query);
		
			if ($rows != 1) {
				$error = "Username or Password is invalid";	
			} else {
				session_start();
				$_SESSION['user'] = $username; // Initializing Session
				$_SESSION['role'] = getdesignationbyid($username, $connection);
				
				$usr = md5($username);
				if(isset($_SESSION['user']))
					{
					redirect_to("dashboard.php"); // Redirecting To Other Page
					}
			}
			
		
		}
}

?>

<?php require_once("includes/footer.php"); ?>