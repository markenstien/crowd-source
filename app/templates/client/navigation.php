<nav class="navbar navbar-custom navbar-fixed-top" role="navigation" style="background:#345feb;">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#sidebar-collapse" aria-expanded="true"><span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span></button>
			<a class="navbar-brand" href="catalog.php"><?php echo SITENAME;?></a>
			<ul class="nav navbar-top-links navbar-right">
				<?php if(! Session::check('user')) :?>
				<li class="dropdown">
					<a href="../client/register.php">
						<em class="fa fa-user-plus"></em>
					</a>
				</li>
				<li class="dropdown">
					<a href="../client/login.php">
						<em class="fa fa-user"></em>
					</a>
				</li>

				<li class="dropdown">
					<a href="../client/landing.php">
						<em class="fa fa-user"></em>About
					</a>
				</li>
				<?php endif;?>
				<?php if(Session::check('user')) :?>
				<li class="dropdown">
					<a href="catalog.php" title="catalog">
						<em class="fa fa-list" title="catalog"></em>
					</a>
				</li>

				<li class="dropdown"><a class="dropdown-toggle count-info" data-toggle="dropdown" href="#" aria-expanded="true">
					<em class="fa fa-user"></em>
				</a>
					<ul class="dropdown-menu dropdown-alerts">
						<li><a href="profile.php">
							<div><em class="fa fa-user"></em> Profile </div>
						</a></li>
						<li><a href="auth_edit.php">
							<div><em class="fa fa-user"></em> Logins </div>
						</a></li>
						<li class="divider"></li>
						<li><a href="contact_edit.php">
							<div><em class="fa fa-user"></em> Contact </div>
						</a></li>
						<li class="divider"></li>
						<li><a href="education_edit.php">
							<div><em class="fa fa-user"></em> Education </div>
						</a></li>
						<li><a href="work_history_edit.php">
							<div><em class="fa fa-user"></em> Workhistory </div>
						</a></li>
						<li class="divider"></li>
						<li><a href="skills_edit.php">
							<div><em class="fa fa-user"></em> Skills </div>
						</a></li>
						<li class="divider"></li>
						<li><a href="logout.php">
							<div><em class="fa fa-sign-out"></em> Logout</div>
						</a></li>
					</ul>
				</li>
				<?php endif;?>
			</ul>
		</div>
	</div><!-- /.container-fluid -->
</nav>