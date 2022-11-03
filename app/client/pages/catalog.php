<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>

<style type="text/css">
	.job{
		background: #fff;
		margin-bottom: 10px;
		padding: 10px 15px;
	}
	.job .job-logo img{
		min-width: 100px;
	}

	.job_list{
		padding: 10px;
		background: #eee;
	}

</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
	<div class="col-md-12">
		<?php $job_list = getJobList(" WHERE jobs.status = 'posted' ");?>
		<?php $jobListRelated = getRelatedJobList();?>
		
		<?php $categoryList = getCategoryList(" order by category asc"); ?>

		<?php

			if(isset($_GET['keyword']) && !isset($_GET['advancesearch']))
			{
				$job_list = searchJobKeyword(trim($_GET['keyword']));
			}


			if(isset($_GET['advancesearch']))
			{
				$job_list = jobAdvanceSearch($_GET);
			}
		?>
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header"></h1>
			</div>
		</div>

		<section class="row justify-content-center">
			<div class="col-md-3">
				<div class="panel panel-default">
					<div class="panel-heading">
						Search Criteria
					</div>
					<div class="panel-body">
						<form method="get">
							<div class="form-group">
								<label>Keyword</label>
								<input type="text" name="keyword" placeholder="Job title or keywords" class="form-control" 
								value="<?php echo $_GET['keyword'] ?? ''?>">
								<small>Search by Tags eg: #software</small>
							</div>
							<div class="form-group">
								<input type="submit" name="" value="Apply Filter" class="btn btn-primary">
							</div>
						</form>
						<form method="get">
							<legend>Advance Filter</legend>
							<input type="hidden" name="keyword">
							<div class="form-group">
								<label>Category</label>
								<select name="categories" class="form-control">
									<?php foreach($categoryList as $category) :?>
										<option value="<?php echo $category['category']?>"><?php echo $category['category']?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group">
								<label>Position</label>
								<input type="text" name="position" placeholder="eg.graphic artist , programmer" class="form-control" 
								value="<?php echo $_GET['position'] ?? ''?>">
							</div>
							<div class="form-group">
								<label>Starting Salary</label>
								<input type="text" name="salary" placeholder="150" class="form-control" 
								value="<?php echo $_GET['salary'] ?? ''?>">
							</div>

							<div class="form-group">
								<label>Salary Type</label>
								<select class="form-control" name="salary_type">
									<?php foreach(salary_type_list() as $salary_type) :?>
										<option value="<?php echo $salary_type?>"><?php echo $salary_type?></option>
									<?php endforeach;?>
								</select>
							</div>
							<div class="form-group">
								<label>Location</label>
								<input type="text" name="address" placeholder="Quezon City , Commonwealth" class="form-control" 
								value="<?php echo $_GET['address'] ?? ''?>">
							</div>

							<input type="submit" name="advancesearch" value="Apply Filter" class="btn btn-primary">
						</form>
						<?php if(isset($_GET['keyword'])) :?>
							<div style="padding: 10px;">
								<a href="catalog.php" class="btn btn-block btn-warning">Remove Filter</a>
							</div>
						<?php endif;?>
					</div>
				</div>
			</div>

			<div class="col-md-7">
				<!-- RELATED -->
				<?php Flash::show();?>
				<?php if(Session::check('user') && !empty($jobListRelated)) :?>

					<?php if(!isset($_GET['keyword'])):?>
						<div class="panel panel-default">
							<?php Flash::show();?>
							<div class="panel-heading">
								Job Search Result.<?php echo count($jobListRelated)?>
							</div>

							<div class="panel-body">
								<section class="relatedJobs job_list">
									<div><h2>Jobs That matched your skills</h2></div>
									<?php foreach($jobListRelated as $job) :?>
									<div class="job">
										<div class="row">
											<div class="col-md-9">
												<div class="row">
													<div class="col-md-9">
														<a href="job_view.php?id=<?php echo $job['id']?>">
															<h3><?php echo $job['position']?> - <?php echo $job['title']?></h3>
															<a href="#"><?php echo $job['comp_name']?></a>
														</a>
													</div>

													<div class="col-md-3">
														<img src="<?php echo URL.DS.'public/assets/'.$job['logo']?>">
													</div>
												</div>
												<div class="job-desc">
													<div>
														<p><?php echo $job['address']?></p>
													</div>
													<div>
														<p><?php echo $job['notes']?></p>
													</div>
													<div class="row">
														<dl class="col-md-5">
															<dd><?php echo $job['email']?></dd>
															<dt>Email</dt>
															<dd><?php echo $job['phone']?></dd>
															<dt>Phone</dt>
															<dd><?php echo $job['urgency']?></dd>
															<dt>Urgency</dt>
														</dl>

														<dl class="col-md-5">
															<dd><?php echo to_money($job['salary'])?></dd>
															<dt>Salary</dt>
															<dd><?php echo $job['salary_type']?></dd>
															<dt>Salary Type</dt>
															<dd><?php echo $job['duration']?></dd>
															<dt>Duration</dt>
															<dd><?php echo totalEmployed($job['id']) .' out of '.$job['employee_needed']?></dd>
															<dt>Employee Needed</dt>
														</dl>
													</div>
												</div>
											</div>
										</div>
										<div>
											<small>Time posted : <?php echo $job['created_at']?></small>
											<?php if(!empty($job['categories'])):?>
												<?php $categoryList = explode(','  , $job['categories']);?>
												<div>
													Tags : <?php foreach($categoryList as $category) :?>
														<a href="catalog.php?keyword=<?php echo $category?>">#<?php echo $category?></a>
													<?php endforeach;?>
												</div>
											<?php endif;?>								
										</div>
									</div>
									<?php endforeach;?>
								</section>
							</div>
						</div>
					<?php endif;?>
				<?php endif;?>
				<!-- RELATED -->


				<!-- ALL JOBS -->
				<section class="job_list">
					<div><h2><?php echo isset($_GET['keyword']) ? 'Search Result' : 'Other Jobs'?></h2></div>
					<?php if(!empty($job_list)):?>
						<?php foreach($job_list as $job):?>
							<div class="job">
								<div class="row">
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-9">
												<a href="job_view.php?id=<?php echo $job['id']?>">
													<h3><?php echo $job['position']?> - <?php echo $job['title']?></h3>
													<a href="#"><?php echo $job['comp_name']?></a>
												</a>
											</div>

											<div class="col-md-3">
												<img src="<?php echo URL.DS.'public/assets/'.$job['logo']?>">
											</div>
										</div>
										<div class="job-desc">
											<div>
												<p><?php echo $job['address']?></p>
											</div>
											<div>
												<p><?php echo $job['notes']?></p>
											</div>
											<div class="row">
												<dl class="col-md-5">
													<dd><?php echo $job['email']?></dd>
													<dt>Email</dt>
													<dd><?php echo $job['phone']?></dd>
													<dt>Phone</dt>
													<dd><?php echo $job['urgency']?></dd>
													<dt>Urgency</dt>
												</dl>

												<dl class="col-md-5">
													<dd><?php echo to_money($job['salary'])?></dd>
													<dt>Salary</dt>
													<dd><?php echo $job['salary_type']?></dd>
													<dt>Salary Type</dt>
													<dd><?php echo $job['duration']?></dd>
													<dt>Duration</dt>
													<dd><?php echo totalEmployed($job['id']) .' out of '.$job['employee_needed']?></dd>
													<dt>Employee Needed</dt>
												</dl>
											</div>
										</div>
									</div>
								</div>
								<div>
									<small>Time posted : <?php echo $job['created_at']?></small>
									<?php if(!empty($job['categories'])):?>
										<?php $categoryList = explode(','  , $job['categories']);?>
										<div>
											Tags : <?php foreach($categoryList as $category) :?>
												<a href="catalog.php?keyword=<?php echo $category?>">#<?php echo $category?></a>
											<?php endforeach;?>
										</div>
									<?php endif;?>								
								</div>
							</div>
						<?php endforeach;?>
						<?php else:?>
							<p>No result</p>
					<?php endif;?>
				</section>
				<!--// ALL JOBS -->
			</div>
		</section> 
	</div>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>