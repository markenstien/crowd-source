<?php 
	require_once '../dependencies.php';
	$category_list = getCategoryList();
?>

<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Categories</h4>
		</div>

		<div class="card-body">
			<?php Flash::show('category')?>
			<div class="table-responsive">
				<table class="table dataTable" >
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
<?php endbuild()?>

<?php
	build('breadcrum');
		loadBreadCrumb('Categories');
	endbuild();
	loadTo('orbit/app-admin');
?>