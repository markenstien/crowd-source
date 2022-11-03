<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/user/header.php';?>
<style type="text/css">
	.space-up{
		margin: 5px;
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
		<?php $category_list = getCategoryList();?>
		<?php pageHeader('Category Management') ;?>
		<div class="panel panel-default">
			<?php Flash::show();?>
			<div class="panel-heading">
				Category List
			</div>
			<div class="panel-body">
				<table class="table <?php echo count($category_list) > 10 ? 'dataTable' : ''?>">
					<thead>
						<th>Category</th>
						<th>Description</th>
						<th>Action</th>
					</thead>
					<tbody>
						<?php foreach($category_list as $cat) :?>
							<tr>
								<td><?php echo $cat['category']?></td>
								<td><?php echo $cat['description']?></td>
								<td><a href="category_edit.php?id=<?php echo $cat['id']?>" class="btn btn-primary">Edit</a></td>
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