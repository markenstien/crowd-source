<?php require_once '../dependencies.php';?>

<?php  
	//auth id is the companies id
	$evaluations = getCompanyEvaluations(auth()['id']);
?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		

		<div class="card">
			<div class="card-header">
				<h3>Employee Evaluations</h3>
			</div>

			<div class="card-body">
				<table class="table">
					<thead>
						<th>Season</th>
						<th>ID</th>
						<th>Name</th>
						<th>Criteria</th>
						<th>Remarks</th>
					</thead>

					<tbody>
						<?php foreach($evaluations as $key => $row) :?>
							<tr>
								<td><?php echo $row['season']?></td>
								<td><?php echo $row['employee']['empcode']?></td>
								<td><?php echo $row['employee']['fullname']?></td>
								<td><?php echo $row['criteria']?></td>
								<td><?php echo $row['remarks']?></td>
							</tr>
						<?php endforeach?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>