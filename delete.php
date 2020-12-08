<?php
	require_once('db.php');
	$conn = DbHelper::GetConnection();
	$id = -1;
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	if(isset($_POST["btnYes"])) {
		$stm = $conn->prepare("DELETE FROM tasks WHERE id = ?");
		$stm->execute(array($id));
		header("Location: taskTable.php");
	} else if(isset($_POST["btnNo"])) {
		header("Location: taskTable.php");
	}
?>
<html>
	<head></head>
	<body>
		<form method="post">
			<input type="hidden" value="<?= $id ?>" />
			Сигурни ли сте, че искате да изтриете избраната задача?
			<input type="submit" name="btnYes" value="да" />
			<input type="submit" name="btnNo" value="не" />
		</form>
	</body>
</html>