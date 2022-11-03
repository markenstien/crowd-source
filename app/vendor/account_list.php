<?php require_once '../dependencies.php';?>


<?php
	
	if(isset($_GET['deleteuser']))
	{

		$userId = $_GET['deleteuser'];

		$db = DB::getInstance();

		$db->query(
			"DELETE FROM users where id = '$userId' "
		);


		$db->query("DELETE FROM user_informations where userid = '$userId' ");

		return redirect('account_list.php');
	}

	$accountList = getUsers();
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<table>
		<thead>
			<th>Name</th>
			<th>Username</th>
			<th>Password</th>
			<th>Email</th>
			<th>Phone Number</th>
			<th>Action</th>
		</thead>

		<tbody>
			<?php foreach($accountList as $key => $row) :?>
				<tr>
					<td><?php echo $row['fullname']?></td>
					<td><?php echo $row['username']?></td>
					<td><?php echo $row['password']?></td>
					<td><?php echo $row['email']?></td>
					<td><?php echo $row['phone']?></td>
					<td>
						<a href="?deleteuser=<?php echo $row['id']?>"> Delete </a>
					</td>
				</tr>
			<?php endforeach?>
		</tbody>
	</table>
</body>
</html>