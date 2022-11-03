<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
	}
	table img
	{
		width: 75px;
		height: 75px;
	}
</style>
</head>
<body>
<?php
	if(postRequest('create'))
	{
		createCategory($_POST);
	}
?>
<?php require_once APPROOT.DS.'templates/user/navigation.php';?>
<?php require_once APPROOT.DS.'templates/user/sidebar.php';?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<?php $companyList = getCompanyList( " order by id desc ");?>
		<?php pageHeader('Company Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<?php Flash::show('company');?>
			<div class="panel-heading">
				Company List
			</div>
			<div class="panel-body">
				<table class="table myTable">
					<thead>
						<th>Company</th>
						<th>Type</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Logo</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($companyList as $comp) :?>
							<tr>
								<td><?php echo $comp['name']?></td>
								<td><?php echo $comp['type']?></td>
								<td><?php echo $comp['email']?></td>
								<td><?php echo $comp['phone']?></td>
								<td><img src="<?php echo URL.DS.'public/assets/'.$comp['logo']?>"></td>
  								<td><a href="company_view.php?id=<?php echo $comp['id']?>" class="btn btn-primary">Preview</a></td>
							</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
<?php require_once APPROOT.DS.'templates/user/scripts.php';?>
<script defer>
	$(document).ready( function () {
	    $('.myTable').DataTable();
	} );
</script>
<?php require_once APPROOT.DS.'templates/user/footer.php';?>