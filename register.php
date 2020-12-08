<?php		
	require_once('db.php');
	$conn = DbHelper::GetConnection();
?>
<html>
<head>		
<style type="text/css">		
</style>	
</head>
<body>
	<?php 
		function setValue( $fieldName ) {
			if ( isset( $_POST[$fieldName] ) ) {
				echo $_POST[$fieldName];
			}
		}
		$errors = array();
		
		if(isset($_POST['btnSubmit'])) {

			if(!isset($_POST['tbUsername']) || strlen($_POST['tbUsername']) < 3 || strlen($_POST['tbUsername']) > 20) {
				$errors[] = "Invalid Username! Length must be between 3-20";
			}
			if(!isset($_POST['tbPassword']) || !isset($_POST['tbPasswordAgain']) || $_POST['tbPasswordAgain'] != $_POST['tbPassword']) {
				$errors[] = "Passwords don't match!";
			}

			$password=$_POST['tbPassword'];
			
			if( !preg_match("/^.*(?=.*[_*&$])(?=.*[0-9]{2,})(?=.*[a-zA-Z]).*$/", $password ) ) {
				$errors[] = "Password must include at least: one upper or lower case latin letter,
				 one special symbol (_*&$) and 2 digits!
				";
			}
			
			if(count($errors) == 0 ) {				
				$stm = $conn->prepare('INSERT INTO users(username, password) VALUES(?, ?)');
			$stm->execute(array($_POST['tbUsername'], $_POST['tbPassword']));
				
				header("Location: taskTable.php");
			} 
		}
		
		if(count($errors) > 0) {
		?>
			<ul style="color: red;">
				<?php
					foreach($errors as $e) {
						echo "<li>$e</li>";
					}
				?>
			</ul>
		<?php
		}
	?>
	<form method="post">
		<p>
			<label for="tbUsername" >Потребителско име:</label>
			<input type="text" id="tbUsername" name="tbUsername" value="<?= setValue("tbUsername")?>" />
		</p>
		<p>
			<label for="tbPassword">Парола:</label>
			<input type="text" id="tbPassword" name="tbPassword"  />
		</p>
		<p>
			<label for="tbPasswordAgain">Парола(отново):</label>
			<input type="password" id="tbPasswordAgain" name="tbPasswordAgain" />
		</p>
		<p>
			<input type="submit" value="Register" name="btnSubmit" />
		</p>
	</form>
</body>
</html>