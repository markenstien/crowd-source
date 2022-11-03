<?php require_once '../dependencies.php';?>

<?php
	
	if(postRequest('send_email'))
	{
		$emailBody = mailTemplate($_POST['message']);

		_mail($_POST['email'] , "Email Testing" , $emailBody);
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

	<?php
		FormOpen([
			'method' => 'post'
		]);
	?>

	<table>
		<thead>
			<th>Message</th>
			<th>Email</th>
		</thead>

		<tbody>
			<td>
				<?php FormTextarea('message')?>
			</td>
			<td>
				<?php FormText('email')?>
			</td>
		</tbody>
	</table>

	<input type="submit" name="send_email" value="Send Email">
	<?php FormClose()?>
</body>	
</html>