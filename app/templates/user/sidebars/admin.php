<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<div class="profile-sidebar">
		<div class="profile-userpic">
			<?php
				echo convertImage(Session::get('user')['profile'] , null , [
					'class' => 'img-responsive'
				]);
			?>
		</div>
		<div class="profile-usertitle">
			<div class="profile-usertitle-name">Username</div>
			<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="divider"></div>
	<ul class="nav menu">
		<li><a href="index.php"><em class="fa fa-dashboard">&nbsp;</em> Dashboard</a></li>
		<li class="parent "><a data-toggle="collapse" href="#company-sub">
			<em class="fa fa-navicon">&nbsp;</em> Company<span data-toggle="collapse" href="#company-sub" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="company-sub">
				<li>
					<a class="" href="company_create.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create
					</a>
				</li>
				<li>
					<a class="" href="company_list.php">
						<span class="fa fa-arrow-right">&nbsp;</span> List
					</a>
				</li>
			</ul>
		</li>

		<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
			<em class="fa fa-navicon">&nbsp;</em> Job<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-item-1">
				<li>
					<a class="" href="job_create.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create
					</a>
				</li>
				<li>
					<a class="" href="job_list.php">
						<span class="fa fa-arrow-right">&nbsp;</span> List
					</a>
				</li>
			</ul>
		</li>

		<li class="parent "><a data-toggle="collapse" href="#sub-exam">
			<em class="fa fa-navicon">&nbsp;</em> Job Exams<span data-toggle="collapse" href="#sub-exam" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="sub-exam">
				<li>
					<a class="" href="exam_create.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create
					</a>
				</li>
				<li>
					<a class="" href="exam_list.php">
						<span class="fa fa-arrow-right">&nbsp;</span> List
					</a>
				</li>
			</ul>
		</li>

		<li><a href="examination_list.php"><em class="fa fa-user">&nbsp;</em> Exam List</a></li>

		<li class="parent "><a data-toggle="collapse" href="#category">
			<em class="fa fa-navicon">&nbsp;</em> Category<span data-toggle="collapse" href="#category" class="icon pull-right"><em class="fa fa-plus"></em></span>
			</a>
			<ul class="children collapse" id="category">
				<li>
					<a class="" href="category_create.php">
						<span class="fa fa-arrow-right">&nbsp;</span> Create
					</a>
				</li>
				<li>
					<a class="" href="category_list.php">
						<span class="fa fa-arrow-right">&nbsp;</span> List
					</a>
				</li>
			</ul>
		</li>

		<li><a href="application_list.php"><em class="fa fa-user">&nbsp;</em> Applications</a></li>
		<li><a href="employee_list.php"><em class="fa fa-user">&nbsp;</em> Employee 201</a></li>
		<li><a href="reports.php"><em class="fa fa-user">&nbsp;</em> Reports</a></li>
	</ul>
</div><!--/.sidebar-->
<!--/.sidebar-->