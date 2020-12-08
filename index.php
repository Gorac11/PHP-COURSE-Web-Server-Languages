<html>
<body>
	<form action="" method="POST">
		<b>Username: </b><input type="text" name="username"><br><br>

		<b>Password: </b><input type="text" name="password"><br><br>

		<input type="submit" name="sub" value="Login">
		<input type="submit" name="redirectRegisterButton" value="To Registration" />

	<form>
</body>
</html>
<?php 
require_once('db.php');

if(isset($_POST['redirectRegisterButton'])) {
	header("Location: register.php");
}

if(isset($_POST['sub'])) {
	$username = $_POST['username'];
	$password = $_POST['password'];

	$conn = DbHelper::GetConnection();
	$stm = $conn->query("SELECT * FROM users where username='$username' and password='$password'");
	$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
	if($rows){
	header("Location: taskTable.php");
	}
	else{
	echo '<span style="color:red;"> Login failed </span>';
	}
}
?>