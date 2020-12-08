<?php
	require_once('db.php');
?>
<html>
<style>
th{
	background-color: lightgray;
	text-align: center;
}
td{
	background-color: #f1f1f1;
	text-align: center;
}
.description {
  width: 25em;
  text-align: left;
}
.title{
  width: 12em;
  text-align: center;
  vertical-align:top;
}
.alignTop{
  vertical-align:top;
}
</style>
<head>
</head>
<body>
	<?php
		$conn = DbHelper::GetConnection();
		$stm = $conn->query("SELECT * FROM tasks order by id");
		$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
	?>
	<div >
	<table>
		<tr>
			<th>Id</th>
			<th>Заглавие</th>
			<th>Съдържание</th>
			<th>Дата</th>
			<th>Час</th>
			
		</tr>
		<?php
			foreach($rows as $r) {
			?>
				<tr>
					<td class="alignTop"><?=$r["id"]?></td>
					<td class="title"><?=$r["title"]?></td>
					<td class="description"><?=$r["text"]?></td>
					<td class="alignTop"><?=$r["date"]?></td>
                    <td class="alignTop"><?=$r["hour"]?></td>
					<td class="alignTop">
                    &nbsp;&nbsp;<a href="createTask.php?id=<?=$r["id"]?>">Edit</a>
                    &nbsp;&nbsp;<a href="delete.php?id=<?=$r["id"]?>">Delete</a>
					</td>
				</tr>
			<?php
			}
		?>
	</table>
	</div>
	<a href="createTask.php">Create Task</a>
</body>
</html>