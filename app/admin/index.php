<?php
	require_once '../dependencies.php';

	if(postRequest('readMessage'))
		readMessage($_POST['notifid']);

	$notificationList = getNotifications( " WHERE date(created_at) = date(now()) ORDER BY status desc limit 30");
	$job_list = getJobList( " WHERE date(jobs.created_at) = date(now()) order by jobs.status asc limit 15");
	$applicantList = getApplicantList("WHERE ja.status = 'pending'");

	$summary = getAdminDashboard();

?>
<?php build('breadcrum') ?>
	<?php loadBreadCrumb()?>
<?php endbuild()?>
<?php build('content') ?>
	<div class="row">
		<div class="col-md-3">
			<div class="card mb-2">
		        <div class="card-body">
		            <div class="row align-items-center">
		                <div class="col-5">
		                    <span class="action-icon badge badge-primary-inverse mr-0"><i class="feather icon-user"></i></span>
		                </div>
		                <div class="col-7 text-right">
		                    <h5 class="card-title font-14">Companies</h5>
		                    <h4 class="mb-0"><?php echo $summary['companies']['total']?></h4>
		                </div>
		            </div>
		        </div>
		        <div class="card-footer">
		            <div class="row align-items-center">
		                <div class="col-8">
		                    <span class="font-13">Registered This Week</span>
		                </div>
		                <div class="col-4 text-right">
		                    <span class="badge badge-success"><i class="feather icon-trending-up mr-1"></i><?php echo $summary['companies']['last']?></span>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="card mb-2">
		        <div class="card-body">
		            <div class="row align-items-center">
		                <div class="col-5">
		                    <span class="action-icon badge badge-primary-inverse mr-0"><i class="feather icon-user"></i></span>
		                </div>
		                <div class="col-7 text-right">
		                    <h5 class="card-title font-14">Jobs</h5>
		                    <h4 class="mb-0"><?php echo $summary['jobs']['total']?></h4>
		                </div>
		            </div>
		        </div>
		        <div class="card-footer">
		            <div class="row align-items-center">
		                <div class="col-8">
		                    <span class="font-13">Needs Confirmation</span>
		                </div>
		                <div class="col-4 text-right">
		                    <span class="badge badge-danger"><i class="feather icon-trending-down mr-1"></i><?php echo $summary['jobs']['last']?></span>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="card mb-2">
		        <div class="card-body">
		            <div class="row align-items-center">
		                <div class="col-5">
		                    <span class="action-icon badge badge-primary-inverse mr-0"><i class="feather icon-user"></i></span>
		                </div>
		                <div class="col-7 text-right">
		                    <h5 class="card-title font-14">Users</h5>
		                    <h4 class="mb-0"><?php echo $summary['users']['total']?></h4>
		                </div>
		            </div>
		        </div>
		        <div class="card-footer">
		            <div class="row align-items-center">
		                <div class="col-8">
		                    <span class="font-13">Registered This week</span>
		                </div>
		                <div class="col-4 text-right">
		                    <span class="badge badge-success"><i class="feather icon-trending-up mr-1"></i><?php echo $summary['users']['last']?></span>
		                </div>
		            </div>
		        </div>
		    </div>

		    <div class="card mb-2">
		        <div class="card-body">
		            <div class="row align-items-center">
		                <div class="col-5">
		                    <span class="action-icon badge badge-primary-inverse mr-0"><i class="feather icon-user"></i></span>
		                </div>
		                <div class="col-7 text-right">
		                    <h5 class="card-title font-14">Employment</h5>
		                    <h4 class="mb-0"><?php echo $summary['employment']['total']?></h4>
		                </div>
		            </div>
		        </div>
		        <div class="card-footer">
		            <div class="row align-items-center">
		                <div class="col-8">
		                    <span class="font-13">For Verification</span>
		                </div>
		                <div class="col-4 text-right">
		                    <span class="badge badge-success"><i class="feather icon-trending-up mr-1"></i><?php echo $summary['employment']['last']?></span>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>

		<div class="col-md-6">
			<div class="card mb-2">
				<div class="card-header">
					<h5 class="card-title"> Job posts </h5>
				</div>

				<div class="card-body">
					<div class="row text-center">
						<div class="col-md-4">
							<h3>35</h3>
							<label>Software Development</label>
						</div>
						<div class="col-md-4">
							<h3>35</h3>
							<label>Software Development</label>
						</div>
						<div class="col-md-4">
							<h3>35</h3>
							<label>Software Development</label>
						</div>
					</div>
				</div>
			</div>

			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Applicants</h4>
				</div>

				<div class="card-body">
					<div class="table-responsive">
						<?php $count = 0 ?>
	                    <table class="table table-borderless">
	                        <thead>
	                            <tr>
	                                <th>Company</th>
	                                <th>Name</th>
	                                <th>Position</th>
	                                <th>Action</th>
	                            </tr>
	                        </thead>
	                        <tbody>
	                        	<?php foreach($applicantList as $key => $row) :?>
	                        		<?php if($count > 8) break?>
	                        		<tr>
	                        			<td><?php echo $row['comp_name']?></td>
	                        			<td><?php echo $row['fullname']?></td>
	                        			<td><?php echo $row['position']?></td>
	                        			<td>
	                        				<a href="#"> <i class="fa fa-eye"></i> Show </a>
	                        			</td>
	                        		</tr>
	                        		<?php $count++?>
	                        	<?php endforeach?>                                          
	                        </tbody>
	                    </table>
	                </div>
				</div>

				<div class="card-footer text-center">
					<?php if($count > 8) :?>
						<a href="#">Show more</a>
                    <?php endif?>
				</div>
			</div>
		</div>

		<div class="col-md-3">
			<div class="card">
				<div class="card-header">
					<h4 class="card-title">Top 5 Companies</h4>
				</div>

				<div class="card-body">
					 <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th>Company</th>
                                    <th>Employment</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Chromatic Softwares</td>
                                    <td>100++</td>
                                </tr> 
                                <tr>
                                    <td>Microsoft</td>
                                    <td>100++</td>
                                </tr>    
                                <tr>
                                    <td>Jolibee</td>
                                    <td>100++</td>
                                </tr>    
                                <tr>
                                    <td>SMDC</td>
                                    <td>100++</td>
                                </tr>                                             
                            </tbody>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>
	
<?php endbuild()?>

<?php build('scripts') ?>
 <script src="<?php echo _vendor('orbit/js/custom/custom-dashboard-school.js')?>"></script>
<?php endbuild()?>
<?php loadTo('orbit/app-admin')?>