<?php
	require_once('db.php');
?>
<html>
<head>
</head>
<body>
	<?php
		$conn = DbHelper::GetConnection();
		$stm = $conn->query("SELECT * FROM users");
		$rows = $stm->fetchAll(PDO::FETCH_ASSOC);
	?>
	<table>
		<tr>
			<th>Id</th>
			<th>Username</th>
			<th>Password</th>
		</tr>
		<?php
			foreach($rows as $r) {
			?>
				<tr>
					<td><?=$r["id"]?></td>
					<td><?=$r["username"]?></td>
					<td> - </td>
				</tr>
			<?php
			}
		?>
	</table>
</body>
</html>