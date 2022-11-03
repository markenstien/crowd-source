<?php 
	require_once '../dependencies.php';
	$companyList = getCompanyList( " order by id desc ");
?>

<?php build('content') ?>
	<div class="card">
		<div class="card-header">
			<h4 class="card-title">Companies</h4>
		</div>

		<div class="card-body">
			<div class="table-responsive">
				<table class="table dataTable">
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
<?php endbuild()?>

<?php build('headers')?>
	<style type="text/css">
		table img
		{
			width: 75px;
			height: 75px;
		}
	</style>
	<?php dtHead()?>
<?php endbuild()?>

<?php
	build('breadcrum');
		loadBreadCrumb('Companies');
	endbuild();
	loadTo('orbit/app-admin');
?>