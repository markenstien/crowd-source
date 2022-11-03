<?php require_once '../dependencies.php';?>

<?php require_once APPROOT.DS.'templates/client/header.php';?>
<style type="text/css">
	#banner
	{
		width: 1000px;
		display: block;
		margin: 0px auto;

	}

	#company_container
	{
		width: 1000px;
		display: block;
		margin: 0px auto;
		margin-top: 50px;
	}
	#banner img
	{
		width: 100%;
	}

	.companies
	{
		width: 100%;
		margin-top: 30px;
		background: #fff;
		padding: 20px;
	}
	.company
	{
		width: 150px;
		margin: 30px;
		display: inline-block;
	}
	.company img
	{
		width: 100%;
	}
</style>
</head>
<body>
<?php require_once APPROOT.DS.'templates/client/navigation.php';?>
<?php $companyList = getCompanyList(" LIMIT 10") ;?>
<div class="divider"></div>
	<section>
		<div id="banner">
			<img src="<?php echo URL.DS.'public/banner.jpg'?>">
		</div>
	</section>


	<section id="company_container">

		<article class="text-left" style="line-height: 160%; background: #fff;padding: 10px;">
			<h3>About</h3>
			<hr>
			<div class="row">
				<div class="col-md-5">
					<p>
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
						tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
						quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
						consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
						cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
						proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					</p>
				</div>
				<div class="col-md-6">
					<section>
						<video width="100%" height="240" controls>
						  <source src="<?php echo URL.DS.'public/metrojobs.mp4'?>" type="video/mp4">
						  <source src="<?php echo URL.DS.'public/metrojobs.mp4'?>" type="video/ogg">
						Your browser does not support the video tag.
						</video>
					</section>
				</div>
			</div>
			
		</article>
		<div class="companies">
			<h2 class="text-center">Companies who use <?php echo SITENAME?></h2>
			<?php foreach($companyList as $comp) :?>
				<div class="company">
					<img src="<?php echo URL.DS.'public/assets/'.$comp['logo']?>" title="<?php echo $comp['name']?>">
				</div>
			<?php endforeach;?>
		</div>
		
	</section>
<?php require_once APPROOT.DS.'templates/client/scripts.php';?>
<?php require_once APPROOT.DS.'templates/client/footer.php';?>