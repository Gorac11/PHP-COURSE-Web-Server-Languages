<?php		//THIS PAGE CAN WORK AS REGISTRATION...  I THINK
	require_once('db.php');
	$conn = DbHelper::GetConnection();
	$id = -1;
	$task = null;
	if(isset($_GET['id'])) {			//FOR EDIT, OLD
		$id = $_GET['id'];
		$stm = $conn->prepare("SELECT * FROM tasks WHERE id = ?");
		$stm->execute(array($id));
		$tasks = $stm->fetchAll(PDO::FETCH_ASSOC);
		if(count($tasks)) {
			$task = $tasks[0];
		}
	}
?>
<html>
<head>		<!--NEW-->
<style type="text/css">		
.error { background: #d33; color: white; padding: 0.2em; }
</style>	<!--END OF NEW-->
</head>
<body>
	<?php 
		//$missingFields = array();									//NEW
		//function validateField( $fieldName, $missingFields ) {
		//	if ( in_array( $fieldName, $missingFields ) ) {
		//		echo ' class="error"';
		//	}
		//}
		function setValue( $fieldName ) {
			if ( isset( $_POST[$fieldName] ) ) {
				echo $_POST[$fieldName];
			}
		}
														//END OF NEW
		$errors = array();
		
		if(isset($_POST['btnSubmit'])) {
			//$requiredFields = array( "tbTitle");	//NEW
			//$missingFields = array();
			$updateText=null;
			$updateDate=null;
			$updateHour=null;
	
		//	foreach ( $requiredFields as $requiredField ) {
		//		if ( !isset( $_POST[$requiredField] ) or !$_POST[$requiredField] ) {
		//			$missingFields[] = $requiredField;
		//		}
		//	}	
			if($_POST['tbTitle']==null) {
				$errors[] = "Заглавието е Задължително!";
            }												
			if( strlen($_POST['tbTitle']) > 200) {
				$errors[] = "Заглавието е невалидно! Дължина между 1-200 символа";
			}
            if( ($_POST['tbHour']) < 0 || ($_POST['tbHour']) > 23) {
				$errors[] = "Часът трябва да е между 0-23";
			}
			if($_POST['tbText']!=null){ //Alternatively: if(isset($_POST['tbText'])){}
				$updateText=$_POST['tbText'];
			}
			if($_POST['tbDate']!=null){
				$updateDate=$_POST['tbDate'];
			}
			if($_POST['tbHour']!=null){
				$updateHour=$_POST['tbHour'];
			}
			if(count($errors) == 0 && $task == null) {	
				
				/*if($_POST['tbText']==null&&$_POST['tbDate']==null&&$_POST['tbHour']==null){
					//echo '<span> Title only</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title) VALUES(?)');
					$stm->execute(array($_POST['tbTitle']));
				}
				else if($_POST['tbText']!=null&&$_POST['tbDate']==null&&$_POST['tbHour']==null){
					//echo '<span> Title + Text</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title, text) VALUES(?, ?)');
					$stm->execute(array($_POST['tbTitle'], $_POST['tbText']));
				}
				else if($_POST['tbText']==null&&$_POST['tbDate']==null&&$_POST['tbHour']!=null){
					//echo '<span> Title + hour </span>';
					$stm = $conn->prepare('INSERT INTO tasks(title,hour) VALUES(?,?)');
					$stm->execute(array($_POST['tbTitle'], $_POST['tbHour']));
				}	
				else if($_POST['tbText']==null&&$_POST['tbDate']!=null&&$_POST['tbHour']==null){
					//echo '<span> Title + date </span>';
					$stm = $conn->prepare('INSERT INTO tasks(title,date) VALUES(?, ?)');
					$stm->execute(array($_POST['tbTitle'], $_POST['tbDate']));
				}
				else if($_POST['tbText']==null&&$_POST['tbDate']!=null&&$_POST['tbHour']!=null){
					//echo '<span> Title + date and hour</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title date, hour) VALUES(?,?,?)');
					$stm->execute(array($_POST['tbTitle'],$_POST['tbDate'], $_POST['tbHour']));
				}
				else if($_POST['tbText']!=null&&$_POST['tbDate']==null&&$_POST['tbHour']!=null){
					//echo '<span> Title + text and hour</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title, text, hour) VALUES(?,?,?)');
					$stm->execute(array($_POST['tbTitle'], $_POST['tbText'], $_POST['tbHour']));
				}
				else if($_POST['tbText']!=null&&$_POST['tbDate']!=null&&$_POST['tbHour']==null){
					//echo '<span> Title + text and date</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title, text, date) VALUES(?, ?,?)');
					$stm->execute(array($_POST['tbTitle'], $_POST['tbText'], $_POST['tbDate']));
				}
				else {*/
					//echo '<span> All 3</span>';
					$stm = $conn->prepare('INSERT INTO tasks(title, text, date, hour) VALUES(?, ?,?,?)');
					$stm->execute(array($_POST['tbTitle'], $updateText, $updateDate, $updateHour));
					//$stm->execute(array($_POST['tbTitle'], $_POST['tbText'], $_POST['tbDate'], $_POST['tbHour']));
					header("Location: taskTable.php");
			} elseif(count($errors) == 0) {
				
				/*if($_POST['tbText']==null&&$_POST['tbDate']=="0000:00:00"){
					echo '<span> Title only</span>';
					echo $_POST['tbDate'];
					//$stm = $conn->prepare('UPDATE tasks SET title = ? WHERE id = ?');
					//$stm->execute(array($_POST['tbTitle'],$id));
				}
				else if($_POST['tbText']!=null&&$_POST['tbDate']==null&&$_POST['tbHour']==null){
					echo '<span> Title + Text</span>';
					$stm = $conn->prepare('UPDATE tasks SET title=?, text=? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'],$_POST['tbText'], $id));
				}
				else if($_POST['tbText']==null&&$_POST['tbDate']==null&&$_POST['tbHour']!=null){
					echo '<span> Title + hour </span>';
					$stm = $conn->prepare('UPDATE tasks SET title=?,date=?, hour=? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'],NULL,$_POST['tbHour'], $id));
				}
				else if($_POST['tbText']==null&&$_POST['tbDate']!=null&&$_POST['tbHour']==null){
					echo '<span> Title + date </span>';
					$stm = $conn->prepare('UPDATE tasks SET title=?, date=? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'],$_POST['tbDate'], $id));
				}
				else if($_POST['tbText']==null&&$_POST['tbDate']!=null&&$_POST['tbHour']!=null){
					echo '<span> Title + date and hour</span>';
					$stm = $conn->prepare('UPDATE tasks SET title=?, date=?, hour=? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'],$_POST['tbDate'], $_POST['tbHour'], $id));
				}
				//else if($_POST['tbText']!=null&&$_POST['tbDate']==null&&$_POST['tbHour']!=null){
				//	//echo '<span> Title + text and hour</span>';
				//	$stm = $conn->prepare('UPDATE tasks SET title=?, text=?, hour=? WHERE id = ?');
				//	$stm->execute(array($_POST['tbTitle'],$_POST['tbText'], $_POST['tbHour'], $id));
				//}
				else if($_POST['tbText']!=null&&$_POST['tbDate']!=null&&$_POST['tbHour']==null){
					echo '<span> Title + text and date</span>';
					$stm = $conn->prepare('UPDATE tasks SET title=?, text=?, date=? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'],$_POST['tbText'], $_POST['tbDate'], $id));
				}
				else{*/
					//echo '<span> All 3</span>';
					$stm = $conn->prepare('UPDATE tasks SET title = ?, text = ?,date = ?, hour = ? WHERE id = ?');
					$stm->execute(array($_POST['tbTitle'], $updateText, $updateDate, $updateHour, $id));
					//$stm->execute(array($_POST['tbTitle'], $_POST['tbText'], $_POST['tbDate'], $_POST['tbHour'], $id));
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
			<label for="tbTitle">Заглавие:</label>
			<input type="text" id="tbTitle" name="tbTitle" value="<?=($task != null) ? $task["title"] :""?>" />
		</p>
		<p>
			<label for="tbText">Съдържание:</label>
			<input type="text" id="tbText" name="tbText" value="<?=($task != null) ? $task["text"] :""?>" />
		</p>
		<p>
			<label for="tbDate">Дата:</label>
			<input type="date" id="tbDate" name="tbDate" value="<?=($task != null) ? $task["date"] :""?>" />
		</p>
        <p>
			<label for="tbHour" >Час:</label>
			<input type="number" id="tbHour" name="tbHour" value="<?=($task != null) ? $task["hour"] :""?>" />
		</p>
		<p>
			<input type="submit" value="<?=($task == null) ? "Create task" : "Update task" ?>" name="btnSubmit" />
		</p>
		<!--
		<p>
		<label for="birthday">Birthday(USE FOR DATE LATER):</label>
		<input type="date" id="birthday" name="birthday">
		</p>
		-->
	</form>
</body>
</html>