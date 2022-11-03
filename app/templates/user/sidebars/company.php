<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
	<div class="profile-sidebar">
		<div class="profile-userpic">
			<?php
				echo convertImage(Session::get('company')['logo'] , null , [
					'class' => 'img-responsive'
				]);
			?>
		</div>
		<div class="profile-usertitle">
			<div class="profile-usertitle-name">
				<?php echo Session::get('company')['name'];?>
			</div>
			<div class="profile-usertitle-status"><span class="indicator label-success"></span>Online</div>
		</div>
		<div class="clear"></div>
	</div>
	<div class="divider"></div>
	<ul class="nav menu">
		<li class="parent "><a data-toggle="collapse" href="#sub-item-1">
			<em class="fa fa-navicon">&nbsp;</em> Job Vacancies<span data-toggle="collapse" href="#sub-item-1" class="icon pull-right"><em class="fa fa-plus"></em></span>
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

		<li><a href="application_list.php"><em class="fa fa-user">&nbsp;</em> Applicants </a></li>
		<li><a href="appointment_list.php"><em class="fa fa-user">&nbsp;</em> Schedules </a></li>
		<li><a href="employee_list.php"><em class="fa fa-user">&nbsp;</em> Employees </a></li>
		<li><a href="evaluation_list.php"><em class="fa fa-user">&nbsp;</em> Employee Evaluations </a></li>
		<li><a href="settings.php"><em class="fa fa-gear">&nbsp;</em> Settings </a></li>
		<li><a href="logout.php"><em class="fa fa-sign-out">&nbsp;</em> Logout</a></li>
	</ul>
</div><!--/.sidebar-->
<!--/.sidebar-->