<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
</head>
<body>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php pageHeader('Job Management') ;?>
		<?php  $job = getJob($_GET['id']) ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Job View
			</div>

			<div class="panel-body">
				<section>
					<h3>Job Information</h3>
					<ul>
						<li>Company : <?php echo $job['comp_name']?></li>
						<li>Status : <?php echo $job['status']?></li>
						<li>Date : <?php echo $job['date_posted']?></li>
						<li>Title : <?php echo $job['title']?></li>
						<li>Sub Info : <?php echo $job['sub_title']?></li>
						<li>Position : <?php echo $job['position']?></li>
						<li>Salary : <?php echo $job['salary']?></li>
						<li>Payment Type : <?php echo $job['salary_type']?></li>
					</ul>
					<h3>Other information</h3>
					<ul>
						<li>Phone : <?php echo $job['phone']?></li>
						<li>Email : <?php echo $job['email']?></li>
						<li>Address : <?php echo $job['address']?></li>
						<li>Notes : <?php echo $job['notes']?></li>
					</ul>
				</section>

				<section>
					<form method="post">
						<input type="submit" name="" value="Post Job" class="btn btn-primary">
						<a href="job_edit.php?id=<?php echo $job['id']?>" class="btn btn-info">Edit</a>
					</form>
				</section>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>