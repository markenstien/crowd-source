<?php require_once '../dependencies.php';?>
	

<?php
	

	if(postRequest('create_account'))
	{

		$userAccount = db_insert( 'users', 
			[
				'username' => $_POST['username'],
				'password' => $_POST['password'],
				'type'     => $_POST['type'],

				'status'   => 'active',
				'is_verified'   => true,
				'done_setup'   => true,
			]
		);

		if($userAccount) 
		{
			$userId = $userAccount;

			$userInfo = db_insert( 'user_informations',
				[
					'userid'   => $userId,
					'firstname' => $_POST['firstname'],
					'lastname' => $_POST['lastname'],
					'email' => $_POST['email'],
					'gender' => $_POST['gender'],
					'birthday' => $_POST['birthday']
				]
			);
		}
	}

?>


<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<h1>Create Account</h1>
	<?php

		FormOpen([
			'method' => 'post'
		]);
	?>

	<table class="table">
		<tbody>
			<tr>
				<td>Username</td>
				<td><?php FormText('username')?></td>
			</tr>

			<tr>
				<td>Password</td>
				<td><?php FormText('password')?></td>
			</tr>

			<tr>
				<td>Type</td>
				<td><?php FormSelect('type' , ['admin' , 'applicant' , 'HR'])?></td>
			</tr>
		</tbody>

		<tbody>
			<tr>
				<td>Firstname</td>
				<td><?php FormText('firstname')?></td>
			</tr>

			<tr>
				<td>Lastname</td>
				<td><?php FormText('lastname')?></td>
			</tr>


			<tr>
				<td>Email</td>
				<td><?php FormText('email')?></td>
			</tr>

			<tr>
				<td>Gender</td>
				<td><?php FormSelect('gender' , ['male' , 'female'])?></td>
			</tr>

			<tr>
				<td>Birthday</td>
				<td><?php FormDate('birthday')?></td>
			</tr>
		</tbody>
	</table>


	<?php
		FormSubmit('create_account' , ' Create Account');
	?>
	<?php FormClose()?>
</body>
</html>