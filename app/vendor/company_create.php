<?php require_once '../dependencies.php';?>

<?php

	if(postRequest('create_company'))
	{
		$path = BASEROOT.DS.'public/assets/';

		$logo = uploadSingle('logo' , $path);
		$banner = uploadSingle('banner' , $path);


		$insert = db_insert('companies' , [
			'username'       => $_POST['username'],
			'password'       => $_POST['password'],
			'name'           => $_POST['name'],
			'description'    => $_POST['description'],
			'type'           => $_POST['type'],
			'address'        => $_POST['address'],
			'email'          => $_POST['email'],
			'phone'          => $_POST['phone'],
			'contact_person' => $_POST['contact_person'],

			'banner' => $banner['name'],
			'logo'   => $logo['name']
		]);
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
		FormOpenMeta([
			'method' => 'post'
		]);
	?>	

	<table class="table">
		<tr>
			<td>Username</td>
			<td>
				<?php FormText('username')?>
			</td>
		</tr>
		<tr>
			<td>Password</td>
			<td>
				<?php FormText('password')?>
			</td>
		</tr>

		<tr>
			<td>Name</td>
			<td>
				<?php FormText('name')?>
			</td>
		</tr>

		<tr>
			<td>Description</td>
			<td>
				<?php FormText('description')?>
			</td>
		</tr>

		<tr>
			<td>Type</td>
			<td>
				<?php FormText('type')?>
			</td>
		</tr>


		<tr>
			<td>Address</td>
			<td>
				<?php FormText('address')?>
			</td>
		</tr>

		<tr>
			<td>Email</td>
			<td>
				<?php FormText('email')?>
			</td>
		</tr>

		<tr>
			<td>Phone</td>
			<td>
				<?php FormText('phone')?>
			</td>
		</tr>

		<tr>
			<td>Contact</td>
			<td>
				<?php FormText('contact_person')?>
			</td>
		</tr>

		<tr>
			<td>Banner</td>
			<td>
				<?php FormFile('banner')?>
			</td>
		</tr>

		<tr>
			<td>Logo</td>
			<td>
				<?php FormFile('logo')?>
			</td>
		</tr>
	</table>

	<?php
		FormSubmit('create_company' , 'Create Company');
	?>
	<?php FormClose()?>
</body>
</html>